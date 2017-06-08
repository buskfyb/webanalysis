<?php 

// This file serves all data to the graphs.
// Takes different parameters to server the right data
// PMB 03-06-2016

require_once('../config/config.php');
require_once('libs/functions.php');

// initialise variables 03-06-2016 PMB
$year = $_REQUEST['year'];
$category = $_REQUEST['category'];
$period_type = 'week';

if (isset($_REQUEST['year'])) {
    $year = $_REQUEST['year'];    
}

$allids = array();

if ($_REQUEST['whichlibs'] == 'selected') {
    // split up the string with all siteids to include in graph PMB 07-06-2016
    $siteids = $_REQUEST['siteids'];
    $allids = explode(',', $siteids);
}
else {
    $allids = getAllIds(); // getting all libs from database
}
// array to store all data PMB 07-06-2016
$data = array();


// loop all siteids to get data PMB 07-06-2016
foreach ($allids as $siteid) {
    // get the data for the siteid PMB 07-06-2016
   $libData = getSingleData($siteid, $period_type, $year, MYSQLI_NUM);
   if (count($libData) > 0) { // if we have any elements at all PMB 07-06-2017
       if ($category == 0 || $libData[0][12] == $category) { // check if they match the category we ask for
           array_push($data, $libData); // if they do, then push to result array
       }
   }
}

$smarty->assign('data', $data);

header('Content-type: text/plain');

header("Content-type: text/csv");
header("Cache-Control: no-store, no-cache");
header('Content-Disposition: attachment; filename="statistics.csv"');

// $file = fopen('php://output','w');

$smarty->display('statistics_csv.tpl');          


?>