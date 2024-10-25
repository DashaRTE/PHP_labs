<?php
session_start();

$timeout_duration = 300; // 5 минут

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Timeout</title>
</head>
<body>
    <h1>Сесія активна</h1>
    <p>Ця сесія завершиться після 5 хвилин бездіяльності.</p>
</body>
</html>
