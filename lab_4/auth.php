<?php
session_start();

try {
    $conn = new PDO("pgsql:host=postgres dbname=users_db user=laravel-getting-started-user password=laravel-getting-started-password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        
        if ($stmt->execute()) {
            echo "Регистрация успешна!";
        } else {
            echo "Ошибка при регистрации.";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: welcome.php");
                exit;
            } else {
                echo "Неверный пароль.";
            }
        } else {
            echo "Пользователь не найден.";
        }
    }
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация и Авторизация</title>
</head>
<body>

<h2>Регистрация</h2>
<form method="POST" action="auth.php">
    <input type="hidden" name="register">
    <label>Имя пользователя:</label>
    <input type="text" name="username" required><br>
    <label>Электронная почта:</label>
    <input type="email" name="email" required><br>
    <label>Пароль:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Зарегистрироваться</button>
</form>

<h2>Авторизация</h2>
<form method="POST" action="auth.php">
    <input type="hidden" name="login">
    <label>Имя пользователя:</label>
    <input type="text" name="username" required><br>
    <label>Пароль:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Войти</button>
</form>

</body>
</html>
