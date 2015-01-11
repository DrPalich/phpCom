<?php

error_reporting(E_ALL);

include __DIR__ . '/includes/includes.php';

$coms     = $PORT->getComs();

if(empty($coms)){
    echo 'Not found COM-ports';
    die();
}
else{
    echo 'Found ' . count($coms) . ' COM-ports' . PHP_EOL . PHP_EOL;
}

$success = false;

$timeout = 10;
foreach($coms as $com){
     
    // Запускаем скрипт чтения ПОРТА
    echo 'Open port  ' . $com . ' to READ' . PHP_EOL;
    $process = popenReader($com);
    
    //Получаем ID процесса чтния
    $IDreader = trim(fgets($process));
    _log('PID: ' . $IDreader);
 
    
    $PORT->write('#wau#', $com);
    
    //Ждем
    sleep($timeout);
    
    //читаем, что получили из порта
    $result = getPortResult($com); 
    echo 'RESULT: '. PHP_EOL; 
    $result = parseResponce($result[0]);
    print_r($result);
    echo PHP_EOL;
    echo PHP_EOL;
    
    if($result[0]['data'] == 'ArduinoHome'){ 
        $success = true;
        break;
    }    
     
    //Завершаем запущенный скрипт
    killPID($IDreader);
    echo 'Killed PID ' . $IDreader . PHP_EOL;
    
}


if(!$success) die();
getPortResult($com, true);
$PORT->open($com);
$PORT->write("0e0r01|TH");

while(1){
    
    sleep(3);
    
    $results = getPortResult($com, true);
    $results = parseResponce($results);
    
    print_r($results);
    
    
    die();
    
}


//Завершаем запущенный скрипт
killPID($IDreader);
echo 'Killed PID ' . $IDreader . PHP_EOL;
echo 'END' . PHP_EOL;

