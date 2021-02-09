<?php
require_once('../utils.php');
require_once('../database.php');

if ($_SESSION['login'] and ($_SESSION['group'] == 4 or $_SESSION['group'] == 5)) {
	if (isset($_GET["edit"]) and ($_GET["edit"] != "")) {
		$username = CleanInput($_GET['edit']);
		$user = GetUserInfo($username) ?? false;
		$company_list = GetCompanyList() ?? false;

		Render('edit_user.twig', ['user' => $user, 'companys' => $company_list]);
	} else {
		$users = GetUsersList();
		Render('user_list.twig', ['users' => $users]);
	}
} elseif ($_SESSION['login']) {
	header('Location: /');
	exit;
} else {
	header('Location: /login');
	exit;
}
