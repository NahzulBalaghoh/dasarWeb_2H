<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
require __DIR__ . '/../includes/koneksi.php';
 
$perPage = 5;
$keyword = trim($_GET['q'] ?? '');
$kw = '%' . $keyword . '%';

$hitung = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE judul ILIKE :kw1 OR pengarang ILIKE :kw2");
$hitung->execute(['kw1' => $kw, 'kw2' => $kw]); 
$totalRows = (int) $hitung->fetchColumn();

$totalPages = max(1, (int) ceil($totalRows / $perPage));
$page = min($totalPages, max(1, (int) ($_GET['page'] ?? 1)));
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw1 OR pengarang ILIKE :kw2 ORDER BY id DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue('kw1', $kw);   
$stmt->bindValue('kw2', $kw);
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <section>
            <h2>Daftar Buku</h2>
 
            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form method="get" action="list.php" class="search-box">
               <label for="search-input">Cari Judul / Pengarang</label>
                <div>
                    <input type="text" id="search-input" name="q"
                        value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik judul atau pengarang">
                    <button type="submit">Cari</button>
                    <a href="list.php" class="btn-reset">Reset</a>
                </div>
            </form>
            <p id="table-count"></p>
 
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th>Ditambahkan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarBuku)): ?>
                        <tr>
                            <td colspan="6">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($daftarBuku as $buku): ?>
                        <tr>
                            <td><?php echo $buku['judul']; ?></td>
                            <td><?php echo $buku['pengarang']; ?></td>
                            <td><?php echo $buku['tahun']; ?></td>
                            <td><?php echo $buku['stok']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($buku['tanggal_ditambahkan'])); ?></td>
                            <td>
                                <button type="button" class="btn-edit">Edit</button>
                                <button type="button" class="btn-detail">Detail</button>
                                <form class="form-hapus" method="post" action="hapus.php">
                                    <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
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