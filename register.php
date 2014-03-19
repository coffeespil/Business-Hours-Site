<?php
include 'includes/config.inc.php';

//initialize the form fields
$full_name = NULL;
$email = NULL;
$password = NULL;
$passwordconfirm = NULL;
$city = NULL;
$state = NULL;
$postal_code = NULL;

//instantiate an error array to populate with error messages
$errors = array();

//check to see if data was set from the form
if(isset($_POST['submit'])){

//clean up the fields so that they will be DB friendly
	$full_name = filter($_POST['full_name']);
	$email = filter($_POST['email']);
	$pwd = filter($_POST['pwd']);
	$confirm_pwd = filter($_POST['confirm_pwd']);
	$city = filter($_POST['city']);
	$state = $_POST['state'];
	$postal_code = filter($_POST['postal_code']);
	$activationcode = rand(1111,99999);
	$date = date('Y-m-d');

//call registration function. return errors and success message based on function rules in config file
$errMsgs = registerMe($full_name,$email,$pwd,$confirm_pwd,$city,$state,$postal_code,$activationcode,$date);

}


?>
<title>Register</title>
<head></head>
<body>
<form name="regform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
<div style="background-color:yellow;">
<h1>Register</h1>
<div style="background-color:black;color:white;">
<?php
	if($errMsgs){
		foreach ($errMsgs as $key => $msg) {
			echo $msg . "<br>";
		} //end foreach
	}//end if

?>	
</div>
fullname<br>
<input type="text" name="full_name" size="100" maxlength="200" value="<?php echo $full_name; ?>">
<br>
email<br>
<input type="text" name="email" size="100" maxlength="200" value="<?php echo $email; ?>">
<br>
password<br>
<input type="password" name="pwd" size="20" maxlength="200">
<br>
confirm password<br>
<input type="password" name="confirm_pwd" size="20" maxlength="200">
<br>
city<br>
<input type="text" name="city" size="40" maxlength="40" value="<?php echo $city; ?>">
<br>
state<br>
<select name="state">
<?php

		//iterate through the list of states in the array and render them on the register page
		foreach ($states as $idx => $statecode) {

			if($statecode == $state){
			echo "<option value='" . $statecode . "' selected>" . $statecode . "</option>";
				}
			else{
			echo "<option value='" . $statecode . "'>" . $statecode . "</option>";
			} //end if
		}

?>	
</select>
<br>
postal code<br>
<input type="text" name="postal_code" size="40" maxlength="40" value="<?php echo $postal_code; ?>">
<br>
<input type="submit" name="submit" value="register"><br><br>
</div>
</form>
</body>