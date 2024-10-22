<!-- process.php -->
<?php
$uploads_dir = 'uploads';
$max_file_size = 2 * 1024 * 1024; // 2 МБ
$allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file'])) {
        $file_error = $_FILES['file']['error'];
        
        // Перевірка на помилки завантаження
        if ($file_error !== UPLOAD_ERR_OK) {
            switch ($file_error) {
                case UPLOAD_ERR_INI_SIZE:
                    echo "Розмір файлу перевищує допустимий розмір, вказаний у php.ini.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo "Файл перевищує максимальний розмір, дозволений у формі.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "Файл було завантажено частково.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "Файл не було завантажено.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Відсутня тимчасова директорія.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Не вдалося записати файл на диск.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "Завантаження файлу було зупинено через розширення PHP.";
                    break;
                default:
                    echo "Сталася невідома помилка.";
            }
            exit;
        }

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $file = $_FILES['file'];
            $file_name = basename($file['name']);
            $file_type = $file['type'];
            $file_size = $file['size'];

            // Перевірка типу файлу
            if (!in_array($file_type, $allowed_types)) {
                echo "Допустимі лише файли PNG, JPG, JPEG.";
                exit;
            }

            // Перевірка розміру файлу
            if ($file_size > $max_file_size) {
                echo "Файл перевищує допустимий розмір у 2 МБ.";
                exit;
            }

            // Перевірка існування файлу з тим самим ім'ям
            $file_path = $uploads_dir . '/' . $file_name;
            if (file_exists($file_path)) {
                $file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . time() . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
                $file_path = $uploads_dir . '/' . $file_name;
            }

            if (!is_dir($uploads_dir)) {
                if (!mkdir($uploads_dir, 0755, true)) {
                    die("Не вдалося створити директорію для завантаження файлів.");
                }
            }

            // Завантаження файлу
            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                echo "Файл успішно завантажено!<br>";
                echo "Ім'я файлу: $file_name<br>";
                echo "Тип файлу: $file_type<br>";
                echo "Розмір файлу: " . round($file_size / 1024, 2) . " KB<br>";
                echo "<a href='$file_path'>Завантажити файл</a>";
            } else {
                echo "Сталася помилка при завантаженні файлу.";
            }
        } else {
            echo "Будь ласка, оберіть файл.";
        }
    }
}
?>
