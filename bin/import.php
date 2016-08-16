<?php

// include the config file of the web application to get the database and the URL to piwik 28-05-2016 PMB
require_once(dirname(__FILE__) . '/../config/config.php');


function recordExists($siteid, $period, $year, $period_type) {
    global $dblink;
    if (!$stmt = mysqli_prepare($dblink, "SELECT id FROM traffic WHERE siteid = ? AND period = ? AND year = ? AND period_type = ?")) {echo mysqli_error($dblink);exit();}    
    if (!mysqli_stmt_bind_param($stmt, "ddds", $siteid, $period, $year, $period_type)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    if (!mysqli_stmt_bind_result($stmt, $id)) {echo mysqli_error($dblink);exit();} 
    mysqli_stmt_fetch($stmt);

    if (!empty($id)) {return $id;}
    else {return 0;}

}


function insertData($pData, $siteid, $period, $period_type, $year) {
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "INSERT INTO traffic (siteid, period, year, visitors, 
        pageviews, visit_time, bounce_rate, visits, period_type, change_percent) VALUES (?,?,?,?,?,?,?,?,?,?)")) {
        echo mysqli_error($dblink);
        exit();
    }
    if (!mysqli_stmt_bind_param($stmt, "ddddddddsd", $siteid, $period, $year, $pData['nb_uniq_visitors'], $pData['nb_actions'],
        $pData['avg_time_on_site'], $pData['bounce_rate'], $pData['nb_visits'], $period_type, $pData['change_percent'])) {
            echo mysqli_error($dblink);
            exit();
        }

    if (!mysqli_stmt_execute($stmt)) {
        print_r($pData);
        echo $siteid;
         echo mysqli_error($dblink);
         exit();
    }
    $lastid = mysqli_insert_id($dblink);
    return $lastid;
}

function updateData($id, $pData) {
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "UPDATE traffic SET visitors = ?, 
        pageviews = ?, visit_time = ?, bounce_rate = ?, visits = ?, change_percent = ? WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }
    if (!mysqli_stmt_bind_param($stmt, "ddddddd", $pData['nb_uniq_visitors'], $pData['nb_actions'],
        $pData['avg_time_on_site'], $pData['bounce_rate'], $pData['nb_visits'], $pData['change_percent'], $id)) {
            echo mysqli_error($dblink);
            exit();
        }

    if (!mysqli_stmt_execute($stmt)) {
         echo mysqli_error($dblink);
         exit();
    }
}



function getData($siteid,$today,$period_type) {
    global $piwikURL;
    global $piwikAuth;

    // params for the curl call 28-05-2016 PMB
    $params = array(
        'module' => 'API',
        'format' => 'json',
        'method' => 'VisitsSummary.get',
        'idSite' => $siteid,
        'period' => $period_type,
        'date' => $today,
        'token_auth' => $piwikAuth
    );

    // init curl object 28-05-2016 PMB
    $ch = curl_init();
    // Set URL to download 28-05-2016 PMB
    curl_setopt($ch, CURLOPT_URL, $piwikURL);
    // send the params 28-05-2016 PMB
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    // make curl return data instead of printing 28-05-2016 PMB
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // get data 28-05-2016 PMB
    $retData = curl_exec($ch);
     // Close the cURL resource, and free system resources 28-05-2016 PMB
    curl_close($ch);

    return $retData;   
}

// returns all libraries except for the data record used to store the total for all libraries 01-07-2016
function getAllLibs() {
    global $dblink;
    global $total_id; // the id that is used for the total traffic for all sites
    if (!$result = mysqli_query($dblink, "SELECT id, libraryname, siteid FROM libraries WHERE id != " . $total_id)) {echo mysqli_error($dblink);exit();}    
    $retArray = mysqli_fetch_all($result);

    return $retArray;    
}

