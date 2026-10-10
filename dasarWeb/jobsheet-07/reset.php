<?php
session_start();
$_SESSION = [];
session_destroy();
 
session_start();
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Semua data berhasil direset.'];
header('Location: index.php');
exit;