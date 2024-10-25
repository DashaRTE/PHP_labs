<?php
if (isset($_POST['name'])) {
    setcookie("username", $_POST['name'], time() + (7 * 24 * 60 * 60));
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_cookie'])) {
    setcookie("username", "", time() - 3600);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cookie Example</title>
</head>
<body>
    <?php if (isset($_COOKIE['username'])): ?>
        <h1>Привіт, <?= htmlspecialchars($_COOKIE['username']) ?>!</h1>
        <a href="?delete_cookie=1">Видалити cookie</a>
    <?php else: ?>
        <form method="post" action="">
            <label>Введіть своє ім'я: <input type="text" name="name" required></label>
            <input type="submit" value="Зберегти">
        </form>
    <?php endif; ?>
</body>
</html>
