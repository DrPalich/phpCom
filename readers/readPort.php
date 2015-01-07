<?php

// Отключаем вывод ошибок, ибо они будут мешать
error_reporting(~E_ALL);
ini_set('error_display', 0);

//Выводим наш PID, дабы родитель мог грохнуть если скрипт зависнет
echo getmypid() . PHP_EOL;

//Подкючаем общий файл
include_once __DIR__ . '/../includes/includes.php';

//Читаем параметры
$com  = $argv[1];

//Файл для вывода результата
$file = PATH . '/readers/ports/' . $com . '_result.txt';
file_put_contents($file, '');

//открываем порт для записи и чтения
$fp = $PORT->open($com , "r+");
if (!$fp) {
    die();
} 

//Who are you?
$PORT->write("#wau#");

//Читаем ответ
$PORT->gets(); 

file_put_contents($file, $content);

$PORT->close();