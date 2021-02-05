<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'configuration.php';

function CleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function Render($filename, $params=array()) {
	require_once 'vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader('views');
	$twig = new \Twig\Environment($loader, []);

	$local_params['session'] = $_SESSION;
	$params = array_merge($params, $local_params);

	echo $twig->render($filename, $params);
}

function Sendmail($to=['john@doe.com' => 'John Doe'], $textmsg, $htmlmsg) {
	// Create the Transport
	$transport = (new Swift_SmtpTransport(SMTP_SERVER, SMTP_PORT))
		->setUsername(SMTP_USERNAME)
		->setPassword(SMTP_PASSWORD)
	;

	// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

	// Create a message
	$message = (new Swift_Message('Wonderful Subject'))
		->setFrom(SMTP_SENDER)
		->setTo($to)
		->setBody($textmsg)
  		->addPart($htmlmsg, 'text/html')
		;

	// Send the message
	$result = $mailer->send($message);
}
