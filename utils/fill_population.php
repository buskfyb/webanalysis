<?php

require_once('../config/config.php');

// returns all libraries except for the data record used to store the total for all libraries 01-07-2016
function getAllLibs() {
    global $dblink;
    global $total_id; // the id that is used for the total traffic for all sites
    if (!$result = mysqli_query($dblink, "SELECT id, libraryname, siteid, population FROM libraries WHERE siteid != 0 ")) {echo mysqli_error($dblink);exit();}    
    $retArray = mysqli_fetch_all($result);

    return $retArray;    
}


$allLibs = getAllLibs();

foreach ($allLibs as $lib) {
        $siteid = $lib[2];
        $population = $lib[3];

        $sql = "UPDATE traffic SET population = ? WHERE siteid = ?";
        $stmt = mysqli_prepare($dblink, $sql);
        mysqli_stmt_bind_param($stmt, "dd", $population, $siteid);
        $res = mysqli_stmt_execute($stmt);
        echo $siteid . " " . $population . " " . $res . "\n";
}



?>