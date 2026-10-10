<?php
$page_title = "Debug Session";
include __DIR__ . '/includes/header.php';
?>
        <section class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title h4 mb-3 text-primary">Debug Session</h2>
                <pre><?php print_r($_SESSION); ?></pre>
            </div>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>
 