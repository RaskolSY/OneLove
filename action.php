<?php
session_start();
require_once "connect.php";
require_once "classes/pr20.php";

if (!isset($_SESSION['id'])) {
    header("Location: index.php?page=add_bit&error=Авторизуйтесь сначала");
    exit();
}

// Для отладки (временно)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    if (!empty($_FILES)) {
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
    }

    //exit(); // раскомментируйте, чтобы увидеть только данные
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Авторизация
    if ($action === 'login') {
        $login = trim($_POST['login'] ?? '');
        $pass = trim($_POST['pass'] ?? '');

        if (empty($login) || empty($pass)) {
            header("Location: index.php?page=auth&error=Заполните все поля");
            exit();
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['pass'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            $_SESSION['status'] = $user['status'] ?? 1;
            header("Location: index.php");
            exit();
        } else {
            // Проверка старого MD5 пароля
            $stmt = $db->prepare("SELECT * FROM users WHERE login = ? AND pass = ?");
            $stmt->execute([$login, md5($pass)]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $newHash = password_hash($pass, PASSWORD_DEFAULT);
                $updateStmt = $db->prepare("UPDATE users SET pass = ? WHERE id = ?");
                $updateStmt->execute([$newHash, $user['id']]);

                $_SESSION['id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                $_SESSION['status'] = $user['status'] ?? 1;

                header("Location: index.php");
                exit();
            }

            header("Location: index.php?page=auth&error=Неверный логин или пароль");
            exit();
        }
    }

    // Регистрация
    if ($action === 'reg') {
        $login = trim($_POST['login'] ?? '');
        $pass = trim($_POST['pass'] ?? '');
        $fio = trim($_POST['fio'] ?? '');
        $mail = trim($_POST['mail'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $adress = trim($_POST['adress'] ?? '');

        if (empty($login) || empty($pass) || empty($fio) || empty($mail)) {
            header("Location: index.php?page=reg&error=Заполните обязательные поля");
            exit();
        }

        $checkStmt = $db->prepare("SELECT id FROM users WHERE login = ?");
        $check->execute([$login]);
        if ($check->fetch()) {
            header("Location: index.php?page=reg&error=Логин уже занят");
            exit();
        }

        $hashPass = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (login, pass, fio, mail, phone, adress, status) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->execute([$login, $hashPass, $fio, $mail, $phone, $adress]);

        $_SESSION['id'] = $db->lastInsertId();
        $_SESSION['login'] = $login;
        $_SESSION['status'] = 1;

        header("Location: index.php?message=Регистрация успешна");
        exit();
    }

    // Добавление бита с лицензиями
    if ($action === 'add_new_bit_with_licenses') {
        if (!isset($_SESSION['id'])) {
            header("Location: index.php?page=add_bit&error=Авторизуйтесь сначала");
            exit();
        }

        $name = trim($_POST['name'] ?? '');
        $janr = trim($_POST['janr'] ?? '');
        $ton = trim($_POST['ton'] ?? '');
        $bpm = trim($_POST['bpm'] ?? '');
        $opis = trim($_POST['opis'] ?? '');

        if (empty($name) || empty($janr) || empty($ton) || empty($bpm)) {
            header("Location: index.php?page=add_bit&error=Заполните обязательные поля");
            exit();
        }

        // Загрузка обложки
        $uploadObl = $db->upload('obl', '/uploads/images/');
        if (isset($uploadObl['error'])) {
            header("Location: index.php?page=add_bit&error=" . urlencode($uploadObl['error']));
            exit();
        }
        $oblPath = '/uploads/images/' . $uploadObl['filename'];

        // Загрузка MP3
        $uploadMp3 = $db->upload('mp3', '/uploads/beats/');
        if (isset($uploadMp3['error'])) {
            header("Location: index.php?page=add_bit&error=" . urlencode($uploadMp3['error']));
            exit();
        }
        $mp3Path = '/uploads/beats/' . $uploadMp3['filename'];

        // Загрузка WAV (опционально)
        $wavPath = '';
        if (!empty($_FILES['wav']['name'])) {
            $uploadWav = $db->upload('wav', '/uploads/beats/');
            if (isset($uploadWav['error'])) {
                header("Location: index.php?page=add_bit&error=" . urlencode($uploadWav['error']));
                exit();
            }
            $wavPath = '/uploads/beats/' . $uploadWav['filename'];
        }

        try {
            // Вставка бита
            $stmt = $db->prepare("INSERT INTO bit (
                id_users, name, autor, obl, opis, mp3, wav, janr, nastr, ton, bpm, status, date
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())");

            $stmt->execute([
                $_SESSION['id'],
                $name,
                $_SESSION['login'],
                $oblPath,
                $opis,
                $mp3Path,
                $wavPath,
                $janr,
                'studio',
                $ton,
                $bpm
            ]);

            $bitId = $db->lastInsertId();

            // Обработка лицензий
            $licenses = $_POST['licenses'] ?? [];

            foreach ($licenses as $index => $license) {
                if (!is_array($license)) continue;

                // Проверяем наличие всех полей
                $requiredFields = [
                    'name' => 'Название',
                    'zapisMus' => 'Запись музыки',
                    'vistup' => 'Коммерческие выступления',
                    'kolPros' => 'Онлайн прослушивания',
                    'kolProdCop' => 'Проданные копии',
                    'kolRadio' => 'Радио',
                    'kolVideo' => 'Видео',
                    'price' => 'Цена'
                ];

                foreach ($requiredFields as $field => $label) {
                    if (!array_key_exists($field, $license)) {
                        echo "Ошибка: в лицензии #{$index} не хватает '{$label}'<br>";
                        continue 2;
                    }
                }

                $stmtLicense = $db->prepare("INSERT INTO license (
                    id_users, id_bit, name, zapisMus, vistup, kolPros, kolProdCop, kolRadio, kolVideo, price
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmtLicense->execute([
                    $_SESSION['id'],
                    $bitId,
                    $license['name'],
                    $license['zapisMus'],
                    $license['vistup'],
                    $license['kolPros'],
                    $license['kolProdCop'],
                    $license['kolRadio'],
                    $license['kolVideo'],
                    $license['price']
                ]);
            }

        } catch (PDOException $e) {
            file_put_contents('pdo_errors.log', $e->getMessage() . "\n", FILE_APPEND);
            header("Location: index.php?page=add_bit&error=Ошибка при добавлении бита");
            exit();
        }

        header("Location: index.php?page=my_bits&message=Бит и лицензии успешно добавлены");
        exit();
    }

    // Обновление статуса бита
    if ($action === 'update_status') {
        if ($_SESSION['status'] != 100) {
            header("Location: index.php?error=Доступ запрещён");
            exit();
        }

        $id = $db->replaceParam($_POST['id'] ?? '', 'int');
        $status = $db->replaceParam($_POST['status'] ?? '', 'int');

        if (!$id) {
            header("Location: index.php?page=my_bits&error=Не указан ID бита");
            exit();
        }

        $stmt = $db->prepare("UPDATE bit SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);

        header("Location: index.php?page=my_bits&message=Статус изменён");
        exit();
    }

    // Удаление бита
    if ($action === 'delete_bit') {
        if ($_SESSION['status'] != 100) {
            header("Location: index.php?error=Доступ запрещён");
            exit();
        }

        $id = $db->replaceParam($_POST['id'] ?? '', 'int');
        if (!$id) {
            header("Location: index.php?page=my_bits&error=Не указан ID бита");
            exit();
        }

        $stmt = $db->prepare("DELETE FROM bit WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: index.php?page=my_bits&message=Бит удалён");
        exit();
    }

    // Подтверждение покупки
    if ($action === 'submit_application') {
        if (!isset($_SESSION['id'])) {
            header("Location: index.php?page=auth");
            exit();
        }

        $id_bit = $db->replaceParam($_POST['id_bit'] ?? '', 'int');
        $id_users = $_SESSION['id'];

        if (!$id_bit || !$id_users) {
            header("Location: index.php?error=Ошибка при оформлении покупки");
            exit();
        }

        $stmt = $db->prepare("INSERT INTO `order` (id_bit, id_users) VALUES (?, ?)");
        $stmt->execute([$id_bit, $id_users]);

        header("Location: index.php?message=Вы успешно купили бит!");
        exit();
    }

    // Выход
    if ($action === 'quit') {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

// GET-выход
if (isset($_GET['action']) && $_GET['action'] === 'quit') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>