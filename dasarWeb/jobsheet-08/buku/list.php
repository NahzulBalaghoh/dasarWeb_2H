<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
require __DIR__ . '/../includes/koneksi.php';

$keyword = trim($_GET['q'] ?? '');
$stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :keyword ORDER BY id DESC");
$stmt->execute(['keyword' => '%' . $keyword . '%']);
$daftarBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title h4 mb-3 text-primary">Daftar Buku</h2>
 
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
                <?php endif; ?>
 
                <form method="get" class="search-box">
                    <label for="cari-server" class="form-label fw-semibold">Cari Judul Buku</label>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" id="cari-server" name="q"
                               value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik judul buku">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="list.php" class="btn btn-outline-primary">Reset</a>
                    </div>
                </form>
                <p class="small text-secondary mb-2" id="table-count"></p>
 
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="bg-primary">
                            <tr class="text-white">
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
                                    <button type="button" class="btn btn-warning btn-sm text-white">Edit</button>
                                    <button type="button" class="btn btn-detail btn-sm text-white">Detail</button>
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>