<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
require __DIR__ . '/../includes/koneksi.php';

$perPage = 5;
$keyword = trim($_GET['q'] ?? '');
$kw = '%' . $keyword . '%';

$hitung = $pdo->prepare("SELECT COUNT(*) FROM anggota WHERE nama ILIKE :kw1 OR no_anggota ILIKE :kw2");
$hitung->execute(['kw1' => $kw, 'kw2' => $kw]);
$totalRows = (int) $hitung->fetchColumn();

$totalPages = max(1, (int) ceil($totalRows / $perPage));
$page = min($totalPages, max(1, (int) ($_GET['page'] ?? 1)));
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare(
    "SELECT * FROM anggota WHERE nama ILIKE :kw1 OR no_anggota ILIKE :kw2
     ORDER BY id DESC LIMIT :limit OFFSET :offset"
);
$stmt->bindValue('kw1', $kw);
$stmt->bindValue('kw2', $kw);
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarAnggota = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Daftar Anggota</h2>

            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form method="get" action="list.php" class="search-box">
                <label for="search-input">Cari Anggota</label>
                <div>
                    <input type="text" id="search-input" name="q"
                           value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik no. anggota atau nama">
                    <button type="submit">Cari</button>
                    <a href="list.php" class="btn-reset">Reset</a>
                </div>
            </form>
            <p id="table-count"></p>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">No. Anggota</th>
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Alamat</th>
                            <th rowspan="2">No. HP</th>
                            <th colspan="2">Jenis Kelamin</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Perempuan</th>
                            <th>Laki-Laki</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarAnggota)): ?>
                        <tr>
                            <td colspan="8">Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($daftarAnggota as $anggota): ?>
                        <tr>
                            <td><?php echo $anggota['no_anggota']; ?></td>
                            <td><?php echo $anggota['nama']; ?></td>
                            <td><?php echo $anggota['alamat']; ?></td>
                            <td><?php echo $anggota['no_hp']; ?></td>
                            <td><?php echo ($anggota['jenis_kelamin'] ?? '') === 'Perempuan' ? 'v' : ''; ?></td>
                            <td><?php echo ($anggota['jenis_kelamin'] ?? '') === 'Laki-Laki' ? 'v' : ''; ?></td>
                            <td><a href="edit.php?id=<?php echo $anggota['id']; ?>" class="btn-edit">Edit</a></td>
                            <td>
                                <form class="form-hapus" method="post" action="hapus.php">
                                    <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <nav class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
                   class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </nav>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>