// small helper function just to calculate a period from a date and period_type
function getPeriod($thedate, $period_type) {
    if ($period_type == 'week') {
        $week = date('W', strtotime($thedate));
        // handle turn of year 01-06-2016
        $year = date('Y', strtotime($thedate));
        if (strtotime($thedate) < strtotime($year . '-01-10')) {
            if ($week == 53) {return "0";} else return $week;            
            }
        else return $week;
        }
   else {
        return date('n', strtotime($thedate));
        }
}

// function that fetches data from piwik and inserts into db. 
// it takes the id of the site, a date and a period_type as arguments. 
// Legal values for period_type is month and week
// 30-05-2016 PMB
function doForLib($siteid, $thedate, $period_type) {
 
        // get the year from the date 30-05-2016 PMB       
        $year = date('Y', strtotime($thedate));

        // get the week or month number and set as period, based on the date and period_type 30-05-2016 PMB
        $period = getPeriod($thedate, $period_type);

        // get the data from piwik 30-05-2016 PMB
        $retData = getData($siteid, $thedate, $period_type);
        $pData = json_decode($retData, true);

        // get visits for last period to calculate change
        $lastvisits = getVisits($siteid, $year, $period-1, $period_type);

        // calculate change in percent
        $change_percent = 0; // initialize 01-06-2016 PMB
        if ($lastvisits != 0) {
            // parting up calcultation. First we multiply by 1.0 to make variables into floats
            $tmp = ($pData['nb_visits'] * 1.0) - ($lastvisits * 1.0);
            $tmp = $tmp / $lastvisits;
            $change_percent = number_format($tmp * 100, 2);
        }

        $pData['change_percent'] = $change_percent;
        
        // check if record exists, if so do an update 30-05-2016 PMB
        if ($id = recordExists($siteid, $period, $year, $period_type)) {    
           echo "Finnes: " . $id . "\n";
           updateData($id, $pData);
        }
        // if the record does not exist, we do an insert 30-05-2016 PMB
        else {
            echo "Finnes ikke" . "\n";
            $insertid = insertData($pData, $siteid, $period, $period_type, $year);
            print $insertid . "\n";
        }    
}


