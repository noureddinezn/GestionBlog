<?php ob_start(); ?>

<h1>Articles</h1>
<div class="articles-list">
    <!-- Loop through articles here -->
    <p>No articles found.</p>
</div>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layout.php'; ?>
