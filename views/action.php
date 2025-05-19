<html lang="ru">
<?php
global $db;
if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'reg') {
        if (empty($_REQUEST['login']) || empty($_REQUEST['pass'])) {
            $message = 'Не введены поля логин/пароль';
        } else {
            $r = $db->dbs->prepare('SELECT * FROM users WHERE login=:id');
            $r->execute([':id' => $_REQUEST['login']]);
            if ($r->rowCount() == 0) {
                $r = $db->dbs->prepare('SELECT * FROM users;');
                $r->execute();
                ($r->rowCount() != 0) ? $status = 1 : $status = 100;
                $mas = [
                    'login' => $_REQUEST['login'],
                    'pass' => $_REQUEST['pass'],
                    'fio' => $_REQUEST['fio1']." ".$_REQUEST['fio2']." ".$_REQUEST['fio3'],
                    'phone' => $_REQUEST['phone'],
                    'adress' => $_REQUEST['adress'],
                    'mail' => $_REQUEST['mail'],
                    'status' => $status
                ];
                ($db->actionTable('add', $mas, 'users')) ? $message = 'Регистрация прошла успешно' : $message = 'Произошла ошибка в момент регистрации';
            } else $message = 'Пользователь с таким логином уже существует';
        }
    }
    if ($_REQUEST['action']=='auth'){
        if (empty($_REQUEST['login']) || empty($_REQUEST['pass'])){
            $message='Не введены поля логин/пароль';
        }else{
            $r=$db->dbs->prepare('SELECT * FROM users WHERE login=:id AND pass=:i1');
            $r->execute([':id'=>$_REQUEST['login'], ':i1'=>md5($_REQUEST['pass'])]);
            if ($r->rowCount()!=0){
                foreach ($r as $res){
                    $_SESSION['id']=$res['id'];
                    $_SESSION['login']=$res['login'];
                    $_SESSION['status']=$res['status'];
                    $message='Вы успешно авторизовались';
                }
            }else $message="Не найдет пользователь с такими логин/пароль";
        }
    }
    if ($_REQUEST['action']=='quit'){
        unset($_SESSION['id']);
        unset($_SESSION['login']);
        unset($_SESSION['status']);
        session_destroy();
        $message='Вы вышли из системы';
    }
    if ($_REQUEST['action']=='addCateg'){
        if (!empty($_FILES['url'])) {
            $mas_files=$db->uploading('url');
            if (count($mas_files)!=0){
                foreach ($mas_files as $res){
                    $mas=[
                        'nazvanie'=>$_REQUEST['nazvanie'],
                        'url'=>$res,
                        'marka'=>$_REQUEST['marka'],
                        'model'=>$_REQUEST['model'],
                        'price'=>$_REQUEST['price'] 
                    ];
                    ($r=$db->actionTable('add', $mas, 'tovar'))?$message.="Товар успешно добавлен":$message="Произошла ошибка при добавлен товара";
                }
            }
        }else{
            $mas=[
                'nazvanie'=>$_REQUEST['nazvanie'],
                'marka'=>$_REQUEST['marka'],
                'model'=>$_REQUEST['model'],
                'price'=>$_REQUEST['price'] 
            ];
            ($r=$db->actionTable('add', $mas, 'tovar'))?$message.="Товар успешно добавлен":$message="Произошла ошибка при добавлен товара";
        }
    }
    if ($_REQUEST['action']=='editCateg'){
        if (!empty($_FILES['url'])) {
            $mas_files=$db->uploading('url');
            if (count($mas_files)!=0){  
                foreach ($mas_files as $res){
                    $mas=[
                        'id'=>$_REQUEST['id'],
                        'nazvanie'=>$_REQUEST['nazvanie'],
                        'url'=>$res,
                        'marka'=>$_REQUEST['marka'],
                        'model'=>$_REQUEST['model'],
                        'price'=>$_REQUEST['price'] 
                    ];
                    ($r=$db->actionTable('edit', $mas, 'tovar'))?$message.="Товар успешно изменен":$message="Произошла ошибка при изменении товара";
                }
            }
        }else{
            $mas=[
                'id'=>$_REQUEST['id'],
                'nazvanie'=>$_REQUEST['nazvanie'],
                'marka'=>$_REQUEST['marka'],
                'model'=>$_REQUEST['model'],
                'price'=>$_REQUEST['price'] 
            ];
            ($r=$db->actionTable('edit', $mas, 'tovar'))?$message.="Товар успешно изменен":$message="Произошла ошибка при изменении товара";
        }
    }
    if ($_REQUEST['action']=='delCat'){
        ($db->actionTable('del', $_REQUEST['id'], 'tovar'))?$message='Товар успешно удален':$message='Произошла ошибка при удалении товара';
    }
    if ($_REQUEST['action']=='delOrder'){
        ($db->actionTable('del', $_REQUEST['id'], 'orders'))?$message='Товар успешно удален':$message='Произошла ошибка при удалении товара';
    }
    if ($_REQUEST['action'] == 'editZav') {
        $mas = [
            'id' => $_REQUEST['id'],
            'status' => $_REQUEST['status']
        ];
        ($r = $db->actionTable('edit', $mas, 'orders')) ? $message .= "Статус заявки изменён" : $message = "Произошла ошибка при изменении статуса заявки";
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'submit_application') {
    // Проверяем, чтобы все обязательные поля были заполнены
    if (isset($_POST['id_tovar'])) {
        // Подключение к базе данных
$con = new mysqli("localhost", "cx54108_shumilov", "77445Web", "cx54108_shumilov");

// Проверка соединения с базой данных
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
        // Получаем данные из формы
        $id_tovar = $_POST['id_tovar'];
        $id_users = $_SESSION['id'];
        $current_date=date('Y-m-d H:i:s');

        // Подготовка SQL запроса для вставки данных заявки в таблицу
        $sql = "INSERT INTO orders (id_tovar, date, id_users, status) VALUES (?, '$current_date',?, 'Ждет подтверждения оплаты')";
        
        // Подготавливаем запрос
        $stmt = $con->prepare($sql);

        if ($stmt) {
            // Привязываем параметры и выполняем запрос
            $stmt->bind_param("ii", $id_tovar, $id_users);
            $stmt->execute();

            // Проверяем успешность выполнения запроса
            if ($stmt->affected_rows > 0) {
                echo "Заявка успешно отправлена!";
            } else {
                echo "Ошибка при отправке заявки: " . $con->error;
            }

            // Закрываем запрос
            $stmt->close();
        } else {
            echo "Ошибка при подготовке запроса: " . $con->error;
        }
    } else {
        // Если какое-то из обязательных полей не было заполнено, выводим сообщение об ошибке
        echo "Не все обязательные поля были заполнены!";
    }
} 
}