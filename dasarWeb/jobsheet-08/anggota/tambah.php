<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title h4 mb-3 text-primary">Tambah Anggota</h2>
 
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
                <?php endif; ?>
 
                <form method="post" action="proses_tambah.php" id="form-tambah" novalidate>
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama_lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_anggota" class="form-label fw-semibold">No. Anggota <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_anggota" name="no_anggota" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold">No. HP <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>