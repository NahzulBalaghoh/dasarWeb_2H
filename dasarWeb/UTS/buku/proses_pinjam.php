<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$no_anggota = trim($_POST['no_anggota'] ?? '');

$cek = $pdo->prepare("SELECT id FROM anggota WHERE no_anggota = :no");
$cek->execute(['no' => $no_anggota]);
$anggotaId = $cek->fetchColumn();

if (!$anggotaId) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota tidak ditemukan.'];
    header('Location: pinjam.php?id=' . $id);
    exit;
}

$pdo->beginTransaction();


$stok = $pdo->prepare("UPDATE buku SET stok = stok - 1 WHERE id = :id AND stok > 0");
$stok->execute(['id' => $id]);


$pinjam = $pdo->prepare(
    "INSERT INTO peminjaman (buku_id, anggota_id, tanggal_jatuh_tempo)
     VALUES (:buku, :anggota, CURRENT_DATE + 7)"
);
$pinjam->execute(['buku' => $id, 'anggota' => $anggotaId]);

$pdo->commit();

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Peminjaman berhasil. Jatuh tempo 7 hari lagi.'];
header('Location: list.php');
exit;