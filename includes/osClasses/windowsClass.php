<?php

//Этот класс только для работы с WINDOWS
class OSWorker{
    
    //Убить процесс с заданным PID'ом
    public function killPID($pid){
        shell_exec('start "" /b taskkill  /f /pid ' . $pid);
    }
    
    //Запустить PHP скрипт
    public function run($port, $timeout){
        return popen('start "" /b ' . PHP . ' ' .PATH . '/readers/readPort.php ' . $port . ' ' . ($timeout -1), 'r');
    }
    
    //Устновить настройки для работы с  COM-портом
    public function setMode($port){
        shell_exec('mode ' . $port . ': BAUD=9600 PARITY=N data=8 stop=1 xon=off');
    }
    
    //Открыть порт и вернуть указатель
    public function openPort($port, $mode = 'r'){
        $this->setMode($port);
        return fopen($port . ':', $mode);
    }
    
    //Получить список COM-портов
    public function getComs(){
        $coms = shell_exec("MODE");
        preg_match_all("/com\d+/i", $coms, $coms);
        $coms = $coms[0];
        
        return $coms;
    }
}

