<?php

// Отключаем вывод ошибок, ибо они будут мешать
error_reporting(~E_ALL);
ini_set('error_display', 0);

//Выводим наш PID, дабы родитель мог грохнуть
echo getmypid() . PHP_EOL;

//Подкючаем общий файл
include_once __DIR__ . '/../includes/includes.php';

register_shutdown_function(create_function('', 'global $PORT->close();'));

//Читаем параметры
$com = $argv[1];

//Чистим файл
writePortResult($com,'');

//открываем порт для записи и чтения
$fp = $PORT->open($com, 'r');

//Если не удалось открыть файл
if (!$fp) { die(); } 

while(1){
    //Читаем ответ
    $content = $PORT->read(); 
    writePortResult($com, $content);
   
}
