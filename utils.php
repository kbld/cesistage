<?php
session_start();

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

	$user['is_authenticated'] = $_SESSION['login'] ?? false;

	$local_params['user'] = $user;
	$params = array_merge($params, $local_params);

	echo $twig->render($filename, $params);
}
