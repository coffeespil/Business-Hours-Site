<?php
include 'includes/config.inc.php';
include 'includes/nav.inc.php';

//array of days of the week used for displaying store hours
$days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");

//store out day of the week in numeric format for display in store hours
$today = date('w');


if(isset($_POST['go'])){

		if(isset($_POST['address'])){


			//$coordinates = array();
			$address = filter($_POST['address']);

			//$sensor = "false";
			//$btype = $_POST['btype'];
			$radius = $_POST['radius'];


			if(empty($radius)){
				$radius = 1609.34; //default it to 1 mile
			}
			else{

				//convert miles from the form into meters for Google API
				$radiusInmeters = milesTometers($radius);
			} //end empty


			$refArray = getPlaceReferencesviaText($address,$radius);
			 
			$references = array();


			for($i = 0;$i < count($refArray['results']) ; $i++){

				//store out place references to be used to get details
				$references[] = $refArray['results'][$i]["reference"];

			} //end for



	//Get the details for the specific places which includes business hours
	$placeDetails = new Google_Places_PlaceDetails($session);

	// Get an input object for the Choreo
	$placeDetailsInputs = $placeDetails->newInputs();

	// Set inputs
	$placeDetailsInputs->setKey(PLACES_KEY)->setSensor($sensor)->setResponseFormat("json");


	//iterate through each reference to out place details including store hours
	for($i = 0 ; $i < count($references) ; $i++){

		$placeDetailsInputs->setReference($references[$i]);

			// Execute Choreo and get results
		$placeDetailsResults = $placeDetails->execute($placeDetailsInputs)->getResults();

		$listOfdetails = json_decode($placeDetailsResults->getResponse(),true);

		$listDisplay .= "<br><br>";
		$listDisplay .= $listOfdetails['result']["name"] . "<br>";
		$listDisplay .= $listOfdetails['result']["adr_address"] . "<br>";
		$listDisplay .= $listOfdetails['result']["formatted_phone_number"] . "<br>";
		$listDisplay .= formatOpenClosed($listOfdetails['result']["opening_hours"]["open_now"]) . "<br><br>";

					for($j = 0 ; $j < count($listOfdetails['result']["opening_hours"]["periods"]) ; $j++){

						//check if it's todaty's date and highlight the respective row
						if($days[$listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["day"]] == $days[$today]){

							$listDisplay .= "<b>" . $days[$listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["day"]] . " | " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["time"])) . " - " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["close"]["time"])) . "</b><br>";

						}

						else{

							$listDisplay .= $days[$listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["day"]] . " | " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["open"]["time"])) . " - " . date("h:i a",strtotime($listOfdetails['result']["opening_hours"]["periods"][$j]["close"]["time"])) . "<br>";
						} //end if
					}//end for
					echo "<br><br>";
	} //end for 


		} //end address
				
} //end go
?>
<head>
<script src="<?php echo SITE_BASE; ?>/includes/js/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>
<body>
<div align="center">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="text" name="address" maxlength="200" size="100"><input type="submit" name="go" value="find nearby">
<input type="text" name="radius" value="">&nbsp;&nbsp;in miles
</form>
<div id="result" align="left">
<?php
		if(!empty($listDisplay)){

			echo $listDisplay;
		}

?>
</div>
</body>

