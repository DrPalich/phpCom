<?php

//Этот класс только для работы с WINDOWS
class OSWorker{
    
    private $fPort;
    
    
    public function getFPort(){
        return $this->fPort;
    }
    
    //Устновить настройки для работы с COM-портом
    public function setMode($port){
        shell_exec('mode ' . $port . ': BAUD=9600 PARITY=N data=8 stop=1 xon=off');
    }
    
    //Открыть порт и вернуть указатель
    public function openPort($port, $mode = 'r'){
        $this->setMode($port);
        
        $this->fPort = fopen($port . ':', $mode);
        if(!$this->fPort){
            echo 'Can\'t open port: ' . $port;
            return false;
        }
        
        //Необходима задержка для открытия порта
        sleep(2);
        return true;
    }
    
    //Получить список COM-портов
    public function getComs(){
        $coms = shell_exec("MODE");
        preg_match_all("/com\d+/i", $coms, $coms);
        $coms = $coms[0];
        
        return $coms;
    }
}

