<?php 

// This file serves all data to the graphs.
// Takes different parameters to server the right data
// PMB 03-06-2016

require_once('../config/config.php');
require_once('libs/functions.php');

// initialise variables 03-06-2016 PMB
$siteid = 100000;
$year = date('Y');
$period_type = 'week';

if (isset($_REQUEST['year'])) {
    $year = $_REQUEST['year'];    
}


// split up the string with all siteids to include in graph PMB 07-06-2016
$siteids = $_REQUEST['siteids'];
$allids = explode(',', $siteids);

// array to store all data PMB 07-06-2016
$data = array();



// loop all siteids to get data PMB 07-06-2016
foreach ($allids as $siteid) {
    // get the data for the siteid PMB 07-06-2016
   $libData = getSingleData($siteid, $period_type, $year);
   array_push($data, $libData);
}

$smarty->assign('data', $data);

$smarty->display('statistics_csv.tpl');          



?>