<?php
require_once 'utils.php';
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["delete"])) {
		Render("delete_account.twig", []);
	}
	else {
		DeleteAccount($_SESSION["username"]);

		$_SESSION = array();
		session_destroy();

		header('Location: /');
		exit;
	}
}
else {
	Render("delete_account.twig", []);
}
