<?php ob_start(); ?>

<h1>Create Article</h1>
<form action="/articles" method="POST">
    <label>Title</label>
    <input type="text" name="title">
    
    <label>Content</label>
    <textarea name="content"></textarea>
    
    <button type="submit">Publish</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layout.php'; ?>
