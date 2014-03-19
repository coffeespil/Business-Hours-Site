<?php
include 'includes/config.inc.php';

//pass a logout message to the logout function
$message = urldecode("You're now successfully logged out.");

logout($message);


?>