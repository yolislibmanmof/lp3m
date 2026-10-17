<?php

require dirname(__DIR__) . '/app/bootstrap.php';

$email = 'admin@unimof.ac.id';
$password = 'admin123';
$name = 'Admin LP3M';
$role = 'super_admin';

$pdo = Database::pdo();

$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo 'Admin sudah ada.';
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO users (name, email, password, role, is_active)
     VALUES (?, ?, ?, ?, 1)'
);

$stmt->execute([
    $name,
    $email,
    password_hash($password, PASSWORD_DEFAULT),
    $role,
]);

echo 'Admin berhasil dibuat.' . PHP_EOL;
echo 'Email: ' . $email . PHP_EOL;
echo 'Password: admin123' . PHP_EOL;
echo 'Segera ganti password setelah masuk produksi.' . PHP_EOL;