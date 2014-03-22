<?php
include 'includes/config.inc.php';
include 'includes/nav.inc.php';

//array of days of the week used for displaying store hours
$days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");


if(isset($_POST['go'])){

		if(isset($_POST['address'])){


			$coordinates = array();
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
			} //end empty

			//call getCoordinates to return an array containing latitude and longitude
			$coordinates = getCoordinates($address);

			$lat = $coordinates['lat'];
			$lng = $coordinates['lng'];

			$placesJson = getplaceReferences($radius,$btype,$lat,$lng);
			$detailsArray = getPlaceDetails($placesJson);



/*
			for($i = 0;$i < count($placesJson['results']) ; $i++){
				echo "<a href='" . $_SERVER['PHP_SELF'] . "?ref=" . $placesJson['results'][$i]["reference"] . "'>" . $placesJson['results'][$i]["name"] . "</><br>" . $placesJson['results'][$i]["vicinity"] . "<br><br><br>";
			}
*/


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

if(!empty($detailsArray)){

		for ($i = 0 ; $i < count($detailsArray) ; $i++){

		$openClosed = "CLOSED";

		$isOpened = strval($detailsArray[$i]->result->opening_hours->open_now);

		if($isOpened){
			$openClosed = "OPEN";
		}

		echo strval($detailsArray[$i]->result->name) . "  " . $openClosed  . "<br>";
		echo strval($detailsArray[$i]->result->formatted_address) . "<br>";
		echo strval($detailsArray[$i]->result->formatted_phone_number) . "<br>";

		for($j = 0 ; $j < count($detailsArray[$i]->result->opening_hours->periods) ; $j++){


			echo strval($days[$detailsArray[$i]->result->opening_hours->periods[$j]->open->day]) .  " : " . date("h:i a",strtotime($detailsArray[$i]->result->opening_hours->periods[$j]->open->time)) . " - " . date("h:i a",strtotime($detailsArray[$i]->result->opening_hours->periods[$j]->close->time)) . "<br>";

						}//end for
				echo "<br><br>";

					} //end for
} //end if
?>
</div>
</body>

