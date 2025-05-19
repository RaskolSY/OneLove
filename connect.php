<?php
session_start();
require_once "classes/pr20.php";

$ini_fields = parse_ini_file('config.ini', true);
define("DB_HOST", $ini_fields['database']['host']);
define("DB_NAME", $ini_fields['database']['base']);
define("DB_USER", $ini_fields['database']['user']);
define("DB_PASW", $ini_fields['database']['pass']);

try {
    $db = new pr20(DB_USER, DB_PASW, DB_HOST, DB_NAME);
} catch (Exception $e) {
    die("Ошибка подключения к БД");
}

require_once "action.php";
?>