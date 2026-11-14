<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$page_title = "Login";
include __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Login Petugas</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash']['pesan']); ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form action="proses_login.php" method="post">
        <p>
            <label for="username">Username <span class="wajib">*</span></label>
            <input type="text" id="username" name="username" required>
        </p>
        <p>
            <label for="password">Password <span class="wajib">*</span></label>
            <input type="password" id="password" name="password" required>
        </p>
        <p>
            <label class="ingat-saya">
                <input type="checkbox" name="ingat" value="1"> Ingat saya selama 30 hari
            </label>
        </p>
        <button type="submit">Masuk</button>
    </form>

    <p style="margin-top: 1rem; margin-bottom: 0;">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>