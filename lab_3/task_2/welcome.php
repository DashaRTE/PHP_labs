<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1>Привіт, <?= htmlspecialchars($_SESSION['user']) ?>!</h1>
    <form method="post" action="">
        <button type="submit" name="logout">Вихід</button>
    </form>
</body>
</html>
