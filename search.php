<?php
include 'includes/config.inc.php';
require 'php-sdk/src/temboo.php';

//array of days of the week used for displaying store hours
$days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");


if(isset($_POST['go'])){

		if(isset($_POST['address'])){


			
			// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
			$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY); 

			$geocodeByAddress = new Google_Geocoding_GeocodeByAddress($session);

			// Get an input object for the Choreo
			$geocodeByAddressInputs = $geocodeByAddress->newInputs();
			
			$address = $_POST['address'];
			$sensor = "false";
			$btype = $_POST['btype'];
			$radius = $_POST['radius'];


			if(empty($radius)){
				$radius = 1609.34; //default it to 1 mile
			}
			else{

				//convert miles from the form into meters for Google API
				$radiusInmeters = milesTometers($radius);
			}

			// Set inputs
			$geocodeByAddressInputs->setSensor($sensor)->setAddress($address)->setResponseFormat("json");

			// Execute Choreo and get results
			$geocodeByAddressResults = $geocodeByAddress->execute($geocodeByAddressInputs)->getResults();


			$lat = $geocodeByAddressResults->getLatitude();
			$lng = $geocodeByAddressResults->getLongitude();

			$placeSearch = new Google_Places_PlaceSearch($session);

			// Get an input object for the Choreo
			$placeSearchInputs = $placeSearch->newInputs();

			// Set inputs
			$placeSearchInputs->setKey(PLACES_KEY)->setRadius($radiusInmeters)->setTypes($btype)->setResponseFormat("json")->setLatitude($lat)->setLongitude($lng);


			// Execute Choreo and get results
			$placeSearchResults = $placeSearch->execute($placeSearchInputs)->getResults();

			$resultsArray = json_decode($placeSearchResults->getResponse(),true);


			//Get the details for the specific places which includes business hours
			$placeDetails = new Google_Places_PlaceDetails($session);

			// Get an input object for the Choreo
			$placeDetailsInputs = $placeDetails->newInputs();

			// Set inputs
			$placeDetailsInputs->setKey(PLACES_KEY)->setSensor($sensor)->setResponseFormat("json");

				}
					}
?>
<head>
<script src="<?php echo SITE_BASE; ?>/includes/js/jquery-1.10.2.js"></script>
</head>
<body>
<div align="center">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="text" name="address" maxlength="200" size="100"><input type="submit" name="go" value="go">
<br>
<select name="btype">
<?php
//iterate through the array of google place types to render in a drop-down
for($k = 0; $k < count($places); $k++){

	//format the select drop-down with title case versions of place types
	$displayPlace = str_replace("_", " ", $places[$k]);
	$displayPlace = ucwords($displayPlace);

	if($btype == $places[$k]){
	echo "<option value=" . $places[$k] . " selected>" . $displayPlace . "</option>";
	}
	else{
	echo "<option value=" . $places[$k] . ">" . $displayPlace . "</option>";
	}

}

?>
</select>
<input type="text" name="radius" value="">&nbsp;&nbsp;in miles
</form>
</div>
<div id="result" align="center">
<?php 

if(isset($_POST['address'])){
echo $address . "<br>";
echo "Latitude is " . $lat . " and " . " Longitude is " . $lng;	 

echo "<br><br>";

$listOfdetails = array();

for($i=0; $i<count($resultsArray['results']); $i++) {
//echo "Reference is " . $resultsArray['results'][$i]["reference"] . "<br>";
//echo "Name is " . $resultsArray['results'][$i]["name"] . "<br>";

	$reference = $resultsArray['results'][$i]["reference"];
	$placeDetailsInputs->setReference($reference);

			// Execute Choreo and get results
	$placeDetailsResults = $placeDetails->execute($placeDetailsInputs)->getResults();

	$listOfdetails[] = json_decode($placeDetailsResults->getResponse(),false);

	}//end for

	for ($i = 0 ; $i < count($listOfdetails) ; $i++){

		$openClosed = "CLOSED";

		$isOpened = $listOfdetails[$i]->result->opening_hours->open_now;

		if($isOpened){
			$openClosed = "OPEN";
		}

		echo $listOfdetails[$i]->result->name . "  " . $openClosed  . "<br>";
		echo $listOfdetails[$i]->result->formatted_address . "<br>";
		echo $listOfdetails[$i]->result->formatted_phone_number . "<br>";

		for($j = 0 ; $j < count($listOfdetails[$i]->result->opening_hours->periods) ; $j++){


			echo $days[$listOfdetails[$i]->result->opening_hours->periods[$j]->open->day] .  " : " . date("h:i a",strtotime($listOfdetails[$i]->result->opening_hours->periods[$j]->open->time)) . " - " . date("h:i a",strtotime($listOfdetails[$i]->result->opening_hours->periods[$j]->close->time)) . "<br>";

						}//end for

		echo "<br><br>";
	}//end for

}
?>
</div>
</body>

