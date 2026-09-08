<?php

declare(strict_types=1);

class TextExtractor
{
    private static bool $limitsRaised = false;

    public static function extract(string $filePath, string $ext): array
    {
        self::raiseLimits();
        $ext = strtolower($ext);
        if ($ext === 'txt' || $ext === 'md') return self::fromPlain($filePath);
        if ($ext === 'docx') return self::fromDocx($filePath);
        if ($ext === 'pdf')  return self::fromPdf($filePath);
        if ($ext === 'doc')  return ['text' => '', 'method' => 'error:doc_legacy', 'pages' => 0, 'chars' => 0];
        return ['text' => '', 'method' => 'unsupported', 'pages' => 0, 'chars' => 0];
    }

    private static function raiseLimits(): void
    {
        if (self::$limitsRaised) return;
        @ini_set('memory_limit', '1024M');
        @ini_set('pcre.backtrack_limit', '50000000');
        @ini_set('pcre.recursion_limit', '500000');
        @set_time_limit(600);
        self::$limitsRaised = true;
    }

    /** Paksa string jadi UTF-8 valid + buang byte kontrol (ANTI error 1366) */
    public static function toValidUtf8(string $s): string
    {
        if ($s === '') return '';
        // Deteksi UTF-16 (LE/BE) lewat pola null-byte, dengan atau tanpa BOM
        if (strpos($s, "\x00") !== false) {
            $le = (substr($s, 1, 1) === "\x00");
            $conv = @mb_convert_encoding($s, 'UTF-8', $le ? 'UTF-16LE' : 'UTF-16BE');
            if ($conv !== false && $conv !== null && strpos($conv, "\x00") === false) $s = $conv;
        }
        // Buang semua byte yang bukan UTF-8 valid
        $clean = @iconv('UTF-8', 'UTF-8//IGNORE', $s);
        if ($clean === false || $clean === null) $clean = '';
        // Buang byte kontrol kecuali \n \r \t
        $clean = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $clean);
        return $clean === null ? '' : $clean;
    }

    /** Tolak teks sampah: terlalu pendek atau rasio karakter terbaca < 60% */
    private static function qualityOk(string $text): bool
    {
        $len = mb_strlen($text);
        if ($len < 50) return false;
        $printable = preg_match_all('/[\p{L}\p{N}\p{P}\p{Z}]/u', $text);
        if ($printable === false) return false;
        return ($printable / $len) >= 0.6;
    }

    private static function fromPlain(string $path): array
    {
        $text = @file_get_contents($path);
        if ($text === false) return ['text' => '', 'method' => 'error:read', 'pages' => 0, 'chars' => 0];
        $text = self::toValidUtf8($text);
        $text = trim($text);
        if (!self::qualityOk($text)) return ['text' => '', 'method' => 'error:no_text_layer', 'pages' => 1, 'chars' => mb_strlen($text)];
        return ['text' => $text, 'method' => 'direct', 'pages' => 1, 'chars' => mb_strlen($text)];
    }

    private static function fromDocx(string $path): array
    {
        if (!class_exists('ZipArchive')) return ['text' => '', 'method' => 'error:zip_missing', 'pages' => 0, 'chars' => 0];
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) return ['text' => '', 'method' => 'error:zip_open', 'pages' => 0, 'chars' => 0];
        $xml = $zip->getFromName('word/document.xml');
        $zip->close();
        if ($xml === false) return ['text' => '', 'method' => 'error:no_xml', 'pages' => 0, 'chars' => 0];

        $xml = preg_replace('/<\/w:p>/i', "\n", $xml) ?? $xml;
        $xml = preg_replace('/<w:tab[^>]*\/>/i', "\t", $xml) ?? $xml;
        $xml = preg_replace('/<w:br[^>]*\/>/i', "\n", $xml) ?? $xml;
        $text = strip_tags($xml);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = self::toValidUtf8($text);
        $text = trim($text);

        if (!self::qualityOk($text)) return ['text' => '', 'method' => 'error:no_text_layer', 'pages' => 1, 'chars' => mb_strlen($text)];
        return ['text' => $text, 'method' => 'docx_auto', 'pages' => 1, 'chars' => mb_strlen($text)];
    }

    private static function fromPdf(string $path): array
    {
        $raw = @file_get_contents($path);
        if ($raw === false) return ['text' => '', 'method' => 'error:read', 'pages' => 0, 'chars' => 0];
        if (stripos($raw, '/Encrypt') !== false) return ['text' => '', 'method' => 'error:encrypted', 'pages' => 0, 'chars' => 0];

        $pages = preg_match_all('/\/Type\s*\/Page[^s]/', $raw);
        if ($pages === false || $pages < 1) $pages = 1;

        $text = '';
        $len = strlen($raw);
        $pos = 0;
        $guard = 0;
        while (($s = strpos($raw, 'stream', $pos)) !== false && $guard < 20000) {
            $guard++;
            $start = $s + 6;
            if ($start < $len && $raw[$start] === "\r") $start++;
            if ($start < $len && $raw[$start] === "\n") $start++;
            $e = strpos($raw, 'endstream', $start);
            if ($e === false) break;
            $stream = substr($raw, $start, $e - $start);
            $pos = $e + 9;

            $dec = @zlib_decode($stream);
            if ($dec === false) $dec = @gzinflate($stream);
            if ($dec === false) $dec = @gzuncompress($stream);
            if ($dec === false) {
                if (strpos($stream, 'Tj') !== false || strpos($stream, 'TJ') !== false) $dec = $stream;
                else continue;
            }

            $t = self::operatorsText($dec);
            if ($t !== '') $text .= $t . "\n";
            if (strlen($text) > 6000000) break;
        }

        // SANITASI TOTAL: UTF-16 mentah & byte invalid dibersihkan di sini
        $text = self::toValidUtf8($text);
        $norm = preg_replace('/\s+/u', ' ', $text);
        if ($norm === null) $norm = preg_replace('/\s+/', ' ', $text);
        $text = trim((string) $norm);

        if (!self::qualityOk($text)) return ['text' => '', 'method' => 'error:no_text_layer', 'pages' => (int) $pages, 'chars' => mb_strlen($text)];
        return ['text' => $text, 'method' => 'pdf_auto', 'pages' => (int) $pages, 'chars' => mb_strlen($text)];
    }

    private static function operatorsText(string $s): string
    {
        $out = [];

        if (preg_match_all('/\[([^\[\]]*)\]\s*TJ/s', $s, $m)) {
            foreach ($m[1] as $chunk) {
                $line = '';
                if (preg_match_all('/\(((?:[^()\\\\]|\\\\.)*)\)|<([0-9A-Fa-f\s]*)>/s', $chunk, $sm, PREG_SET_ORDER)) {
                    foreach ($sm as $g) {
                        if (($g[1] ?? '') !== '') $line .= self::pdfString($g[1]);
                        elseif (($g[2] ?? '') !== '') $line .= self::hexString($g[2]);
                    }
                }
                if ($line !== '') $out[] = $line;
            }
        }

        if (preg_match_all('/\(((?:[^()\\\\]|\\\\.)*)\)\s*Tj/s', $s, $m)) {
            foreach ($m[1] as $g) $out[] = self::pdfString((string) $g);
        }

        if (preg_match_all('/<([0-9A-Fa-f\s]*)>\s*Tj/s', $s, $m)) {
            foreach ($m[1] as $g) $out[] = self::hexString((string) $g);
        }

        if (preg_match_all('/\(((?:[^()\\\\]|\\\\.)*)\)\s*[\'"]/s', $s, $m)) {
            foreach ($m[1] as $g) $out[] = self::pdfString((string) $g);
        }

        return implode(' ', $out);
    }

    private static function pdfString(string $s): string
    {
        $out = '';
        $len = strlen($s);
        for ($i = 0; $i < $len; $i++) {
            $c = $s[$i];
            if ($c === '\\' && $i + 1 < $len) {
                $n = $s[$i + 1];
                if ($n === 'n')      { $out .= "\n"; $i++; }
                elseif ($n === 'r')  { $out .= "\r"; $i++; }
                elseif ($n === 't')  { $out .= "\t"; $i++; }
                elseif ($n === 'b')  { $out .= "\x08"; $i++; }
                elseif ($n === 'f')  { $out .= "\f"; $i++; }
                elseif ($n === '(')  { $out .= '('; $i++; }
                elseif ($n === ')')  { $out .= ')'; $i++; }
                elseif ($n === '\\') { $out .= '\\'; $i++; }
                elseif (ctype_digit($n)) {
                    $oct = $n; $i++;
                    for ($k = 0; $k < 2 && $i + 1 < $len && ctype_digit($s[$i + 1]); $k++) { $i++; $oct .= $s[$i]; }
                    $out .= chr(octdec($oct));
                } else { $i++; }
            } else {
                $out .= $c;
            }
        }
        return $out;
    }

    private static function hexString(string $hex): string
    {
        $hex = preg_replace('/[^0-9A-Fa-f]/', '', $hex) ?? '';
        if ($hex === '') return '';
        if (strlen($hex) % 2 !== 0) $hex .= '0';
        $bin = hex2bin($hex);
        if ($bin === false) return '';
        // UTF-16 dengan BOM
        if (strlen($bin) >= 2 && ord($bin[0]) === 0xFE && ord($bin[1]) === 0xFF) {
            $conv = mb_convert_encoding(substr($bin, 2), 'UTF-8', 'UTF-16BE');
            return $conv === false ? '' : $conv;
        }
        if (strlen($bin) >= 2 && ord($bin[0]) === 0xFF && ord($bin[1]) === 0xFE) {
            $conv = mb_convert_encoding(substr($bin, 2), 'UTF-8', 'UTF-16LE');
            return $conv === false ? '' : $conv;
        }
        // UTF-16BE tanpa BOM (pola null di byte genap)
        if (strlen($bin) >= 4 && substr($bin, 1, 1) === "\x00" && substr($bin, 3, 1) === "\x00") {
            $conv = mb_convert_encoding($bin, 'UTF-8', 'UTF-16BE');
            return $conv === false ? '' : $conv;
        }
        return $bin;
    }
}