<?php

declare(strict_types=1);

/**
 * Pengirim email HTML: driver mail() native ATAU SMTP client murni PHP.
 * Kompatibel: Gmail App Password · Brevo · cPanel · Office365.
 */
class MailSender
{
    public static function config(): array
    {
        $file = BASE_PATH . '/config/mail.php';
        $cfg = is_file($file) ? (array) require $file : [];
        return array_merge([
            'driver' => 'mail', 'host' => '', 'port' => 465,
            'encryption' => 'ssl', 'username' => '', 'password' => '',
            'from_email' => '', 'from_name' => '', 'timeout' => 15,
        ], $cfg);
    }

    public static function from(): array
    {
        try { $s = Setting::all(); } catch (\Throwable $e) { $s = []; }
        $cfg = self::config();
        $host = parse_url(BASE_URL, PHP_URL_HOST) ?: 'localhost';
        return [
            'email' => $cfg['from_email'] !== ''
                ? $cfg['from_email']
                : ($cfg['username'] !== '' ? $cfg['username'] : ($s['mail_from'] ?? ('no-reply@' . $host))),
            'name'  => $cfg['from_name'] !== ''
                ? $cfg['from_name']
                : ($s['mail_from_name'] ?? ($s['site_brand'] ?? 'LP3M UNIMOF')),
        ];
    }

    public static function sendHtml(string $to, string $subject, string $htmlBody): bool
    {
        $cfg = self::config();
        if ($cfg['driver'] === 'smtp' && $cfg['host'] !== '') {
            return self::sendSmtp($to, $subject, $htmlBody, $cfg);
        }
        return self::sendMail($to, $subject, $htmlBody);
    }

    private static function sendMail(string $to, string $subject, string $htmlBody): bool
    {
        $from = self::from();
        $headers = "MIME-Version: 1.0\r\n"
            . "Content-Type: text/html; charset=UTF-8\r\n"
            . "From: =?UTF-8?B?" . base64_encode($from['name']) . "?= <{$from['email']}>\r\n"
            . "Reply-To: {$from['email']}\r\n"
            . "X-Mailer: LP3M-UNIMOF/1.0\r\n";
        return (bool) @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $htmlBody, $headers);
    }

    private static function sendSmtp(string $to, string $subject, string $htmlBody, array $cfg): bool
    {
        $remote = ($cfg['encryption'] === 'ssl' ? 'ssl://' : '') . $cfg['host'];
        $ctx = stream_context_create(['ssl' => [
            'allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false,
        ]]);
        $timeout = (int) ($cfg['timeout'] ?? 15);
        $fp = @stream_socket_client($remote . ':' . (int) $cfg['port'], $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) return false;
        stream_set_timeout($fp, $timeout);

        $read = function () use ($fp): string {
            $data = '';
            while (($line = fgets($fp, 512)) !== false) {
                $data .= $line;
                if (isset($line[3]) && $line[3] === ' ') break;
            }
            return $data;
        };
        $cmd = function (string $c, string $expect) use ($fp, $read): bool {
            fwrite($fp, $c . "\r\n");
            $r = $read();
            return $r !== '' && strpos($r, $expect) === 0;
        };

        try {
            $read();
            $ehlo = parse_url(BASE_URL, PHP_URL_HOST) ?: 'localhost';
            if (!$cmd('EHLO ' . $ehlo, '250')) return false;

            if ($cfg['encryption'] === 'tls') {
                if (!$cmd('STARTTLS', '220')) return false;
                if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) return false;
                if (!$cmd('EHLO ' . $ehlo, '250')) return false;
            }

            if ($cfg['username'] !== '') {
                if (!$cmd('AUTH LOGIN', '334')) return false;
                if (!$cmd(base64_encode($cfg['username']), '334')) return false;
                $pass = str_replace(' ', '', (string) $cfg['password']);
                if (!$cmd(base64_encode($pass), '235')) return false;
            }

            $from = self::from();
            if (!$cmd('MAIL FROM:<' . $from['email'] . '>', '250')) return false;
            if (!$cmd('RCPT TO:<' . $to . '>', '25')) return false;
            if (!$cmd('DATA', '354')) return false;

            $headers = "MIME-Version: 1.0\r\n"
                . "Date: " . date('r') . "\r\n"
                . "To: <{$to}>\r\n"
                . "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n"
                . "Content-Type: text/html; charset=UTF-8\r\n"
                . "From: =?UTF-8?B?" . base64_encode($from['name']) . "?= <{$from['email']}>\r\n"
                . "Reply-To: {$from['email']}\r\n"
                . "X-Mailer: LP3M-UNIMOF/1.0\r\n\r\n";

            $body = str_replace("\r\n.", "\r\n..", $htmlBody);
            fwrite($fp, $headers . $body . "\r\n.\r\n");
            $r = $read();
            $ok = strpos($r, '250') === 0;
            @fwrite($fp, "QUIT\r\n");
            return $ok;
        } catch (\Throwable $e) {
            return false;
        } finally {
            @fclose($fp);
        }
    }
}