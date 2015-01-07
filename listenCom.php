<?php

error_reporting(E_ALL);

include __DIR__ . '/includes/includes.php';

$coms     = $os->getComs();

if(empty($coms)){
    echo 'Not found COM-ports';
    die();
}
else{
    echo 'Found ' . count($coms) . ' COM-ports' . PHP_EOL . PHP_EOL;
}

$timeout = 4;
foreach($coms as $com){
     
    // Запускаем скрипт чтения ПОРТА
    echo 'Start connecting to ' . $com . PHP_EOL;
    $proc = $os->run($com);
    
    // Запускаем, получаем PID  запущенного скрипта
    $pid = trim(fgets($proc)); 
    echo 'PID: ' . $pid . PHP_EOL;
    
    //Ждем
    sleep($timeout);
    
    //Завершаем запущенный скрипт
    $os->killPID($pid);
    echo 'Killed PID ' . $pid . PHP_EOL;
    
    //Закрываем указатель
    pclose($proc);
    echo 'Finish connceted to ' . $com . PHP_EOL;
    
    //читаем, что получили из порта
    $result = file_get_contents(PATH . '/readers/ports/' . md5($com) . 'result.txt');
    echo 'RESULT: ' . $result . PHP_EOL;
    
    echo PHP_EOL;
}


echo 'END' . PHP_EOL;

