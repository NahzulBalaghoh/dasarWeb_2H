<?php
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';
 
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
require __DIR__ . '/../includes/koneksi.php';
$daftarAnggota = $pdo->query("SELECT * FROM anggota ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title h4 mb-3 text-primary">Daftar Anggota</h2>
 
                <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
                <?php endif; ?>
 
                <div class="search-box">
                    <label for="search-input" class="form-label fw-semibold">Cari Anggota</label>
                    <input type="text" class="form-control" id="search-input" placeholder="Ketik no. anggota">
                </div>
                <p class="small text-secondary mb-2" id="table-count"></p>
 
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="bg-primary">
                            <tr class="text-white">
                                <th rowspan="2">No. Anggota</th>
                                <th rowspan="2">Nama</th>
                                <th rowspan="2">Alamat</th>
                                <th rowspan="2">No. HP</th>
                                <th colspan="2">Jenis Kelamin</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                            <tr class="text-white">
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
                                <td><button type="button" class="btn btn-warning btn-sm text-white">Edit</button></td>
                                <td><button type="button" class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>