<?php ob_start(); ?>

<h1>Register</h1>
<form action="/register" method="POST">
    <label>Username</label>
    <input type="text" name="username">
    
    <label>Email</label>
    <input type="email" name="email">
    
    <label>Password</label>
    <input type="password" name="password">
    
    <button type="submit">Register</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require __DIR__ . '/../layout.php'; ?>
