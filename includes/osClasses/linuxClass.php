<?php

//Этот класс только для работы с WINDOWS
class OSWorker extends Worker{
    
    private $fPort;
    
    public function close(){
        pclose($this->fPort);
    }
    
    
    public function getFPort(){
        return $this->fPort;
    }
    
    //Установить настройки для работы с  COM-портом
    public function setMode($port){
        
        _log('start set params port');
        
        shell_exec('stty 9600 -F ' . $port . ' raw');
        
        _log('finish set parrams port');
        
    }
    
    //Читаем
    public function read(){
        return fgets($this->fPort, 1024);
    }
    
    public function write($data, $port = ''){
        $port = ($port) ? '/dev/'.$port : $this->port;
        
        if(empty($port)) return false;
        
        $command = 'echo "' . $data . '" > ' . $port;
        
        _log('Command: ' . $command . ' sending...');
        
        if(shell_exec($command) === false){
            _log('Command: ' . $command . ' not send');
        }
        
        _log('Command: ' . $command . ' sended');
        
        return true;
    }
    
    //Открыть порт и вернуть указатель
    public function open($port, $mode = 'r'){
        $port       = '/dev/'.$port;
        $this->port = $port;
        
        $this->setMode($port);
        
        $cat = 'cat ' . $port;
        
        _log('Start open port "cat"');
        
        $this->fPort = popen('cat ' . $port, $mode);
        
        
        if(!$this->fPort){
            _log('Can\'t open port: ' . $port);
            return false;
        }
        
        _log('Finish open port "cat"');
        
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

