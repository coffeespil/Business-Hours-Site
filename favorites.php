<?php
include 'includes/config.inc.php';

secureSession();

$Msgs = array();
$refArray = array();

/*
$refID = array("CnRuAAAAYdB8X7Sbg9X_nw9gYjmSCTZnmJKkmjhfPyRWfDk0cQ28i0ZLoj1SdmSTRjHeNyV87twT7qTe3yIPkQs6k5GylEMYplhIYu9v1PdLUwkFyoHgoQPahe5_OnWAR8iI78mpgJ0KPz0-rjog-vk4czIJ9hIQENETw1xQ4-rIXxb_jZPUoBoUPNIqLa-uq_l5UVCoUE3pA9QyH9M","CnRpAAAA_8wS9UUdyTcyC5LicnvdT7Rfor9UzaCDUWr7M5W-hcoC0NQQOn4MVhFSEUAJo3nO5-JMfH5XF6P75hCC1Jep_UixgDjfa1hc7pvHz9G-JKIO903E4mqq5enk5uoZNew1wLhbHgC9m7f5aOWGcb8PtxIQwZEum2tuQgZBkJXwoSyfkRoUYyiHiLeBJxyG_b_iNJGeKXxA-0k");

	//get the place details for each reference and store it in an array
	foreach ($refID as $key => $faves) {
	$placeDetails[] = getDetailsByRef($faves);		
	}

	echo $placeDetails[0]['result']["name"] . "<br>";
	echo $placeDetails[0]['result']["adr_address"] . "<br>";
	echo $placeDetails[0]['result']["formatted_phone_number"] . "<br>";
	echo $placeDetails[0]['result']["opening_hours"]["open_now"] . "<br>";
	echo $placeDetails[0]['result']["opening_hours"]["periods"][0]["open"]["day"] . "<br>";
	echo $days[$placeDetails[0]['result']["opening_hours"]["periods"][0]["open"]["day"]] ."<br>";
	echo date("h:i a",strtotime($placeDetails[0]['result']["opening_hours"]["periods"][0]["open"]["time"]));
*/

if(isset($_POST['referenceIDs']) && !empty($_POST['referenceIDs'])){

	$refArray = $_POST['referenceIDs'];

	addToFavorites($refArray);

	$Msgs[] = "Your favorites have been added";
}

if(isset($_GET['referenceIDs']) && !empty($_GET['referenceIDs']) && isset($_GET['delete'])){

	$refArray = $_GET['referenceIDs'];

	deleteFavorites($refArray);

	$Msgs[] = "Your favorites have been deleted";
}



?>
<body>
<h1><?php echo $_SESSION['full_name'] . "'s" . " Favorites";?></h1>
<div style="background-color:black;color:white;">
<?php
foreach ($Msgs as $key => $value) {
	echo $value . "<br>";
}
?>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get"> 
<input type="submit" name="delete" value="delete"/>
<br>
<?php

showMyFavorites();

?>
<br>
<input type="submit" name="delete" value="delete"/>
</form>
</body>