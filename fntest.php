<?php
include 'includes/config.inc.php';

session_start();

//store session variables here
$_SESSION['uid'] = 1;
$_SESSION['full_name'] = "My Name";
$_SESSION['skey'] = generateSessionkey();
//$_SESSION['stime'] = date("Y-m-d H:i:s");
$_SESSION['stime'] = "2014-03-26 05:38:06";

//secureSession();
	if(isset($_SESSION['HTTP_USER_AGENT'])){
	
			if(isset($_SESSION['uid']))
			{

						$sessionDetail = mysql_query("SELECT session_key, session_start FROM " . USERS . " WHERE id ='".$_SESSION['uid']."'") or die(mysql_error());

						list($sessKey, $start_time) = mysql_fetch_row($sessionDetail);

						if(!isset($_SESSION['stime']) && ($_SESSION['stime'] != $start_time)){

								echo "session time is different";						
						} //end isset stime

						echo $sessKey . ":" . $_SESSION['skey'];

						if($_SESSION['skey'] != $sessKey){
							echo "session keys don't match";
						}
						else{
							echo "sessions do match";
						}

			}
			else{

				echo "user id is not set";
			} //end uid
	}	
	else{
			echo "user agent is not set";
	}//end user agt

unset($_SESSION['stime']);

?>