<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Перенаправлення користувача, якщо метод не POST
    header("Location: server_info.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>L3__3</title>
</head>
<body>
    <h1>Інформація про сервер</h1>
    <p>IP-адреса клієнта: <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
    <p>Браузер: <?php echo $_SERVER['HTTP_USER_AGENT']; ?></p>
    <p>Скрипт: <?php echo $_SERVER['PHP_SELF']; ?></p>
    <p>Метод запиту: <?php echo $_SERVER['REQUEST_METHOD']; ?></p>
    <p>Шлях до файлу на сервері: <?php echo $_SERVER['SCRIPT_FILENAME']; ?></p>
</body>
</html>