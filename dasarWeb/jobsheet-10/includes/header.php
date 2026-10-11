<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>

<body>
    <header class="site-header">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $base; ?>index.php">SIMPUS-Mini</a>

            <button class="navbar-toggler" type="button" id="nav-toggle-btn" aria-label="Menu">&#9776;</button>

            <nav class="navbar-collapse" id="navMenu">
                <ul class="navbar-nav">
                    <li><a class="nav-link" href="<?php echo $base; ?>index.php">Beranda</a></li>
                    <li><a class="nav-link" href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>

                    <?php if ($sudahLogin): ?>
                        <li><a class="nav-link" href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                        <li><a class="nav-link" href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                        <li><a class="nav-link" href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="auth-status">
                <?php if ($sudahLogin): ?>
                    <span><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                    <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
                <?php else: ?>
                    <a href="<?php echo $base; ?>auth/login.php">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="container main-content">