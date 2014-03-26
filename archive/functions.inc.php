<?php
require $_SERVER['DOCUMENT_ROOT'].'/bhours/php-sdk/src/temboo.php';

//API credentials
define("TEMBOO_NAME","coffeespil");
define("TEMBOO_PROJ","myFirstApp");
define("TEMBOO_KEY","eeed6c5954ae483c92bde95136ad8a97");
define("PLACES_KEY","AIzaSyDvDhrZ4ev2aSiEucD5VdVjaBsCYwISDpw");

	
// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
global $session; 
$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY); 


//this function returns a list of placedetails including business hours
function getPlaceDetails($jsonFile){

	global $session;
	$sensor = false;
	$listOfdetails = array();

	//Get the details for the specific places which includes business hours
	$placeDetails = new Google_Places_PlaceDetails($session);

	// Get an input object for the Choreo
	$placeDetailsInputs = $placeDetails->newInputs();

	// Set inputs
	$placeDetailsInputs->setKey(PLACES_KEY)->setSensor($sensor)->setResponseFormat("json");



	for($i=0; $i<count($jsonFile['results']); $i++) {

//echo "Reference is " . $jsonFile['results'][$i]["reference"] . "<br>";
//echo "Name is " . $jsonFile['results'][$i]["name"] . "<br>";

		$reference = $jsonFile['results'][$i]["reference"];

		$placeDetailsInputs->setReference($reference);

		// Execute Choreo and get results
		$placeDetailsResults = $placeDetails->execute($placeDetailsInputs)->getResults();

		$listOfdetails[] = json_decode($placeDetailsResults->getResponse(),false);

	}//end for

	return $listOfdetails;

}
//end fn


function getplaceReferences($radius,$btype,$lat,$lng){

	global $session;
	$resultsArray = array();

	$placeSearch = new Google_Places_PlaceSearch($session);

	// Get an input object for the Choreo
	$placeSearchInputs = $placeSearch->newInputs();

	// Set inputs
	$placeSearchInputs->setKey(PLACES_KEY)->setRadius($radius)->setTypes($btype)->setResponseFormat("json")->setLatitude($lat)->setLongitude($lng);

	// Execute Choreo and get results
	$placeSearchResults = $placeSearch->execute($placeSearchInputs)->getResults();

	$resultsArray = json_decode($placeSearchResults->getResponse(),true);

	return $resultsArray;

}
//end fn

function getCoordinates($address){

	global $session; 
	$coordinates = array();
	$sensor = false;

	$geocodeByAddress = new Google_Geocoding_GeocodeByAddress($session);

	// Get an input object for the Choreo
	$geocodeByAddressInputs = $geocodeByAddress->newInputs();
			
	// Set inputs
	$geocodeByAddressInputs->setSensor($sensor)->setAddress($address)->setResponseFormat("json");

	// Execute Choreo and get results
	$geocodeByAddressResults = $geocodeByAddress->execute($geocodeByAddressInputs)->getResults();

	//store the coordinates in an array
	$coordinates['lat'] = $geocodeByAddressResults->getLatitude();
	$coordinates['lng'] = $geocodeByAddressResults->getLongitude();

	return $coordinates;

} //end fn


?>