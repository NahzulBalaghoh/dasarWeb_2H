<?php
require __DIR__ . '/../includes/auth.php';           
require __DIR__ . '/../includes/koneksi.php';        

$nama = trim($_POST['nama_lengkap'] ?? '');          
$email = trim($_POST['email'] ?? '');                 
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? ''); 
$noAnggota = trim($_POST['no_anggota'] ?? '');        
$alamat = trim($_POST['alamat'] ?? '');              
$noHp = trim($_POST['no_hp'] ?? '');                 

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
if ($noAnggota === '') {                             
    $errors[] = "No. Anggota wajib diisi.";
}
if ($alamat === '') {                               
    $errors[] = "Alamat wajib diisi.";
}
if ($noHp === '') {                                  
    $errors[] = "No. HP wajib diisi.";
} elseif (!preg_match('/^[0-9]{10,13}$/', $noHp)) {
    $errors[] = "No. HP harus berupa 10-13 digit angka.";
}

if (!empty($errors)) {                              
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(                                
    "INSERT INTO anggota (nama, no_anggota, alamat, no_hp, email, tanggal_lahir)
     VALUES (:nama, :no_anggota, :alamat, :no_hp, :email, :tanggal_lahir)"
);

try {                                                
    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $noAnggota,
        'alamat' => $alamat,
        'no_hp' => $noHp,
        'email' => $email,
        'tanggal_lahir' => $tanggal_lahir,
    ]);
} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota atau email sudah dipakai.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan database.'];
    }
    header('Location: tambah.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.']; 
header('Location: list.php');
exit;