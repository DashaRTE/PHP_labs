<?php

header('Content-Type: application/json');

$host = 'postgres';
$dbname = 'lab8';
$user = 'laravel-getting-started-user';
$password = 'laravel-getting-started-password';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Не вдалося підключитися до бази даних: ' . $e->getMessage()]));
}

$apiKey = '894bf63a7a7ba05c04eb77c89f9d8ae3';

$action = $_GET['action'] ?? $_POST['action'] ?? null;

if ($action === 'getCities') {
    $query = $_GET['query'] ?? null;
    if (!$query) {
        echo json_encode(['success' => false, 'error' => 'Параметр query не задано']);
        exit;
    }

    $response = file_get_contents('https://api.novaposhta.ua/v2.0/json/', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode([
                'apiKey' => $apiKey,
                'modelName' => 'Address',
                'calledMethod' => 'getSettlements',
                'methodProperties' => [
                    'FindByString' => $query,
                    'Limit' => 10
                ],
            ]),
        ],
    ]));
    echo $response;
    exit;
}

if ($action === 'getBranches') {
    $cityRef = $_GET['cityRef'] ?? '';

    if (empty($cityRef)) {
        echo json_encode(['error' => 'CityRef is not specified!!']);
        exit;
    }

    $response = file_get_contents('https://api.novaposhta.ua/v2.0/json/', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode([
                'apiKey' => $apiKey,
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getWarehouses',
                'methodProperties' => ['CityName' => $cityRef]
            ]),
        ]
    ]));
    echo $response;
    exit;
}

if ($action === 'saveOrder') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        echo json_encode(['error' => 'Невірний формат даних']);
        exit;
    }

    $orderNumber = $data['orderNumber'] ?? null;
    $weight = $data['weight'] ?? null;
    $city = $data['city'] ?? null;
    $deliveryType = $data['deliveryType'] ?? null;
    $branch = $data['branch'] ?? null;

    if (!$orderNumber || !$weight || !$city || !$deliveryType || !$branch) {
        echo json_encode(['error' => 'Усі поля повинні бути заповнені']);
        exit;
    }

    try {
        $stmt = $conn->prepare('INSERT INTO orders (order_number, weight, city_ref, delivery_type, branch_ref) VALUES (:orderNumber, :weight, :city, :deliveryType, :branch)');
        $stmt->bindParam(':orderNumber', $orderNumber, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':deliveryType', $deliveryType, PDO::PARAM_STR);
        $stmt->bindParam(':branch', $branch, PDO::PARAM_STR);

        $stmt->execute();
        echo json_encode(['message' => 'Замовлення успішно збережено']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Не вдалося зберегти замовлення: ' . $e->getMessage()]);
    }

    exit;
}

echo json_encode(['error' => 'Невідома дія']);
