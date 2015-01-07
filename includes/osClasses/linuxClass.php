<?php

//Этот класс только для работы с WINDOWS
class OSWorker{
    
    //Убить процесс с заданным PID'ом
    public function killPID($pid){
        shell_exec('kill -9 ' . $pid . ' 2>/dev/null &');
    }
    
    //Запустить PHP скрипт
    public function run($port){
        return popen(PHP . ' ' .PATH . '/readers/readPort.php ' . $port . ' 2>/dev/null &', 'r');
    }
    
    //Устновить настройки для работы с  COM-портом
    public function setMode($port){
        shell_exec('stty -F ' . $port . ' 4800 raw');
    }
    
    //Открыть порт и вернуть указатель
    public function openPort($port, $mode = 'r'){
        $this->setMode($port);
        $fp = fopen($port, $mode);
        sleep(1);
        
        return $fp;
    }
    
    //Получить список COM-портов
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
        
        $coms = array();
        foreach($comsAttached[2] as $com){
            $coms[] = '/dev/'.$com;
        }
        
        return $coms;
    }
}

