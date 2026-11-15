<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Riwayat Peminjaman";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$anggotaId = $_GET['anggota_id'] ?? '';
$riwayat = [];
$namaAnggota = '';

$daftarAnggota = $pdo->query("SELECT id, nama, no_anggota FROM anggota ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);

if ($anggotaId !== '') {
    $stmt = $pdo->prepare(
        "SELECT b.judul, p.tanggal_pinjam, p.tanggal_kembali, p.status
         FROM peminjaman p
         JOIN buku b ON b.id = p.buku_id
         WHERE p.anggota_id = :id
         ORDER BY p.tanggal_pinjam DESC"
    );
    $stmt->execute(['id' => $anggotaId]);
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($daftarAnggota as $a) {
        if ((string) $anggotaId === (string) $a['id']) {
            $namaAnggota = $a['nama'];
        }
    }
}
?>
        <section>
            <h2>Riwayat Peminjaman<?php echo $namaAnggota !== '' ? ' — ' . e($namaAnggota) : ''; ?></h2>

            <form method="get" action="riwayat.php" class="search-box">
                <label for="anggota_id">Pilih Anggota</label>
                <div>
                    <select id="anggota_id" name="anggota_id">
                        <option value="">-- Pilih anggota --</option>
                        <?php foreach ($daftarAnggota as $anggota): ?>
                        <option value="<?php echo $anggota['id']; ?>" <?php echo (string) $anggotaId === (string) $anggota['id'] ? 'selected' : ''; ?>>
                            <?php echo e($anggota['nama']); ?> (<?php echo e($anggota['no_anggota']); ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Tampilkan</button>
                </div>
            </form>

            <?php if ($anggotaId !== ''): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Pinjam</th>
                            <th>Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="4">Anggota ini belum pernah meminjam buku.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?php echo e($r['judul']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($r['tanggal_pinjam'])); ?></td>
                            <td><?php echo $r['tanggal_kembali'] ? date('d/m/Y', strtotime($r['tanggal_kembali'])) : '-'; ?></td>
                            <td><?php echo $r['status'] === 'dipinjam' ? 'Dipinjam' : 'Selesai'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>