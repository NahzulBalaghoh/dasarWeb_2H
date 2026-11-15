<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Pengembalian";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$keyword = trim($_GET['q'] ?? '');

$sqlDasar = "SELECT p.id, b.judul, a.nama, p.tanggal_pinjam
             FROM peminjaman p
             JOIN buku b ON b.id = p.buku_id
             JOIN anggota a ON a.id = p.anggota_id
             WHERE p.status = 'dipinjam'";

if ($keyword !== '') {
    $kw = '%' . $keyword . '%';
    $stmt = $pdo->prepare($sqlDasar . " AND (a.nama ILIKE :kw1 OR b.judul ILIKE :kw2) ORDER BY p.tanggal_pinjam");
    $stmt->execute(['kw1' => $kw, 'kw2' => $kw]);
} else {
    $stmt = $pdo->query($sqlDasar . " ORDER BY p.tanggal_pinjam");
}
$daftarAktif = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Pengembalian Buku</h2>

            <?php if ($flash): ?>
            <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
            <?php endif; ?>

            <form method="get" action="kembali.php" class="search-box">
                <label for="search-input">Cari transaksi aktif (nama anggota / judul buku)</label>
                <div>
                    <input type="text" id="search-input" name="q"
                        value="<?php echo e($keyword); ?>" placeholder="Ketik nama anggota atau judul buku">
                    <button type="submit">Cari</button>
                    <a href="kembali.php" class="btn-reset">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarAktif)): ?>
                        <tr>
                            <td colspan="4">Tidak ada transaksi peminjaman yang aktif.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($daftarAktif as $t): ?>
                        <tr>
                            <td><?php echo e($t['nama']); ?></td>
                            <td><?php echo e($t['judul']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($t['tanggal_pinjam'])); ?></td>
                            <td>
                                <form method="post" action="proses_kembali.php">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                                    <button type="submit">Kembalikan</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>