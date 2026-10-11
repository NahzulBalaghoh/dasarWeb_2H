<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Anggota</h2>
 
            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>
 
            <form method="post" action="proses_tambah.php" id="form-tambah" novalidate>
                <p>
                    <label for="nama">Nama <span class="wajib">*</span></label>
                    <input type="text" id="nama" name="nama_lengkap" required>
                </p>
                <p>
                    <label for="email">Email <span class="wajib">*</span></label>
                    <input type="email" id="email" name="email" required>
                </p>
                <p>
                    <label for="tanggal_lahir">Tanggal Lahir <span class="wajib">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
                </p>
                <p>
                    <label for="no_anggota">No. Anggota <span class="wajib">*</span></label>
                    <input type="text" id="no_anggota" name="no_anggota" required>
                </p>
                <p>
                    <label for="alamat">Alamat <span class="wajib">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3" required></textarea>
                </p>
                <p>
                    <label for="no_hp">No. HP <span class="wajib">*</span></label>
                    <input type="tel" id="no_hp" name="no_hp" required>
                </p>
                <button type="submit">Simpan</button>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>