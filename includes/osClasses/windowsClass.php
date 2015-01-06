<?php

//Этот класс только для работы с WINDOWS
class OSWorker{
    
    //Убить процесс с заданным PID'ом
    public function killPID($pid){
        ob_start();
        shell_exec('taskkill  /f /pid ' . $pid);
        $content = ob_get_contents();
        ob_end_clean();
    }
    
    //Запустить PHP скрипт
    public function run($port, $timeout){
        return popen('start "" /b ' . PHP . ' ' .PATH . '/readers/readPort.php ' . $port . ' ' . ($timeout -1), 'r');
    }
    
    //Устновить настройки для работы с  COM-портом
    public function setMode($port){
        shell_exec('mode ' . $port . ': BAUD=9600 PARITY=N data=8 stop=1 xon=off');
    }
    
    //Получить список COM-портов
    public function getComs(){
        $coms = shell_exec("MODE");
        preg_match_all("/com\d+/i", $coms, $coms);
        $coms = $coms[0];
        
        return $coms;
    }
}

