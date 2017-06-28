<?php

require_once(dirname(__FILE__) . '/../config/config.php');


/********************************************

This script automatically updates the population for all kommuner and fylker. (categories 1 and 2)
They need to have correct kommunenummer and fylkesnummer,
Data is fetched from SSB

PMB 28/06/2017

********************************************/





## library picked from internett
# this URL: https://json-stat.org/tools/php

####### START OF LIB ####################



////Functions

//getValue() converts a dimension/category assoc array into a data value in three steps.
//Input example: array('concept'=>'UNR','area'=>'US','year'=>'2010')
//Output example: 9.627692959
function getValue( $jsonstat , $query ){

	//1. array('concept'=>'UNR','area'=>'US','year'=>'2010') ==> array(0, 33, 7)
	$indices=getDimIndices( $jsonstat , $query );

	// PMB PMB
	// Dirty hack to avoid libraries with wrong external_ref to get wrong population PMB 2017-06-23
	// this is due to no error handling in external lib
	if (empty($indices[0])) {return 0;}
	// end of hack

	//2. array(0, 33, 7) ==> 403
	$index=getValueIndex( $jsonstat , $indices );

	//3. 403 ==> 9.627692959
	$value=getValueByIndex( $jsonstat->value , $index );

	return $value;
}

//getDimIndices() converts a dimension/category assoc array into an array of dimensions' indices.
//Input example: array('concept'=>'UNR','area'=>'US','year'=>'2010')
//Output example: array(0, 33, 7)
function getDimIndices( $jsonstat , $query ){
	$dim=$jsonstat->dimension;
	//JSON-stat 2.0-ready
	$ids=( isset( $jsonstat->id ) ) ? $jsonstat->id : $dim->id;
	$ndims=count( $ids );

	$arr=array();
	for( $i=0; $i<$ndims ; $i++ ){
		$arr[$i]=getDimIndex( $dim , $ids[$i] , $query[$ids[$i]] );
	}

	return $arr;
}

//getValueIndex() converts an array of dimensions' indices into a numeric value index.
//Input example: array(0, 33, 7)
//Output example: 403
function getValueIndex( $jsonstat , $indices ){
	//JSON-stat 2.0-ready
	$size=( isset( $jsonstat->size ) ) ? $jsonstat->size : $jsonstat->dimension->size;
	$ndims=count( $size );
	$num=0;
	$mult=1;

	for( $i=0; $i<$ndims; $i++ ){
		$mult*=( $i>0 ) ? $size[$ndims-$i] : 1;
		$num+=$mult*$indices[$ndims-$i-1];
	}
	return $num;
}

//getDimIndex() converts a dimension ID string and a category ID string into the numeric index of that category in that dimension.
//Input example: "area", "US"
//Output example: 33
function getDimIndex( $dim , $name , $value ){
	//In single category dimensions, "index" is optional
	if( !isset( $dim->$name->category->index ) ){
		return 0;
	}

	$ndx=$dim->$name->category->index;

	//"index" can be an object or an array
	if( is_object( $ndx ) ){ //Object
		return $ndx->$value;
	}else{ //Array
		return array_search( $value , $ndx , TRUE );
	}
}

//getValueByIndex() converts a numeric value index into its data value.
//Input example: 403
//Output example: 9.627692959
function getValueByIndex( $val , $index ){
	//"value" can be an array or an object (sparse cube)
	return
		is_array( $val ) ?
		$val[$index] :
		$val->$index
	;
	//This check is avoidable if JSON is read into a
	//PHP assoc array (instead of an object). This is
	//not recommended, though, as the distinction
	//between assoc array and sequential array in
	//getDimIndex() would be less safe.
}

