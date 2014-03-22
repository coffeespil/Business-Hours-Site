<?php
//include_once 'includes/swift/lib/swift_required.php';
include 'includes/config.inc.php';
require 'php-sdk/src/temboo.php';


ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

$email = "michael.a.morgan@gmail.com";
//define("BIZEMAIL","michael.a.morgan@gmail.com");
$pass = "bizhours";

$body = "Hello from Temboo";
$subject = "Account activation";

// Instantiate the Choreo, using a previously instantiated Temboo_Session object, eg:
$session = new Temboo_Session(TEMBOO_NAME, TEMBOO_PROJ, TEMBOO_KEY);
$sendEmail = new Google_Gmail_SendEmail($session);

// Get an input object for the Choreo
$sendEmailInputs = $sendEmail->newInputs();

// Set inputs
$sendEmailInputs->setMessageBody($body)->setSubject($subject)->setUsername(BIZEMAIL)->setPassword($pass)->setToAddress($email);

// Execute Choreo and get results
$sendEmailResults = $sendEmail->execute($sendEmailInputs)->getResults();




/*
//generate the message
			$message = "Thanks for registering with Business-Hours.net!"; 


			//next, we use swift's email function
			$email_to = $email; $email_from=BIZEMAIL; $password = $pass; $subj = "Business-Hours Account Activation";

			$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl');
			$transport->setUsername($email_to);
			$transport->setPassword($password);


			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance($subj);
			$message->setFrom(array($email_from => 'Mike Morgan'));
			$message->setTo(array($email_to));
			$message->setBody($message);
			$result = $mailer->send($message);
			/ Create the Transport
$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl');
  $transport->setUsername($email);
  $transport->setPassword($pass);


// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance('Wonderful Subject');
  $message->setFrom(array($email => 'Mike Morgan'));
  $message->setTo(array('michael.a.morgan@gmail.com' => 'Mike Morgan'));
  $message->setBody('Here is the message itself');

// Send the message
$result = $mailer->send($message);
*/





?>