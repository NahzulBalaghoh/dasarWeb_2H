<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT judul FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare(
    "SELECT p.id, a.nama, a.no_anggota, a.no_hp, p.tanggal_jatuh_tempo,
            (CURRENT_DATE - p.tanggal_jatuh_tempo) AS selisih
     FROM peminjaman p
     JOIN anggota a ON a.id = p.anggota_id
     WHERE p.buku_id = :id AND p.tanggal_kembali IS NULL
     ORDER BY p.tanggal_jatuh_tempo ASC"
);
$stmt->execute(['id' => $id]);
$daftarPeminjam = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Detail Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Detail Buku: <?php echo htmlspecialchars($buku['judul']); ?></h2>

            <?php if ($flash): ?>
            <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <p>Peminjam yang belum mengembalikan: <?php echo count($daftarPeminjam); ?> orang</p>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No. Anggota</th>
                            <th>No. HP</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($daftarPeminjam)): ?>
                        <tr>
                            <td colspan="6">Buku ini tidak sedang dipinjam.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($daftarPeminjam as $p): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p['nama']); ?></td>
                            <td><?php echo htmlspecialchars($p['no_anggota']); ?></td>
                            <td><?php echo htmlspecialchars($p['no_hp'] ?? ''); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($p['tanggal_jatuh_tempo'])); ?></td>
                            <td><?php echo $p['selisih'] > 0 ? 'Terlambat ' . (int) $p['selisih'] . ' hari' : '-'; ?></td>
                            <td>
                                
                                <form method="post" action="proses_kembali.php">
                                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                    <input type="hidden" name="buku_id" value="<?php echo $id; ?>">
                                    <button type="submit">Dikembalikan</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <a href="list.php" class="btn-reset">Kembali</a>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>