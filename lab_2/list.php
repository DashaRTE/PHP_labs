<!-- list.php -->
<?php
$uploads_dir = 'uploads';

if (is_dir($uploads_dir)) {
    $files = scandir($uploads_dir);
    echo "<h3>Завантажені файли:</h3>";
    echo "<ul>";
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "<li><a href='$uploads_dir/$file' download>$file</a></li>";
        }
    }
    echo "</ul>";
} else {
    echo "Директорія uploads не існує.";
}
?>
