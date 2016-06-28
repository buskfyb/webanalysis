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
$field = 'visitors';

// set variables if we have some from request
if (isset($_REQUEST['field'])) {
    $field = $_REQUEST['field'];    
}

if (isset($_REQUEST['year'])) {
    $year = $_REQUEST['year'];    
}


// split up the string with all siteids to include in graph PMB 07-06-2016
$siteids = $_REQUEST['siteids'];
$allids = explode(',', $siteids);

// array to store all data PMB 07-06-2016
$data = array();

// counter to keep track of the position of the current site we are merging data PMB 07-06-2016
$c1 = 0;

// loop all siteids to get data PMB 07-06-2016
foreach ($allids as $siteid) {
    // get the data for the siteid PMB 07-06-2016
    $thisData = getDataYear($siteid, $year, $period_type, $field);
    $c2 = 0;
    foreach($thisData as $d) {
        // datastructure is filled. $c2 is the period, and the first position in the array is also the period
        // $c1 is the position for this particular site in the second dimension PMB 07-06-2016
        $data[$c2][0] = $d[0];
        $data[$c2][$c1+1] = ($d[1] + 0); // adding 0 to the value to ensure it is treated as an integer/float PMB 12-06-2016
        $c2++;
    }
    $c1++;
}



// encode datastructure as json and return to javascript frontend for presentation PMB 07-06-2016
echo json_encode($data);
        


?>