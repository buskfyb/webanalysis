<?php

// get all setup info. including db and smarty 28-05-2016 PMB
require_once('../config/config.php');
require_once('libs/functions.php');

// Init of variables 28-05-2016 PMB
$period = date('W')-1;
$period_type = 'week';
$year = date('Y');
$category = 0; // setting default category to 0 means showing all libraries PMB 2017-06-04

// If we have any values for these variables, set them 28-05-2016 PMB
if (isset($_REQUEST['period'])) {
    $period = $_REQUEST['period'];    
}
if (isset($_REQUEST['period_type'])) {
    $period_type = $_REQUEST['period_type'];    
}
if (isset($_REQUEST['year'])) {
    $year = $_REQUEST['year'];    
}
if (isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];    
}



// assigning an array with month names to be used in display PMB 14-06-2016
$smarty->assign('monthNames', $monthNames);
$smarty->assign('startYear', $startYear); // the year it all started PMB 14-06-2016
$smarty->assign('currentYear', $year);
$smarty->assign('currentCategory', $category);


$smarty->assign('thisYear', date('Y')); // the year it ended (for now) PMB 14-06-2016


// global var to show if we are in dev mode or not PMB 2017-05-05
$smarty->assign('development', $development);

// set up tracking if the tracking file exists PMB 2017-05-07
$tracking = 0;
if( $smarty->templateExists('frontend_tracking.tpl') ){
    $tracking = 1;
}
$smarty->assign('tracking', $tracking);



// If libid is set, we are dealing with a single library PMB 08-06-2016
if (isset($_REQUEST['libid'])) {
    $libData = getSingleData($_REQUEST['libid'], $period_type, $year);
    $smarty->assign('libraries', $libData);

    $smarty->assign('start_site_id', filter_var($_REQUEST['libid'], FILTER_SANITIZE_STRING));
    $smarty->assign('start_site_name', filter_var($_REQUEST['libname'],FILTER_SANITIZE_STRING));

    $smarty->assign('period', 0);
    $smarty->assign('period_type', $period_type);

    $smarty->assign('year', $year);    

    $smarty->display('frontend_single.tpl');          
}
else {   // else we are dealing with the front page
    $libData = getData($period, $period_type, $year, $category);

    $smarty->assign('categories', getCategories());
    $smarty->assign('category', $category);

    $smarty->assign('start_site_id', $total_id);
    $smarty->assign('start_site_name', 'Total');

    $smarty->assign('period', $period);
    $smarty->assign('period_type', $period_type);
    $smarty->assign('year', $year);    
    $smarty->assign('libraries', $libData);
    $smarty->display('frontend_front.tpl');  
}



?>