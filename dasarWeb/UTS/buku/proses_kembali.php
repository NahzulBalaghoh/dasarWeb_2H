<?php

require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);         
$bukuId = (int) ($_POST['buku_id'] ?? 0); 

$pdo->beginTransaction();

$stmt = $pdo->prepare(
    "UPDATE peminjaman SET tanggal_kembali = CURRENT_DATE
     WHERE id = :id AND tanggal_kembali IS NULL"
);
$stmt->execute(['id' => $id]);

if ($stmt->rowCount() === 1) {
    
    $pdo->prepare(
        "UPDATE buku SET stok = stok + 1
         WHERE id = (SELECT buku_id FROM peminjaman WHERE id = :id)"
    )->execute(['id' => $id]);

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dikembalikan.'];
} else {
    $pdo->rollBack();
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data peminjaman tidak ditemukan atau sudah dikembalikan.'];
}

header('Location: detail.php?id=' . $bukuId);
exit;