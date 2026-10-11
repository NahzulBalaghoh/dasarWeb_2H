<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Registrasi Petugas";
include __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Registrasi Petugas</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash']['pesan']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form action="proses_register.php" method="post">
        <p>
            <label for="nama">Nama <span class="wajib">*</span></label>
            <input type="text" id="nama" name="nama" required>
        </p>
        <p>
            <label for="username">Username <span class="wajib">*</span></label>
            <input type="text" id="username" name="username" required>
        </p>
        <p>
            <label for="password">Password <span class="wajib">*</span></label>
            <input type="password" id="password" name="password" minlength="6" required>
        </p>
        <button type="submit">Daftar</button>
    </form>

    <p style="margin-top: 1rem; margin-bottom: 0;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>