function updateTotalTraffic($thedate, $period_type) {
    global $dblink;
    global $total_id;

    // First we set year, month and week calculated from the date PMB 01-07-2016
    $year = date('Y', strtotime($thedate));
    $period = getPeriod($thedate, $period_type);
    
    
    // get total data for the period
    if (!$stmt = mysqli_prepare($dblink, "SELECT SUM(visitors) as totalvisitors, SUM(pageviews) as totalpageviews, 
    SUM(visits) as totalvisits, CAST(AVG(visit_time) AS UNSIGNED) as total_visit_time, CAST(AVG(bounce_rate) AS UNSIGNED)
    as total_bonuce_rate FROM `traffic` WHERE year = ? AND period = ? AND period_type = ? AND  siteid != ?")) {echo mysqli_error($dblink);exit();}    
    if (!mysqli_stmt_bind_param($stmt, "ddsd", $year, $period, $period_type, $total_id)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    if (!mysqli_stmt_bind_result($stmt, $totalvisitors, $totalpageviews, $totalvisits, $total_visit_time, $total_bounce_rate)) {echo mysqli_error($dblink);exit();} 
    mysqli_stmt_fetch($stmt);   

    // closing the stmt to free up resources 01-07-2016 PMB
    mysqli_stmt_close($stmt);

    // build same data structure as we get from Piwik, so we can reuse old functions
    $pData = array(
        'nb_uniq_visitors' => $totalvisitors , 
        'nb_actions' => $totalpageviews,
        'avg_time_on_site' => $total_visit_time,
        'bounce_rate' => $total_bounce_rate,
        'nb_visits' => $totalvisits
    );

    // get visits for last period to calculate change 01-06-2016 PMB
    $lastvisits = getVisits($total_id, $year, $period-1, $period_type);

    // calculate change in percent 01-06-2016 PMB
    $change_percent = 0; // initialize 01-06-2016 PMB
    if ($lastvisits != 0) {
            // parting up calcultation. First we multiply by 1.0 to make variables into floats
            $tmp = ($pData['nb_visits'] * 1.0) - ($lastvisits * 1.0);
            $tmp = $tmp / $lastvisits;
            $change_percent = number_format($tmp * 100, 2);
    }

    $pData['change_percent'] = $change_percent;

    // check if record exists, if so do an update 30-05-2016 PMB
    if ($id = recordExists($total_id, $period, $year, $period_type)) {    
        echo "Finnes: " . $id . "\n";
        updateData($id, $pData);
    }
    // if the record does not exist, we do an insert 30-05-2016 PMB
    else {
        echo "Finnes ikke" . "\n";
        $insertid = insertData($pData, $total_id, $period, $period_type, $year);
        print $insertid . "\n";
    }
    
}

// helperfunction that returns number of visits for a given site a given period 01-06-2016 PMB
function getVisits($siteid, $year, $period, $period_type) {
    global $dblink;

    // if the period is the first then we just return 0
    if ($period < 0) {
        if ($year == 2016) { // 2016 is first year 01-06-2016 PMB
            return 0; // return 0 since no prior data
        }
        else { // we are in another year, maybe 2048! so handle turn over of year 01-06-2016 PMB
            if ($period_type == 'week') {
                $period = 53;  // if week, then we use last week last year
                $year = $year--;
            }
            else {
                $period = 12; // if month we use last month last year
                $year = $year--;
            }
        }
    }

    if (!$stmt = mysqli_prepare($dblink, "SELECT visits FROM `traffic` WHERE siteid = ? AND year = ? AND period = ? AND period_type = ?")) {echo mysqli_error($dblink);exit();}    
    if (!mysqli_stmt_bind_param($stmt, "ddds", $siteid, $year, $period, $period_type)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    if (!mysqli_stmt_bind_result($stmt, $visitors)) {echo mysqli_error($dblink);exit();} 
    mysqli_stmt_fetch($stmt);   

    // closing the stmt to free up resources 01-07-2016 PMB
    mysqli_stmt_close($stmt);

    return $visitors;
}

// entry point to start all data collection for a given date 01-06-2016 PMB
function doLibsForDate($thedate) {
    $allLibs = getAllLibs();

    foreach ($allLibs as $lib) {
        $siteid = $lib[2];
        doForLib($siteid, $thedate, 'week');
        doForLib($siteid, $thedate, 'month');
    }

    // update the total traffic for the week and month where the date occurs
    updateTotalTraffic($thedate, 'week');
    updateTotalTraffic($thedate, 'month');   
}


// Execution starts here. PMB 30-05-2016 PMB

// thedate is the date used to identify week and month at Piwik PMB 01-06-2016 PMB
// set the date to work on. If it is not set on the command line, get the date today
if (empty($argv[1])) {
        $thedate = date('Y-m-d');
        doLibsForDate($thedate);    
}
else {
    // validate the date given on command line 01-06-2016 PMB
    if (strtotime($argv[1])) {
        $thedate = $argv[1];            
        doLibsForDate($theDate);
    }
    elseif ($argv[1] == 'all') {  // we are to import all data from startdate 01-06-2016 PMB
        // date from when we want to import data
        // default to january first 2016. Change to your liking 01-06-2016 PMB
        $current = date_create('2016-01-01');
        $enddate = date_create();

        while ($current < $enddate) {
            // get string version of the date 01-06-2016 PMB
            $thedate = date_format($current, 'Y-m-d');
            // do the libs for this date 01-06-2016 PMB
            doLibsForDate($thedate); 
            // subtract 7 days from current 01-06-2016 PMB
            $current = date_add($current, date_interval_create_from_date_string('7 days'));
        }
    }
    // this is an error situation we can not recover from. give message and exit 01-06-2016 PMB
    else {
        echo "Ikke gyldig dato. Bruk YYYY-MM-DD\n";
        exit();
    }
}



?>
