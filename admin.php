<?php
require_once('utils.php');

if ($_SESSION['login'] and ($_SESSION['group'] == 4 or $_SESSION['group'] == 5)) {
	Render('admin.twig', []);
} elseif ($_SESSION['login']) {
	header('Location: /');
	exit;
} else {
	header('Location: /login');
	exit;
}
