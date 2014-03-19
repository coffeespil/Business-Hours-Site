<?php
include 'includes/config.inc.php';

$errMsgs = array();

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
	$loginQry = mysql_query("SELECT pwd, id FROM " . USERS . " WHERE email = AES_ENCRYPT('$email', '$salt')") or die(mysql_error());

	list($password,$id) = mysql_fetch_row($loginQry);


	//logic here for logging in
	if(mysql_num_rows($loginQry) > 0){
		echo "Num of rows returned is " . mysql_num_rows($loginQry);
	}

}


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


