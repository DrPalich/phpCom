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


function popenReadPort($port){
    
    switch(OS){
        case 'WINDOWS':
            return popen('start "" /b ' . PHP . ' ' .PATH . '/readers/readPort.php ' . $port, 'r');
        break;
        case 'LINUX':
            return popen(PHP . ' ' .PATH . '/readers/readPort.php ' . $port . ' 2>/dev/null &', 'r');
        break;
    }
    
    return false;
}
