<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    unset($_SESSION['gagal_login'][$username]);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['role']    = $user['role'];

    if (!empty($_POST['ingat'])) {
        $token = bin2hex(random_bytes(32));
        $pdo->prepare("UPDATE users SET remember_token = :t WHERE id = :id")
            ->execute(['t' => hash('sha256', $token), 'id' => $user['id']]);
        setcookie('remember_token', $user['id'] . ':' . $token, [
            'expires'  => time() + 60 * 60 * 24 * 30,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }

    header('Location: ../index.php');
    exit;
}

$_SESSION['gagal_login'][$username] = ($_SESSION['gagal_login'][$username] ?? 0) + 1;

$pesan = 'Username atau password salah.';
if ($_SESSION['gagal_login'][$username] >= 3) {
    $pesan .= ' Peringatan: sudah ' . $_SESSION['gagal_login'][$username] . ' kali gagal berturut-turut!';
}

$_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesan];
header('Location: login.php');
exit;