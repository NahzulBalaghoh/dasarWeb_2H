<?php
require __DIR__ . '/includes/koneksi.php';

$file = __DIR__ . '/data/anggota.json';             
if (!file_exists($file)) {
    die("File data/anggota.json tidak ditemukan.");  
}

$data = json_decode(file_get_contents($file), true);
if (isset($data['anggota'])) {                      
    $data = $data['anggota'];
}

$stmt = $pdo->prepare(
    "INSERT INTO anggota (no_anggota, nama, alamat, no_hp, jenis_kelamin, email)
     VALUES (:no_anggota, :nama, :alamat, :no_hp, :jenis_kelamin, :email)
     ON CONFLICT (no_anggota) DO NOTHING"
);

$jumlah = 0;
$dilewati = 0;                                       
$pdo->beginTransaction();
foreach ($data as $a) {
    $stmt->execute([                                 
        'no_anggota' => $a['no_anggota'] ?? '',
        'nama'       => $a['nama'] ?? '',
        'alamat'     => $a['alamat'] ?? '',
        'no_hp'      => $a['no_hp'] ?? '',
        'jenis_kelamin' => $a['jenis_kelamin'] ?? '',
        'email'      => $a['email'] ?? '',
    ]);
    if ($stmt->rowCount() > 0) {                     
        $jumlah++;
    } else {
        $dilewati++;
    }
}
$pdo->commit();

echo "Berhasil memasukkan $jumlah anggota ke database. ($dilewati dilewati karena No. Anggota sudah ada)";  