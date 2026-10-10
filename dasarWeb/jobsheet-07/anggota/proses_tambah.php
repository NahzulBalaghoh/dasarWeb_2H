<?php
session_start();
 
$nama = trim($_POST['nama_lengkap'] ?? '');
$email = trim($_POST['email'] ?? '');
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
 
$errors = [];
 
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email wajib diisi dengan format yang benar.";
}
if ($tanggal_lahir === '') {
    $errors[] = "Tanggal lahir wajib diisi.";
} elseif (strtotime($tanggal_lahir) > time()) {
    $errors[] = "Tanggal lahir tidak boleh di masa depan.";
}
if ($no_anggota === '') {
    $errors[] = "No. anggota wajib diisi.";
} else {
    foreach ($_SESSION['anggota'] ?? [] as $a) {
        if ($a['no_anggota'] === $no_anggota) {
            $errors[] = "No. anggota sudah dipakai.";
            break;
        }
    }
}
if ($alamat === '') {
    $errors[] = "Alamat wajib diisi.";
}
if ($no_hp === '') {
    $errors[] = "No. HP wajib diisi.";
} elseif (!preg_match('/^[0-9]{10,13}$/', $no_hp)) {
    $errors[] = "No. HP harus berupa 10-13 digit angka.";
}
 
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}
 
if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}
 
$_SESSION['anggota'][] = [
    'no_anggota' => $no_anggota,
    'nama' => $nama,
    'alamat' => $alamat,
    'no_hp' => $no_hp,
    'email' => $email,
    'tanggal_lahir' => $tanggal_lahir,
];
 
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;