<?php
include 'includes/config.inc.php';

secureSession();

$errMsgs = array();

if(isset($_POST['go'])){

		$address = filter($_POST['address']);
		$radius = $_POST['radius'];

		//check that something was filled in. otherwise, display a message
		if(empty($address)){

			$errMsgs[] = "Please provide a zip code and/or a place you're searching for.";
		}

		if(isset($address)){

			if(empty($radius)){
				$radius = 1609.34; //default it to 1 mile
			}
			else{

				//convert miles from the form into meters for Google API
				$radius = milesTometers($radius);
			} //end empty


			$refArray = getPlaceReferencesviaText($address,$radius);

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
<?php
include 'includes/nav.inc.php';
?>
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
<br>
<input type="submit" name="go" value="find nearby">
<input type="text" name="radius" value="">&nbsp;&nbsp;in miles
</form>
<form action="<?php echo "favorites.php"; ?>" method="post">
<div id="result" align="left">
<?php
	
	if(!empty($listDisplay)){
			echo "<input type='submit' name='add' value='add to favorites'><br>";
			echo $listDisplay;
		}
?>
</div>
</form>
</body>

