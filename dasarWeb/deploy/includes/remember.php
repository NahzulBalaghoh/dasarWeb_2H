<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $bagian = explode(':', $_COOKIE['remember_token'], 2); 
    $valid  = false;

    if (count($bagian) === 2 && ctype_digit($bagian[0])) {
        require_once __DIR__ . '/koneksi.php';
        $cek = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $cek->execute(['id' => $bagian[0]]);
        $akun = $cek->fetch(PDO::FETCH_ASSOC);

        if ($akun && !empty($akun['remember_token'])
            && hash_equals($akun['remember_token'], hash('sha256', $bagian[1]))) {
            $_SESSION['user_id'] = $akun['id'];
            $_SESSION['nama']    = $akun['nama'];
            $_SESSION['role']    = $akun['role'];
            $valid = true;
        }
    }

    if (!$valid) {  
        setcookie('remember_token', '', ['expires' => time() - 3600, 'path' => '/']);
    }
}