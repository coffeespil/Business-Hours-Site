<?php
include 'includes/functions.inc.php';

?>
<body>
<div>
<?php

$coordinates = array();

$address = "275 Greenwich St., New York, NY 10007";

//call getCoordinates to return an array containing latitude and longitude
$coordinates = getCoordinates($address);

echo "Latitude is " . $coordinates['lat'] . "<br>";
echo "Longitude is " . $coordinates['lng'] . "<br>";
echo "<br>";

$placesJson = array();

$radius = 800;
$btype = "bank";
$lat = $coordinates['lat'];
$lng = $coordinates['lng']; 

$placesJson = getplaceReferences($radius,$btype,$lat,$lng);


$details = getPlaceDetails($placesJson);

print_r($details);

?>
</div>
</body>

