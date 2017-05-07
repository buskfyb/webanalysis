<?php

// This config file is common for backend and frontend.$_COOKIE
// It provides the database, smarty object and global variables
// 28-05-2016 PMB

// variables that will be different between installations are collected in this file 28-05-2016 PMB
require_once('config_vars.php');

// smarty template engine is included. Be sure the location of this file is in 
// the include path in your php.ini, or set include path locally
// 28-05-2016 PMB
require_once('Smarty.class.php');


// smarty template engine is instanstiated.  28-05-2016 PMB
$smarty = new Smarty(); // global object used by both frontend and backend 28-05-2016 PMB

$smarty->setTemplateDir($rootdir . '/smarty/templates/');
$smarty->setCompileDir($rootdir . '/smarty/templates_c/');
$smarty->setConfigDir($rootdir . '/smarty/configs/');
$smarty->setCacheDir($rootdir . '/smarty/cache/');


$dblink = mysqli_connect($host, $user, $pass, $dbname);

if (!$dblink) {
    die('Connect Error: ' . mysqli_connect_error());
}

mysqli_set_charset($dblink, "utf8");

$monthNames = ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember'];

?>
