<?php
require_once "connect.php";
require_once "action.php";
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>One Love</title>
   
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>One Love</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome/all.min.css">
	<link rel="stylesheet" href="assets/css/styles.css">

	<script src="assets/js/jquery.min.js"></script>


</head>

<body  class="d-flex flex-column min-vh-100" style="background-image: url('img/fong.jpg'); background-size:cover; ">
<div class="header">
<nav  class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">
            <img src="img/logo.png" width="40" height="40" class="d-inline-block align-top" alt="">
            <span class="ml-1" style="color: white; font-size: 35px;">One Love</span>
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <a class="nav-link btn btn-outline-dark" aria-current="page" href="index.php">Главная</a>
            </ul>            
            <?
            if (!isset($_SESSION['id'])){
            ?>
            <ul class="navbar-nav ">
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle btn nav-link btn-outline-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Начать продавать
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?page=auth">Войти</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?page=reg">Зарегистрироваться</a></li>
                    </ul>
                </li>
            </ul>
            <?
            }else{
                ?>
            <ul class="navbar-nav">
                <?
                if ($_SESSION['status']==100){
                    ?>
                    <li class="nav-item"><a href="index.php?page=admin" class="nav-link btn btn-outline-dark">Админка</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <?
                }
            ?>
            <li class="nav-item dropdown">
    <a class="nav-link p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <!-- Красивая круглая иконка -->
        <div class="user-icon d-flex align-items-center justify-content-center">
            <i class="fas fa-user"></i>
        </div>
    </a>

    <!-- Выпадающее меню -->
    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item d-flex align-items-center" href="index.php?page=kabinet"><i class="fas fa-user-circle me-2"></i> Мой профиль</a></li>
        <li><a class="dropdown-item d-flex align-items-center" href="index.php?page=favorites"><i class="fas fa-heart me-2"></i> Понравившиеся</a></li>
        <li class="nav-item">
    <a class="dropdown-item" href="index.php?page=my_bits">
        <i class="fas fa-list-alt me-2"></i>Мои биты
    </a>
</li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item d-flex align-items-center text-danger" href="index.php?action=quit"><i class="fas fa-sign-out-alt me-2"></i> Выход</a></li>
    </ul>
</li>
            <?
            ?>
            </ul>
            <?
            }
            ?>
        </div>
    </div>


    

</nav>
</div>
<div class="main">
<div class="container">
    <?
    (isset($message))? print $db->message($message):print '';
    (isset($_REQUEST['page']))?require_once "views/".$_REQUEST['page'].".php":require_once "views/default.php";
    ?>
</div>
</div>
<div class="footer mt-auto" style="display: flex; justify-content: space-between; align-items: center; background-color: black; color: white; padding: 20px;">
    <div class="container">
        <p >Адрес: г.Невинномысск ул.Междуреченская д.89</p>
        <p >Телефон: 89614473977</p>
        <p >Электронная почта: <a href="mailto:ваша почта">sersermanman555@gmail.com</a></p>
    </div>
</footer>
</body>
</html>
