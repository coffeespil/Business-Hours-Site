<?php
include 'includes/config.inc.php';
include 'includes/nav.inc.php';

secureSession();

$errMsgs = array();

if(isset($_POST['go'])){

		$postal_code = filter($_POST['postal_code']);
		$address = filter($_POST['address']);
		$radius = $_POST['radius'];

		//check that something was filled in. otherwise, display a message
		if(empty($postal_code) && empty($address)){

			$errMsgs[] = "Please provide a zip code and/or a place you're searching for.";
		}

		if(isset($address) || isset($postal_code)){

			if(empty($radius)){
				$radius = 1609.34; //default it to 1 mile
			}
			else{

				//convert miles from the form into meters for Google API
				$radius = milesTometers($radius);
			} //end empty


			if(isset($postal_code) && isset($address)){
				echo "calling getPlaces Zip version" . "<br>";

				$refArray = getPlaceReferencesviaZip($postal_code,$address,$radius);
			}
			elseif(isset($address)) {		
				$refArray = getPlaceReferencesviaText($address,$radius);
			}

			$references = array();

			//parse the json and store out the ref ids into an array
			for($i = 0;$i < count($refArray['results']) ; $i++){

				//store out place references to be used to get details
				$references[] = $refArray['results'][$i]["reference"];

			} //end for

			//pass the references to the places API to display the hours
			$listDisplay = getPlaceDetails($references);
		} //end address
				
} //end go
?>
<head>
<script src="<?php echo SITE_BASE; ?>/includes/js/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="styles/styles.css"></link>
</head>
<body>
<div style="background-color:black;color:white;">
<?php
	
	foreach ($errMsgs as $key => $value) {
		echo $value . "<br>";
	}


?>
</div>
<div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
place name<br>
<input type="text" name="address" maxlength="200" size="40">
<br>zip code<br>
<input type="text" name="postal_code" maxlength="20" size="20">
<br>
<input type="submit" name="go" value="find nearby">
<input type="text" name="radius" value="">&nbsp;&nbsp;in miles
</form>
<form action="<?php echo "favorites.php"; ?>" method="post">
<input type="submit" name="add" value="add to favorites"><br>
<div id="result" align="left">
<?php
	
	if(!empty($listDisplay)){
			echo $listDisplay;
		}
?>
</div>
</form>
</body>

