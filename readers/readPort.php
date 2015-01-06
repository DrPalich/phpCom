<?php

// Отключаем вывод ошибок, ибо они будут мешать
error_reporting(~E_ALL);
ini_set('error_display', 1);

//Выводим наш PID, дабы родитель мог грохнуть если скрипт зависнет
echo getmypid() . PHP_EOL;

//Подкючаем общий файл
include_once __DIR__ . '/../includes/includes.php';

//Читаем параметры
$com     = $argv[1];
$timeout = $argv[2];

//Файл для вывода результата
$file = PATH . '/readers/ports/' . $com . 'result.txt';
file_put_contents($file, '');

//Устанавливаем параметры соединения
$os->setMode($com);

//открываем порт для записи и чтения
$fp = fopen ($com . ":", "r+");
if (!$fp) {
    die();
} 
else {
    sleep(2);
    fwrite($fp, "H");
    
    sleep(2);
    fwrite($fp, "#wau#");
    
    sleep(2);
    $content = fgets($fp); 
    file_put_contents($file, $content);
    fwrite($fp, "L");

}
fclose ($fp);