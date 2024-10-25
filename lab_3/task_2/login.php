<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['user'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Невірний логін або пароль.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="post" action="">
        <label>Логін: <input type="text" name="username" required></label><br>
        <label>Пароль: <input type="password" name="password" required></label><br>
        <input type="submit" value="Увійти">
    </form>
</body>
</html>
