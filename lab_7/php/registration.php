<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashed_password = md5($password); 

    try {
        $conn = new PDO("pgsql:host=postgres;dbname=users", "laravel-getting-started-user", "laravel-getting-started-password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT 1 FROM users WHERE username = :name OR email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email]);

        if ($stmt->fetch()) {
            echo json_encode(["success" => false, "message" => "Користувач з таким ім'ям або email вже існує."]);
            exit();
        }

        $sql = "INSERT INTO users (username, email, password) VALUES (:name, :email, :password)";
        $stmt = $conn->prepare($sql);
        $params = [
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password
        ];

        if ($stmt->execute($params)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Помилка при реєстрації."]);
        }

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Помилка сервера: " . $e->getMessage()]);
    }
}
?>
