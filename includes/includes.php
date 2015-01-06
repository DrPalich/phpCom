<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('PHP', 'D:/WebServices/nginx/php/php.exe');
define('PATH', __DIR__ . '/../');

$os = php_uname();
if(strtolower(substr($os, 0, 7)) == 'windows'){
    define("OS", 'WINDOWS');
    include_once PATH . 'includes/osClasses/windowsClass.php'; 
}
else{
    die("Not suuport OS");
}

$os = new OSWorker();