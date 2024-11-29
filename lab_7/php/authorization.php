<?php
header('Content-Type: application/json');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $email = $_POST["email"];
    $pass = $_POST["password"];

    try {
        $conn = new PDO("pgsql:host=postgres;dbname=users", "laravel-getting-started-user", "laravel-getting-started-password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT password, id FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $user['password'];
            $id = $user['id'];

            if (md5($pass) === $hashed_password) {  // Лучше использовать password_verify()
                $_SESSION['id'] = $id;
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Невірний пароль"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Користувача з таким email не існує"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Помилка сервера: " . $e->getMessage()]);
    }
}
?>
