<?php ob_start(); ?>

<h1>Welcome to the Blog</h1>
<p>Latest articles will appear here.</p>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/layout.php'; ?>
