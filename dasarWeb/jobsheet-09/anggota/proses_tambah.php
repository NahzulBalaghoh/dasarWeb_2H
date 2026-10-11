<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$nama = trim($_POST['nama_lengkap'] ?? '');
$email = trim($_POST['email'] ?? '');
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE anggota SET nama = :nama, no_anggota = :no_anggota, alamat = :alamat,
            no_hp = :no_hp, email = :email, tanggal_lahir = :tanggal_lahir,
            jenis_kelamin = :jenis_kelamin
     WHERE id = :id"
);

try {
    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $no_anggota,
        'alamat' => $alamat,
        'no_hp' => $no_hp,
        'email' => $email,
        'tanggal_lahir' => $tanggal_lahir,
        'jenis_kelamin' => $jenis_kelamin,
        'id' => $id,
    ]);
} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan database.'];
    }
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diubah.'];
header('Location: list.php');
exit;