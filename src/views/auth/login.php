<?php ob_start(); ?>

<h1>Login</h1>
<form action="/login" method="POST">
    <label>Email</label>
    <input type="email" name="email">
    
    <label>Password</label>
    <input type="password" name="password">
    
    <button type="submit">Login</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layout.php'; ?>
