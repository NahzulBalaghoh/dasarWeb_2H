<?php
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarBuku = $_SESSION['buku'] ?? [];
?>
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title h4 mb-3 text-primary">Daftar Buku</h2>
 
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
                <?php endif; ?>
 
                <div class="search-box">
                    <label for="search-input" class="form-label fw-semibold">Cari Judul Buku</label>
                    <input type="text" class="form-control" id="search-input" placeholder="Ketik judul buku...">
                </div>
                <p class="small text-secondary mb-2" id="table-count"></p>
 
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="bg-primary">
                            <tr class="text-white">
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftarBuku)): ?>
                            <tr>
                                <td colspan="5">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($daftarBuku as $buku): ?>
                            <tr>
                                <td><?php echo $buku['judul']; ?></td>
                                <td><?php echo $buku['pengarang']; ?></td>
                                <td><?php echo $buku['tahun']; ?></td>
                                <td><?php echo $buku['stok']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm text-white">Edit</button>
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