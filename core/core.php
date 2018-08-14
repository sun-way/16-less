<?php
require_once 'functions.php';

require "./vendor/autoload.php";
session_start();
$homeWorkNum = '5.1';
$homeWorkCaption = 'Менеджер зависимостей Composer.';
/**
 * Устанавливаем системные настройки
 */
ini_set("display_errors", "1"); // Показ ошибок
ini_set("display_startup_errors", "1");
ini_set('error_reporting', E_ALL);
mb_internal_encoding('UTF-8'); // Кодировка по умолчанию
/**
 * Загружаем классы
 */
spl_autoload_register(function($name) {
    $file = dirname(__DIR__) . '/core/' . $name . '.class.php';
    if (!file_exists($file)) {
        throw new Exception('Autoload class: File ' . $file . ' not found');
    }
    require $file;
});