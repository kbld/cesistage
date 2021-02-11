<?php
require_once('../utils.php');
require_once('../database.php');

if ($_SESSION['login'] and ($_SESSION['group'] == 4 or $_SESSION['group'] == 5)) {
	if (isset($_GET["name"]) and ($_GET["name"] != "")) {
		$disable['name'] = $_GET['name'];
		$disable['type'] = 'account';
		if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['disable'])) {
			$user['UserUsername'] = $disable['name'];
			DisableAccount($user);
			header('Location: /admin/users');
		} else {
			Render('disable.twig', ['disable' => $disable]);
		}
	} else {
		header('Location: /admin');
	}
} elseif ($_SESSION['login']) {
	header('Location: /');
	exit;
} else {
	header('Location: /login');
	exit;
}