//JSONstat() connects to a URL and, if the response is valid JSON-stat, returns a PHP object.
function JSONstat( $url ){
	$resp=file_get_contents( $url );
	if( $resp===FALSE ){
		exit( 'Error: the contents of ' . $url . ' could not be retrieved.' . "\n" );
	}

	//Convert into object (instead of assoc array: safer to detect if category index is array or not)
	$jsonstat=json_decode( $resp );
	if( $jsonstat===NULL ){
		exit( 'Error: response was not valid JSON.' . "\n" );
	}

	//If no "class", "bundle" response:
	//use the first dataset available
	//(assuming single dataset bundle response)
	//[Of course, it'd be better to add an argument
	//to the function to pass a dataset ID if
	//bundle responses must be properly supported.]
	if( !isset( $jsonstat->class ) ){
		$dsname=each( $jsonstat )['key'];
		$jsonstat=$jsonstat->$dsname;
	}else{ //Verify it's a "dataset" response
		if( $jsonstat->class!='dataset' ){
			exit( 'Error: response was not a JSON-stat bundle or dataset response.' . "\n" );
		}
	}

	//Program requires "value" and "dimension" properties
	if( !isset( $jsonstat->value ) || !isset( $jsonstat->dimension ) ){
		exit( 'Error: response is not valid JSON-stat or does not contain required information.' . "\n" );
	}

	return $jsonstat;
}

//show() displays the query and its result.
function show( $query , $result ){
	foreach ($query as $key=>$value) {
		echo $key.'='.$value.' ';
	}
	echo '==> ' . $result . "\n";
}


/******************** END OF LIB *************************/


function getAllLibs($cat) {
    global $dblink;
    global $total_id; // the id that is used for the total traffic for all sites
    if (!$result = mysqli_query($dblink, "SELECT id, libraryname, siteid, population, external_ref FROM libraries WHERE external_ref != 0 and siteid != 0 AND category = " . $cat . " and id != " . $total_id . " ORDER BY libraryname")) {echo mysqli_error($dblink);exit();}    
    $retArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $retArray;    
}

function getStat($jsonstat, $external_ref) {
	$query = array(
	    "Region" => $external_ref,
	    "ContentsCode" => "Folketallet11",
	    "Tid" => ""
	);

	//Parse: Get value from $jsonstat and $query
	$value=getValue( $jsonstat , $query );

	return $value;
}


/*************************** EXECUTION STARTS HERE *************************/


/*************** FIRST WE DO KOMMUNER ********/

$jsonstat = JSONstat("https://data.ssb.no/api/v0/dataset/1108.json?lang=no");

$allLibs = getAllLibs(1); // returns all libs in cat 1, kommuner

foreach ($allLibs as $l) {
	if (!empty($l['external_ref'])) {
		$val = getStat($jsonstat, strval($l['external_ref']));

		if ($val != 0) {
			/* update population for the lib PMB 2017-06-23 */
			$query = "UPDATE libraries SET population = " . $val . ", import_msg = 'OK' WHERE siteid = " . $l['siteid'];
			mysqli_query($dblink, $query);
		}
		else {
			$query = "UPDATE libraries SET import_msg = 'Wrong  WHERE siteid = " . $l['siteid'];
			mysqli_query($dblink, $query);
		}
	}
}

//  updating total population when finished. NOTE: Only kommuner (kat=1) are counted
$totalQ = "SELECT SUM(population) as total_population FROM libraries WHERE category = 1 AND siteid != " . $total_id;
$res = mysqli_query($dblink, $totalQ);
$total = mysqli_fetch_assoc($res);
mysqli_query($dblink, "UPDATE libraries SET population = " . $total['total_population'] . " WHERE siteid = " . $total_id);




/*************** THEN WE DO FYLKER ********/

$jsonstat = JSONstat("https://data.ssb.no/api/v0/dataset/1102.json?lang=no");

$allLibs = getAllLibs(2); // returns all libs in cat 1, kommuner

foreach ($allLibs as $l) {
	if (!empty($l['external_ref'])) {
		$val = getStat($jsonstat, strval($l['external_ref']));

		if ($val != 0) {
			/* update population for the lib PMB 2017-06-23 */
			$query = "UPDATE libraries SET population = " . $val . ", import_msg = 'OK' WHERE siteid = " . $l['siteid'];
			mysqli_query($dblink, $query);
		}
		else {
			$query = "UPDATE libraries SET import_msg = 'Wrong  WHERE siteid = " . $l['siteid'];
			mysqli_query($dblink, $query);
		}
	}
}








?>
