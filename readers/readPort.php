<?php

// Отключаем вывод ошибок, ибо они будут мешать
error_reporting(~E_ALL);
ini_set('error_display', 0);

//Выводим наш PID, дабы родитель мог грохнуть если скрипт зависнет
echo getmypid() . PHP_EOL;

//Подкючаем общий файл
include_once __DIR__ . '/../includes/includes.php';

//Читаем параметры
$com     = $argv[1];
$timeout = $argv[2];

//Файл для вывода результата
$file = PATH . '/readers/ports/' . md5($com) . 'result.txt';
file_put_contents($file, '');

//открываем порт для записи и чтения
$fp = $os->openPort($com , "r+");
if (!$fp) {
    die();
} 
else {
    
    //Пауза
    sleep(2);
    
    //Who are you?
    fwrite($fp, "#wau#");
    
    //Читаем ответ
    sleep(1);
    $content = fgets($fp); 
    
    file_put_contents($file, $content);
}
fclose ($fp);