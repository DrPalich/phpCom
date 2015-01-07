<?php

//Этот класс только для работы с WINDOWS
class OSWorker extends Worker{
    
    private $fPort;
    
    
    public function getFPort(){
        return $this->fPort;
    }
    
    //Установить настройки для работы с  COM-портом
    public function setMode($port){
        shell_exec('stty -F ' . $port . ' 4800 raw');
    }
    
    //Открыть порт и вернуть указатель
    public function open($port, $mode = 'r'){
        $port = '/dev/'.$port;
        
        $this->setMode($port);
        
        $this->fPort = fopen($port, $mode);
        if(!$this->fPort){
            echo 'Can\'t open port: ' . $port;
            return false;
        }
        
        //Необходима задержка для открытия порта
        sleep(2);
        return true;
    }
    
    //Получить список портов
    public function getComs(){
        $coms = shell_exec("dmesg | grep tty");
        preg_match_all("/: (.*) now attached to (tty[^\n]+)/i", $coms, $comsAttached);
        preg_match_all("/ (tty[^:\n]+): (.*) now disconnected/i", $coms, $comsDisconected);
        
        foreach($comsAttached[1] as $key => $devices){
            
            $connect = $devices . ':' . $comsAttached[2][$key] . PHP_EOL;
            
            foreach($comsDisconected[2] as $keyD => $devicesD){
                
                $disconnect = $devicesD . ':' . $comsDisconected[1][$keyD] . PHP_EOL;
                
                if($connect == $disconnect){
                    unset($comsAttached[1][$key]);
                    unset($comsAttached[2][$key]);
                    unset($comsDisconected[1][$keyD]);
                    unset($comsDisconected[2][$keyD]);
                    break;
                }
            }
        }
        
        return $comsAttached[2];
    }
}

