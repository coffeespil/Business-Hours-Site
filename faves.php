<?php
include 'includes/config.inc.php';


$references = array("jshshs7","dnhdhdhdhdh","dndndjd8djeem","dndndndndndnowd","dndndn2ikh2dkndwkn");
global $uid;
$uid = 1;

if(isset($_POST['faves']) && !empty($_POST['references'])){

	$refArray = $_POST['references'];

	addToFavorites($refArray);

}



//addToFavorites($references);


function addToFavorites($refs){

	global $uid;

	for($i=0 ; $i<count($refs) ; $i++){

		$sqlString = mysql_query("INSERT INTO " . FAVES . " (user_id, reference_id) VALUES('$uid','" . $refs[$i]  . "')") or die("unable to insert data");
								}

}//end fn
?>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
	for($j=0 ; $j<count($references) ; $j++){
	echo "<input type='checkbox' name='references[]' value='" .$references[$j] ."' />&nbsp;&nbsp;Reference " . $j . "<br>";
	}
?>
<input type="submit" name="faves" value="add to favorites"/>
</form>
</body>