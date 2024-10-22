<!-- text.php -->
<?php
$log_file = 'log.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['logText'])) {
        $log_text = htmlspecialchars($_POST['logText']);
        file_put_contents($log_file, $log_text . PHP_EOL, FILE_APPEND);
        echo "Текст успішно додано до файлу log.txt.<br>";
    } else {
        echo "Текст не може бути порожнім.";
    }
}

// Виведення вмісту файлу
if (file_exists($log_file)) {
    echo "<h3>Вміст файлу log.txt:</h3>";
    echo nl2br(file_get_contents($log_file));
}
?>
