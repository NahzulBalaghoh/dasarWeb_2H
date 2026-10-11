<?php
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Buku</h2>

            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form method="post" action="proses_edit.php" id="form-tambah" class="form-edit" novalidate>
            <!-- <form method="post" action="proses_edit.php" id="form-tambah" novalidate> -->
                <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                <p>
                    <label for="judul">Judul <span class="wajib">*</span></label>
                    <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>
                </p>
                <p>
                    <label for="pengarang">Pengarang <span class="wajib">*</span></label>
                    <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required>
                </p>
                <p>
                    <label for="tahun">Tahun Terbit <span class="wajib">*</span></label>
                    <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo $buku['tahun']; ?>" required>
                </p>
                <p>
                    <label for="isbn">ISBN <span class="opsional">(opsional)</span></label>
                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($buku['isbn'] ?? ''); ?>">
                </p>
                <p>
                    <label for="stok">Stok <span class="wajib">*</span></label>
                    <input type="number" id="stok" name="stok" min="0" value="<?php echo $buku['stok']; ?>" required>
                </p>
                <p>
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori">
                        <?php foreach (['fiksi' => 'Fiksi', 'non-fiksi' => 'Non Fiksi', 'referensi' => 'Referensi'] as $value => $label): ?>
                        <option value="<?php echo $value; ?>" <?php echo ($buku['kategori'] ?? '') === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <button type="submit">Simpan Perubahan</button>
                <a href="list.php" class="btn-reset">Batal</a>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>