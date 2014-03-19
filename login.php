<?php
include 'includes/config.inc.php';

$errMsgs = array();

if(isset($_GET['msg'])){

$errMsgs[] = $_GET['msg'];

}



if(isset($_POST['submit'])){

	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$pwdHashed = hashpass($pwd);

//	echo $pwdHashed;

	//check for valid email address using hw function
	if(empty($email) || !check_email($email)){
		$errMsgs[] = "Please enter a valid email address.";
	}

	//check whether or not the password is in the proper format
	if(!isvalidPwd($pwd)){
		$errMsgs[] = "Please enter a valid password.<ul>It must contain at least: <li>one number<li>one letter<li>be at least 6 characters long</ul>";
	}	

	//retrieve the password based on the email address
	$loginQry = mysql_query("SELECT pwd, id, full_name FROM " . USERS . " WHERE email = AES_ENCRYPT('$email', '$salt')") or die(mysql_error());

	list($password,$id,$fname) = mysql_fetch_row($loginQry);


	//logic here for logging in
	if(mysql_num_rows($loginQry) > 0){

		if(empty($errMsgs)){

			//if pwds match then get some of the basic info to store into a session variable
			if($pwdHashed == $password){

				//start the session
				session_start();

				//clear out old session data and create a new one just in case
				session_regenerate_id(true);

				//store session variables here
				$_SESSION['uid'] = $id;
				$_SESSION['full_name'] = $fname;

				//redirect to a new location
				header("Location: ".SITE_BASE . "/profile.php");

			}//end if

			else{
				$errMsgs[] = "Passwords don't match in our records. Try a different password. Or, " . REGISTER;
			}

		}//end if

	}//end if
	else{
			$errMsgs[] = "User " . $email . " could not be found.  Please try another set of credentials, or " . REGISTER;
	}



}//end if


?>
<title>Login</title>
<body>
<div style="background-color:black;color:white;">
<?php

	foreach ($errMsgs as $errKey => $msg) {
		echo $msg . "<br>";
	}



?>
</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
email<br>
<input type="text" name="email" size="40" maxlength="200" value="<?php echo $email; ?>">
<br>
password<br>
<input type="password" name="pwd" size="40" maxlength="200"><br>
<input type="submit" name="submit" value="login">
</form>	
</body>


