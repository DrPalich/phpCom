<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


define('PATH', __DIR__ . '/../');

$os = php_uname();

if(strtolower(substr($os, 0, 7)) == 'windows'){
    define('OS',  'WINDOWS');
    define('PHP', 'D:/WebServices/nginx/php/php.exe');
    include_once PATH . 'includes/osClasses/windowsClass.php'; 
}
elseif(strtolower(substr($os, 0, 5)) == 'linux'){
    define('OS',  'LINUX');
    define('PHP', '/usr/bin/php');
    include_once PATH . 'includes/osClasses/linuxClass.php'; 
}
else{
    die("Not suuport OS");
}

$os = new OSWorker();