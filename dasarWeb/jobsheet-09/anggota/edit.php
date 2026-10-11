<?php
$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Anggota</h2>

            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form method="post" action="proses_edit.php" id="form-tambah" novalidate>
                <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
                <p>
                    <label for="nama">Nama <span class="wajib">*</span></label>
                    <input type="text" id="nama" name="nama_lengkap" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>
                </p>
                <p>
                    <label for="email">Email <span class="wajib">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($anggota['email'] ?? ''); ?>" required>
                </p>
                <p>
                    <label for="tanggal_lahir">Tanggal Lahir <span class="wajib">*</span></label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($anggota['tanggal_lahir'] ?? ''); ?>" required>
                </p>
                <p>
                    <label for="no_anggota">No. Anggota <span class="wajib">*</span></label>
                    <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($anggota['no_anggota']); ?>" required>
                </p>
                <p>
                    <label for="alamat">Alamat <span class="wajib">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($anggota['alamat'] ?? ''); ?></textarea>
                </p>
                <p>
                    <label for="no_hp">No. HP <span class="wajib">*</span></label>
                    <input type="tel" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($anggota['no_hp'] ?? ''); ?>" required>
                </p>
                <p>
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin">
                        <option value="">-- Pilih --</option>
                        <?php foreach (['Perempuan' => 'Perempuan', 'Laki-Laki' => 'Laki-Laki'] as $value => $label): ?>
                        <option value="<?php echo $value; ?>" <?php echo ($anggota['jenis_kelamin'] ?? '') === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <button type="submit">Simpan Perubahan</button>
                <a href="list.php" class="btn-reset">Batal</a>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>