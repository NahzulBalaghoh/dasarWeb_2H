<?php
require __DIR__ . '/includes/koneksi.php';

$file = __DIR__ . '/data/buku.json';
if (!file_exists($file)) {
    die("File data/buku.json tidak ditemukan.");
}

$data = json_decode(file_get_contents($file), true);
if (isset($data['buku'])) {
    $data = $data['buku'];
}

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

$jumlah = 0;
$pdo->beginTransaction();
foreach ($data as $b) {
    $stmt->execute([
        'judul' => $b['judul'] ?? '',
        'pengarang' => $b['pengarang'] ?? '',
        'tahun' => (int) ($b['tahun'] ?? 0),
        'isbn' => $b['isbn'] ?? '',
        'stok' => (int) ($b['stok'] ?? 0),
        'kategori' => $b['kategori'] ?? '',
    ]);
    $jumlah++;
}
$pdo->commit();

echo "Berhasil memasukkan $jumlah buku ke database.";