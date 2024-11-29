<?php
$userId = $_SESSION['id'];

try {
    $conn = new PDO("pgsql:host=postgres;dbname=users", "laravel-getting-started-user", "laravel-getting-started-password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Помилка з'єднання: " . $e->getMessage();
    exit();
}

$sql = "SELECT username FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $userId]);
$username = $stmt->fetchColumn();

if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: ../html/authorization_page.html");
    exit();
}

if (isset($_POST["save_name"])) {
    $name = $_POST["name"];
    $sql = "UPDATE users SET username = :name WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['name' => $name, 'id' => $userId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST["save_email"])) {
    $email = $_POST["email"];
    $sql = "UPDATE users SET email = :email WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email, 'id' => $userId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST["save_password"])) {
    $password = $_POST["password"];
    $hashed_password = md5($password);  // Лучше использовать bcrypt или password_hash()
    $sql = "UPDATE users SET password = :password WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['password' => $hashed_password, 'id' => $userId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>



<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Особистий кабінет</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .personal_office {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            width: 420px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        p.welcome {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            color: #495057;
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
            display: none;
            margin-top: 5px;
            text-align: left;
        }

        @media (max-width: 600px) {
            .personal_office {
                width: 90%;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="content">
    <p class="welcome"><?php echo "Привіт " . $username . "!"; ?></p>
    <div class="personal_office">
        <h1>Особистий кабінет</h1>
        <form id="changeName" method="post">
            <p>Змінити ім'я</p>
            <div class="form-group">
                <label for="name">Ім'я:</label>
                <input type="text" name="name" id="name">
            </div>
            <input type="submit" name="save_name" id="save_name" value="Зберегти"><br>
            <span class="error-message" id="nameError"></span>
        </form>
        <form id="changeEmail" method="post">
            <p>Змінити пошту</p>
            <div class="form-group">
                <label for="email">Електронна пошта:</label>
                <input type="text" name="email" id="email">
            </div>
            <input type="submit" name="save_email" id="save_email" value="Зберегти"><br>
            <span class="error-message" id="emailError"></span>
        </form>
        <form id="changePassword" method="post">
            <p>Змінити пароль</p>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password">
            </div>
            <input type="submit" name="save_password" id="save_password" value="Зберегти"><br>
            <span class="error-message" id="passwordError"></span>
        </form>
        <form method="post">
            <input type="submit" name="logout" id="logout" value="Вийти">
        </form>
    </div>
</div>

<script>
    $("#changeName").submit(function(event) {
        let valid = true;
        $(".error-message").text("").hide();

        const name = $("input[name='name']").val();
        if (name === "") {
            $("#nameError").text("Ім'я не може бути порожнім.").show();
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    $("#changeEmail").submit(function(event) {
        let valid = true;
        $(".error-message").text("").hide();

        const email = $("input[name='email']").val();
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (email === "") {
            $("#emailError").text("Електронна пошта не може бути порожньою.").show();
            valid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Неправильний формат електронної пошти.").show();
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    $("#changePassword").submit(function(event) {
        let valid = true;
        $(".error-message").text("").hide();

        const password = $("input[name='password']").val();
        if (password === "") {
            $("#passwordError").text("Пароль не може бути порожнім.").show();
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>
</body>
</html>
