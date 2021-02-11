<?php
require_once('../utils.php');
require_once('../database.php');

if ($_SESSION['login'] and $_SESSION['group'] == 5) {
	if (isset($_GET["name"]) and ($_GET["name"] != "")) {
		$delete['name'] = $_GET['name'];
		$delete['type'] = 'account';
		if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['delete'])) {
			DeleteAccount($delete['name']);
			header('Location: /admin/users');
		} else {
			Render('delete.twig', ['delete' => $delete]);
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
