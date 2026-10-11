<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Buku</h2>
 
            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>
 
            <form method="post" action="proses_tambah.php" id="form-tambah" novalidate>
                <p>
                    <label for="judul">Judul <span class="wajib">*</span></label>
                    <input type="text" id="judul" name="judul" required>
                </p>
                <p>
                    <label for="pengarang">Pengarang <span class="wajib">*</span></label>
                    <input type="text" id="pengarang" name="pengarang" required>
                </p>
                <p>
                    <label for="tahun">Tahun Terbit <span class="wajib">*</span></label>
                    <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
                </p>
                <p>
                    <label for="isbn">ISBN <span class="opsional">(opsional)</span></label>
                    <input type="text" id="isbn" name="isbn">
                </p>
                <p>
                    <label for="stok">Stok <span class="wajib">*</span></label>
                    <input type="number" id="stok" name="stok" min="0" required>
                </p>
                <p>
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori">
                        <option value="fiksi">Fiksi</option>
                        <option value="non-fiksi">Non Fiksi</option>
                        <option value="referensi">Referensi</option>
                    </select>
                </p>
                <button type="submit">Simpan</button>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>