<?php

//Этот класс только для работы с WINDOWS
class OSWorker{
    
    //Убить процесс с заданным PID'ом
    public function killPID($pid){
        shell_exec('1>nul 2>&1 taskkill  /f /t /pid ' . $pid );
    }
    
    //Запустить PHP скрипт
    public function run($port){
        return popen('start "" /b ' . PHP . ' ' .PATH . '/readers/readPort.php ' . $port, 'r');
    }
    
    //Устновить настройки для работы с  COM-портом
    public function setMode($port){
        shell_exec('mode ' . $port . ': BAUD=9600 PARITY=N data=8 stop=1 xon=off');
    }
    
    //Открыть порт и вернуть указатель
    public function openPort($port, $mode = 'r'){
        $this->setMode($port);
        $fp = fopen($port . ':', $mode);
        //Задержка... Для того, чтоб порт успел открыться
        sleep(2);
        return $fp;
    }
    
    //Получить список COM-портов
    public function getComs(){
        $coms = shell_exec("MODE");
        preg_match_all("/com\d+/i", $coms, $coms);
        $coms = $coms[0];
        
        return $coms;
    }
}

