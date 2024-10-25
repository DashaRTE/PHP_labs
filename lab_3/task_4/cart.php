<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {
    $_SESSION['cart'][] = $_POST['product'];
    setcookie("previous_cart", json_encode($_SESSION['cart']), time() + (30 * 24 * 60 * 60));
}

$previousCart = isset($_COOKIE['previous_cart']) ? json_decode($_COOKIE['previous_cart'], true) : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Корзина покупок</h1>
    <form method="post" action="">
        <label>Товар: <input type="text" name="product" required></label>
        <button type="submit">Додати до корзини</button>
    </form>
    
    <h2>Поточні товари</h2>
    <ul>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h2>Попередні покупки</h2>
    <ul>
        <?php foreach ($previousCart as $item): ?>
            <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
