<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit;
}
echo "Добро пожаловать, пользователь!";
?>
