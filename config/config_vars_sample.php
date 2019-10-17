<?php

// variables that will be different between installations are header_register_callback 28-05-2016 PMB

date_default_timezone_set('Europe/Oslo'); 

// URL to the piwik instance 28-05-2016 PMB
$piwikURL = '';

// auth token for logging into Piwik 28-05-2016 PMB
$piwikAuth = '';

// connecting to the db, using mysqli 28-05-2016 PMB
$host = ''; // hostname of db server 28-05-2016 PMB
$pass = ''; // password for db user  28-05-2016 PMB
$user = ''; // username for db 28-05-2016 PMB
$dbname = ''; // name of database 28-05-2016 PMB


// change to the rootdir of your application. Will be the same as the documentroot in your vhost 28-05-2016 PMB
$rootdir = '/var/www/html/web';

$total_id = '100000'; // siteid used in database to hold total data for all libraries. Default is 100000

$startYear = 2016; // year when it all started. used to display select-box in frontend

$development = 0; // if set to 1, a message will show on all frontend and backend screens PMB 2017-05-05

?>