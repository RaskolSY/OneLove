<?php
class pr20 {
    public $dbs;

    // Подключение к БД
    function __construct($user, $pass, $host, $dbname) {
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

        try {
            $this->dbs = new PDO($dsn, $user, $pass, $opt);
            $this->dbs->exec("SET NAMES utf8mb4");
            $GLOBALS['info'] = "Связь установлена";
        } catch (Exception $e) {
            $GLOBALS['info'] = "Связь не установлена";
            // Для отладки можно раскомментировать:
            // die("Ошибка подключения к БД: " . $e->getMessage());
        }
    }

    // Выполняет обычный SQL-запрос
    public function query($sql) {
        return $this->dbs->query($sql);
    }

    // Подготавливает запрос с параметрами
    public function prepare($sql) {
        return $this->dbs->prepare($sql);
    }

    // Выполняет запрос без возврата результата
    public function execute($sql) {
        return $this->dbs->exec($sql);
    }

    // Получает последний ID
    public function lastInsertId() {
        return $this->dbs->lastInsertId();
    }

    // Транслитерация текста
    public function translit($str) {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch',
            'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
        ];

        return strtr($str, $converter);
    }

    // Загрузка файлов с фильтрацией
    public function upload($inputName, $path = '/uploads/beats/') {
    if (!isset($_FILES[$inputName])) return ['error' => 'Файл не загружен'];
    $file = $_FILES[$inputName];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Ошибка загрузки файла'];
    }

    // Проверка расширения
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['mp3', 'wav', 'jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($ext, $allowedExtensions)) {
        return ['error' => 'Недопустимый формат файла'];
    }

    // Создание имени
    $newName = $this->translit(pathinfo($file['name'], PATHINFO_FILENAME)) . '.' . $ext;
    $uploadPath = __DIR__ . "/.." . ltrim($path, '/');
    
    // Создание папки, если её нет
    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $uploadPath . '/' . $newName)) {
        return ['success' => 'Файл загружен', 'filename' => $newName];
    }

    return ['error' => 'Не удалось переместить файл'];
}

    // Фильтрация данных
    public function replaceParam($param, $type = 'atr') {
        switch ($type) {
            case 'atr':
                return htmlspecialchars(strip_tags($param));
            case 'int':
                return intval($param);
            case 'txt':
                return trim($param);
            case 'md5':
                return md5(trim(strtolower($param)));
            default:
                return $param;
        }
    }

    // Сообщение об успехе/ошибке
    public function message($text) {
        return "<div class='alert alert-success'>$text</div>";
    }

    // Проверяет, авторизован ли пользователь
    public function isAuth() {
        return isset($_SESSION['id']);
    }

    // Получает ID текущего пользователя
    public function getCurrentUserId() {
        return $_SESSION['id'] ?? null;
    }
}
?>