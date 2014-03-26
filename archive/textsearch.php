<?php
//include 'includes/config.inc.php';
require 'php-sdk/src/temboo.php';
include 'includes/nav.inc.php';

//API credentials
define("TEMBOO_NAME","coffeespil");
define("TEMBOO_PROJ","myFirstApp");
define("TEMBOO_KEY","eeed6c5954ae483c92bde95136ad8a97");
define("PLACES_KEY","AIzaSyDvDhrZ4ev2aSiEucD5VdVjaBsCYwISDpw");


$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY); 

$qry = "TD Bank, New York, NY 10025";
$radius = 1609.34;

// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
$get = new Utilities_HTTP_Get($session);

// Get an input object for the Choreo
$getInputs = $get->newInputs();

// Set inputs for Google Key and Query here. 
$getInputs->setRequestParameters("{\"key\": \"" . PLACES_KEY . "\", \"sensor\": false, \"query\": \"" . $qry . "\", \"radius\": '$radius' }")->setURL("https://maps.googleapis.com/maps/api/place/textsearch/json");

// Execute Choreo and get results
$getResults = $get->execute($getInputs)->getResults();

$resultsArray = json_decode($getResults->getResponse(),true);


print_r($resultsArray);

?>