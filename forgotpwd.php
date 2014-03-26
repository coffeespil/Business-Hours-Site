<?php
include 'includes/config.inc.php';

$errMsgs = array();


//check if forgot pwd form submitted
if(isset($_POST['submit']) && !isset($_GET['mode'])){

	$title = "Forgot Password";

	$email = filter($_POST['email']);

	//check for valid email address using hw function
	if(empty($email) || !check_email($email)){
		$errMsgs[] = "Please enter a valid email address.";
	}
	else{
		//check if the user exists
		$userExists = mysql_query("SELECT email,md5_id FROM " . USERS . " WHERE email = AES_ENCRYPT('$email', '$salt')");

		$userCount = mysql_fetch_array($userExists);

		//if the array is empty then the user doesnt exist
		if(empty($userCount)){
			$errMsgs[] = $email . " does not exist in our records. Please double-check or try another email address.";
		}	
		else{

			$userInfo = mysql_fetch_array($userExists);


			//hash it again before passing it to the URL string in the email.
			$md5id = $userInfo['md5_id'];

			//construct the email message for resetting password and then send it

$errMsgs[] = "Ok. We've sent you an email to change your password. Please check it.";	
			//generate the message
			$body = "Please follow this link to change your password:\n"
			. SITE_BASE . "/forgotpwd.php?mode=pchange&token=" . $md5id;

			$subject = "Business-Hours Password Reset";

			$emailInfo = getCredentials("gmail");
			$mailFrom = $emailInfo['email'];
			$mailPwd = $emailInfo['pwd'];

			// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
			$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY);
			$sendEmail = new Google_Gmail_SendEmail($session);

			// Get an input object for the Choreo
			$sendEmailInputs = $sendEmail->newInputs();

			// Set inputs
			$sendEmailInputs->setMessageBody($body)->setSubject($subject)->setUsername($mailFrom)->setPassword($mailPwd)->setToAddress($email);

			// Execute Choreo and get results
			$sendEmailResults = $sendEmail->execute($sendEmailInputs)->getResults();

		} //end mysqlnumrows
	} //empty email

} //is set submit

//check if change pwd form submitted
if(isset($_POST['submitpwd']) && isset($_GET['mode']) && $_GET['mode'] == "psubmit"){

	$pwd = filter($_POST['pwd']);
	$confirm_pwd = filter($_POST['confirm_pwd']);
	$token = $_POST['token'];

	//call fn to check pwd rules

	if(!isvalidPwd($pwd)){
		$errMsgs[] = "Please enter a valid password.<ul>It must contain at least: <li>one number<li>one letter<li>be at least 6 characters long</ul>";
	} //end isvalidpwd


	//check for that the two password fields equal eachother
	if($pwd != $confirm_pwd){
		$errMsgs[] = "Both passwords must match. Please re-enter them.";
	} //end pwd

	if(empty($errMsgs)){
		$pwd = hashpass($pwd);
		$updPwd = mysql_query("UPDATE ". USERS . " SET pwd = '" . $pwd . "' where md5_id='$token'"); 
	
		$errMsgs[] = "Your password has been updated successfully. <a href='login.php'>Login</a>.";
	}
} //end get mode

//check if URL was clicked from an email, then pass the token into a hidden variable on the change pwd form below
if(isset($_GET['mode']) && $_GET['mode'] == "pchange"){
//	$title = "Change Password";
	$token = $_GET['token'];

}//end mode



?>
<head><title><?php echo $title; ?></title></head>
<body>
<div id="messages" style="background-color:black;color:white;">
<?php
		foreach ($errMsgs as $errName => $message) {
			echo $message . "<br>";
		}
?>
</div>
<?php 

if(!isset($_GET['mode'])) { 

?>
<div>Enter in your email and we will send you an email to reset your password.</div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<br>email<br>
<input type="text" name="email" size="100" maxlength="200">
<br>
<input type="submit" name="submit" value="email me"/>
</form>
<?php  
} 
else {

?>
<form action="<?php echo $_SERVER['PHP_SELF'] . "?mode=psubmit"; ?>" method="post">
new password<br>
<input type="password" name="pwd" size="20" maxlength="200">
<br>
confirm password<br>
<input type="password" name="confirm_pwd" size="20" maxlength="200">
<br>
<input type="submit" name="submitpwd" value="change password"/>
<br>
<input type="hidden" name="token" value="<?php echo $token; ?>"/>
</form>
<?php  
} 
?>
</body>