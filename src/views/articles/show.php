<?php ob_start(); ?>

<h1>Article Title</h1>
<div class="content">
    <p>Article content...</p>
</div>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layout.php'; ?>
