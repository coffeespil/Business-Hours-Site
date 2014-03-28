<?php
include 'includes/config.inc.php';

$bhoursRefs = array("1234","5678","910991","192829","3747589449");
$gplaceRefs = array("1234","910991","6262ddjdksk","828282828282","22282");

$bhoursRefs = getBHoursrefs();

//these are the refs that dont require an API call. get then from bhours db
$alreadyHave = array_intersect($bhoursRefs, $gplaceRefs); 


//these are the refs that require an API call
$needToget = array_diff($gplaceRefs, $bhoursRefs);

//function to insert refs into bhours db

$plDetailsref = array("Name 12","Name 2","Name 3","Name 4");
$plDetailsName = array("Name 13","Name 2","Name 3","Name 4");
$plDetailsAddr = array("Name 17","Name 2","Name 3","Name 4");
$plDetailsPhone = array("Name 19","Name 2","Name 3","Name 4");
$plDetailsHrs = array("Name 144","Name 2","Name 3","Name 4");


for($i = 0 ; $i<count($plDetailsref) ; $i++){
	$sqlInsert = mysql_query("INSERT INTO " . REFERENCES . " (ref_id, busn_name, busn_address, phone, busn_hours) VALUES('" . $plDetailsref[$i] . "','" . $plDetailsName[$i] . "','" . $plDetailsAddr[$i] . "','" . $plDetailsPhone[$i] . "','" . $plDetailsHrs[$i] . "')", $link) or die("Unable to insert data");
											}





//retrieves all of the place references from bhours database
function getBHoursrefs(){

	$refs = array();

	//get all of the availble ref ids in the db
	$bhoursRefids = mysql_query("SELECT ref_id from " . REFERENCES . ";");

	while($result = mysql_fetch_array($bhoursRefids)){
			$refs[] = $result['ref_id']; 
	} //end while

	return $refs;
}//end fn


/*
$insertRefs = mysql_query("INSERT INTO " .REFERENCES. " (ref_id, busn_name, busn_address, phone, busn_hours) VALUES('$arrayOfrefs[0]','Target','123 Main St. New, NY','5162737337','727272727')", $link) or die("Unable to insert data");

$insertRefs2 = mysql_query("INSERT INTO " .REFERENCES. " (ref_id, busn_name, busn_address, phone, busn_hours) VALUES('$arrayOfrefs[1]','Target','123 Main St. New, NY','5162737337','727272727')", $link) or die("Unable to insert data");

$insertRefs3 = mysql_query("INSERT INTO " .REFERENCES. " (ref_id, busn_name, busn_address, phone, busn_hours) VALUES('$arrayOfrefs[2]','Target','123 Main St. New, NY','5162737337','727272727')", $link) or die("Unable to insert data");
*/

?>

