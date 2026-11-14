<?php

require __DIR__ . '/../includes/koneksi.php';

$id = $_GET['id'] ?? '';
$stmt = $pdo->prepare("SELECT judul, stok FROM buku WHERE id = :id");
$stmt->execute(['id' => (int) $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku || $buku['stok'] < 1) {
    header('Location: list.php');
    exit;
}

$page_title = "Pinjam Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Pinjam Buku</h2>

            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <p>Buku: <strong><?php echo htmlspecialchars($buku['judul']); ?></strong> (stok: <?php echo $buku['stok']; ?>)</p>
            <p>Lama peminjaman 7 hari.</p>

            <form method="post" action="proses_pinjam.php">
                <input type="hidden" name="id" value="<?php echo (int) $id; ?>">
                <p>
                    <label for="no_anggota">No. Anggota <span class="wajib">*</span></label>
                    <input type="text" id="no_anggota" name="no_anggota" required>
                </p>
                <button type="submit">Pinjam</button>
                <a href="list.php" class="btn-reset">Batal</a>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>