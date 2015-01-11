<?php


//Завершить процесс с указанным PID
function killPID($pid){
    switch(OS){
        case 'WINDOWS':
            shell_exec('1>nul 2>&1 taskkill  /f /t /pid ' . $pid );
            return true;
        break;
        case 'LINUX':
            shell_exec('kill -9 ' . $pid . ' 2>/dev/null &');
            return true;
        break;
    }
    
    return false;
}


function popenReader($port){

    $params = '"' . $port . '"';
    
    switch(OS){
        case 'WINDOWS':
            $process =  popen('start "" /b ' . PHP . ' ' .PATH . '/tools/reader.php ' . $params, 'r');
        break;
        case 'LINUX':
            $process =  popen(PHP . ' ' .PATH . '/tools/reader.php ' . $params . ' 2>/dev/null &', 'r');
            //echo shell_exec(PHP . ' ' . PATH . '/tools/reader.php ' . $params);die();
        break;
    }
    
    sleep(2);
    
    if($process) return $process;
    //Задержка неоходимя для того, что бы скрипт успел открыть порт
    return false;
}

function delay($ms){
    $time_exit = time()+$ms;
    while(time()< $time_exit);
}

function writePortResult($port, $data){
    static $line = 0;
    
    if(strlen($data)){
        $data = time() . '|' . $data;
    }
    
    $file = PATH . 'tools/ports/' . $port . '_result.txt';
    
    if($line == 0){
        file_put_contents($file,'');
    };
    
    file_put_contents($file, $data, FILE_APPEND);
    
    $line++;
}

function getPortResult($port, $resetFile = false){
    
    $file   = PATH . 'tools/ports/' . $port . '_result.txt';
    
    $result = file($file);
    
    if($resetFile == true) file_put_contents ($file, '');
    
    return $result;
   
}

function _log($message){
    
    ob_start();
    
    print_r($message);
    echo PHP_EOL;
    ob_flush();
    ob_end_flush();
}


function parseResponce($responce){
    
    if(is_array($responce)){
        $array = array();
        foreach($responce as $item){
            $r       = parseResponce($item);
            $array[] = array_pop($r);
        }
        
        return $array;
    }
    
    $array = array();
    
    $args = explode('|', trim($responce));
    
    $array['date'] = date('Y-m-d H:i:s', $args[0]);
    
    if($args[1] == "ArduinoHome"){
        $array['data'] = "ArduinoHome";
        
        return array($array);
    } 
    
    unset($args[0]);
    
    $array['data']           = array();
    $array['data']['device'] = $args[1];
    $array['data']['values'] = array_combine(explode(',', $args[2]), explode(',', $args[3]));
    
    return array($array);
   
}