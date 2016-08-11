<?php

// returns data for all libraries for a given period 28-05-2016 PMB
function getData($period, $period_type, $year) {
    // smarty and dblink are global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;
    

    // we get all data for all libraries 28-05-2016 PMB
    if (!$stmt = mysqli_prepare($dblink, "SELECT l.libraryname, l.siteid, l.population, t.visits, 
        t.visitors, t.pageviews, t.visit_time, t.bounce_rate, CAST((t.visits/l.population*1000) as UNSIGNED) as visits_per_pop, change_percent, (t.pageviews/t.visits) AS pages_per_visit, l.URL FROM libraries l join traffic t on l.siteid = t.siteid WHERE 
        period_type = ? AND period = ? AND year = ? ORDER BY t.visitors DESC")) {
        echo mysqli_error($dblink);
        exit();
    }

    if (!mysqli_stmt_bind_param($stmt, "sdd", $period_type, $period, $year)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    $result = mysqli_stmt_get_result($stmt);

    $retResult = array();
    
    // all data is fetched as a associative array 28-05-2016 PMB
    $retResult = mysqli_fetch_all($result, MYSQLI_BOTH);

    return $retResult;
}


// returns all data for a given year for a given library 08-06-2016 PMB
function getSingleData($siteid, $period_type, $year) {
    // smarty and dblink are global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;
    
    // cut off last period if we are showing data from current year PMB 09-06-2016
    $lastperiod = 53;
    $currentYear = date('Y');
    if ($year == $currentYear) {
        if ($period_type == 'month') {
            $lastperiod = date('m')-1;            
        }        
        else {
            $lastperiod = date('W')-1;                        
        }
    }

    // we get all data for this 28-05-2016 PMB
    if (!$stmt = mysqli_prepare($dblink, "SELECT l.libraryname, l.siteid, l.population, t.visits, t.period,
        t.visitors, t.pageviews, t.visit_time, t.bounce_rate, CAST((t.visits/l.population*1000) as UNSIGNED) as visits_per_pop, change_percent, (t.pageviews/t.visits) AS pages_per_visit FROM libraries l join traffic t on l.siteid = t.siteid WHERE 
        period_type = ? AND t.siteid = ? AND year = ? AND period <= ? ORDER BY t.period DESC")) {
        echo mysqli_error($dblink);
        exit();
    }

    if (!mysqli_stmt_bind_param($stmt, "sddd", $period_type, $siteid, $year, $lastperiod)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    $result = mysqli_stmt_get_result($stmt);

    $retResult = array();
    
    // all data is fetched as a associative array 28-05-2016 PMB
    $retResult = mysqli_fetch_all($result, MYSQLI_BOTH);

    return $retResult;
}


// returns all data for a site for a year for a given period_type
// the data is returned as a array of arrays.
function getDataYear($siteid, $year, $period_type, $field) {
    global $dblink;

    // cut off last period if we are showing data from current year
    $lastperiod = 53;
    $currentYear = date('Y');
    if ($year == $currentYear) {
        if ($period_type == 'month') {
            $lastperiod = date('m')-1;            
        }        
        else {
            $lastperiod = date('W')-1;                        
        }
    }

    // decide what to get
    $whatToGet = "";
    if ($field == 'average') {
        $whatToGet = "CAST((t.visits/l.population*1000) as UNSIGNED) as visits_per_pop";
    }
    else if ($field == 'pageviews_per_visit') {
        $whatToGet = "CAST((t.pageviews/t.visits) AS DECIMAL(12,2)) as pageviews_per_visit";
    }
    else {
        $whatToGet = "t." . $field;
    }

    // we get all data for all libraries 28-05-2016 PMB
    if (!$stmt = mysqli_prepare($dblink, "SELECT t.period, " . $whatToGet . " FROM traffic t JOIN libraries l on t.siteid = l.siteid WHERE 
        t.period_type = ? AND t.year = ? AND t.siteid = ? AND t.period <= ? ORDER BY t.period ASC")) {
        echo mysqli_error($dblink);
        exit();
    }

    if (!mysqli_stmt_bind_param($stmt, "sddd", $period_type, $year, $siteid, $lastperiod)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}
    $result = mysqli_stmt_get_result($stmt);

    $retResult = array();
    
    // all data is fetched as a associative array 28-05-2016 PMB
    $retResult = mysqli_fetch_all($result);

    return $retResult;    
}




?>