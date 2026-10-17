<?php
/** @var array $b broadcast · @var array $r penerima · @var array $site · @var string $unsubUrl */
$brand = e($site['site_brand'] ?? 'LP3M UNIMOF');
$nama = $r['name'] !== '' ? e($r['name']) : 'Rekan Civitas';
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0; padding:0; background:#f1f5f2; font-family:Segoe UI, Arial, sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f2; padding:28px 12px;">
  <tr><td align="center">
    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(3,37,31,.12);">
      <!-- HEADER -->
      <tr>
        <td style="background:linear-gradient(135deg,#065f46 0%,#059669 60%,#10b981 100%); padding:28px 32px;">
          <table role="presentation" width="100%"><tr>
            <td style="color:#fde68a; font-size:11px; font-weight:800; letter-spacing:.18em; text-transform:uppercase;">📬 Newsletter Resmi</td>
          </tr><tr>
            <td style="color:#ffffff; font-size:22px; font-weight:900; padding-top:6px;"><?= $brand ?></td>
          </tr></table>
        </td>
      </tr>
      <!-- BODY -->
      <tr>
        <td style="padding:30px 34px;">
          <p style="margin:0 0 14px; font-size:14px; color:#52705c;">Halo <strong style="color:#065f46;"><?= $nama ?></strong>,</p>
          <h1 style="margin:0 0 16px; font-size:21px; font-weight:900; color:#03251f; line-height:1.35;"><?= e($b['title']) ?></h1>
          <div style="font-size:14px; line-height:1.75; color:#374151;"><?= nl2br(e($b['content'])) ?></div>
        </td>
      </tr>
      <!-- CTA -->
      <tr>
        <td style="padding:0 34px 28px;">
          <a href="<?= e(url('public/index.php?page=home')) ?>" style="display:inline-block; padding:12px 26px; border-radius:12px; background:linear-gradient(145deg,#fde68a,#d9a441); color:#03251f; font-size:13px; font-weight:800; text-decoration:none;">Kunjungi Website LP3M →</a>
        </td>
      </tr>
      <!-- FOOTER -->
      <tr>
        <td style="background:#043b2c; padding:22px 34px;">
          <p style="margin:0 0 8px; font-size:11px; color:rgba(255,255,255,.7); line-height:1.6;">
            Anda menerima email ini karena terdaftar sebagai <?= e($r['role'] === 'subscriber' ? 'subscriber newsletter' : 'pengguna sistem (' . $r['role'] . ')') ?> <?= $brand ?>.
          </p>
          <?php if ($unsubUrl !== ''): ?>
          <p style="margin:0; font-size:11px;">
            <a href="<?= e($unsubUrl) ?>" style="color:#fde68a; text-decoration:underline;">Berhenti berlangganan</a>
            <span style="color:rgba(255,255,255,.5);"> · © <?= date('Y') ?> <?= $brand ?> · Fastabiqul Khairat</span>
          </p>
          <?php else: ?>
          <p style="margin:0; font-size:11px; color:rgba(255,255,255,.5);">© <?= date('Y') ?> <?= $brand ?> · Fastabiqul Khairat</p>
          <?php endif; ?>
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>