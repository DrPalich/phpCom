<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Worker{
    
    private $fPort;
    
    public function write($data, $delay_ms = 0){
        $this->checkfPort();
        
        fwrite($this->fPort, $data . "\n");
        delay($delay_ms);

    }
    
    public function gets(){
        $this->checkfPort();
        
        return fgets($this->fPort, 1024);
    }
    
    private function checkfPort(){
        
        $this->fPort = $this->getFPort();
        
        if(!$this->fPort) {
            echo $error = "Port not open!!" . PHP_EOL;
            trigger_error($error, E_USER_ERROR);
        }
    }
    
    public function close(){
        return fclose($this->fPort);
    }
}