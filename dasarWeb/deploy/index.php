<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';
$totalBuku = $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$totalAnggota = $pdo->query("SELECT COUNT(*) FROM anggota")->fetchColumn();
$sedangDipinjam = $pdo->query("SELECT COUNT(*) FROM peminjaman WHERE status = 'dipinjam'")->fetchColumn();
$bukuTerlambat = $pdo->query(
    "SELECT COUNT(*) FROM peminjaman
     WHERE status = 'dipinjam' AND CURRENT_DATE - tanggal_pinjam > 14"
)->fetchColumn();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo $flash['pesan']; ?></p>
        <?php endif; ?>
 
        <section class="beranda">
            <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
            <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
        </section>
 
        <section class="beranda">
            <h2>Ringkasan</h2>
            <div class="ringkasan">
                <div>
                    <h3>Total Buku</h3>
                    <p><?php echo $totalBuku; ?></p>
                </div>
                <div>
                    <h3>Total Anggota</h3>
                    <p><?php echo $totalAnggota; ?></p>
                </div>
                <div>
                    <h3>Sedang Dipinjam</h3>
                    <p><?php echo $sedangDipinjam; ?></p>
                </div>
                <div>
                    <h3>Buku Terlambat</h3>
                    <p><?php echo $bukuTerlambat; ?></p>
                </div>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>