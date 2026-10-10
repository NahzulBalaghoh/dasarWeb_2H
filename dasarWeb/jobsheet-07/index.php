<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
$totalBuku = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
        <?php endif; ?>
        
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3 text-primary">Selamat Datang di Sistem Perpustakaan Mini</h2>
                <p class="mb-0">Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
            </div>
        </section>
 
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title mb-3 text-primary">Ringkasan</h2>
                <div class="row g-3 text-center">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Total Buku</h3>
                            <p class="fs-2 fw-bold mb-0 text-primary"><?php echo $totalBuku; ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Total Anggota</h3>
                            <p class="fs-2 fw-bold mb-0 text-primary"><?php echo $totalAnggota; ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Sedang Dipinjam</h3>
                            <p class="fs-2 fw-bold mb-0 text-primary">3</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="p-3 rounded-3 bg-light">
                            <h3 class="h6 text-secondary">Buku Terlambat</h3>
                            <p class="fs-2 fw-bold mb-0 text-primary">3</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>