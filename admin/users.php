<?php
require_once('../utils.php');
require_once('../database.php');

if (isset($_GET["edit"]) and ($_GET["edit"] != "")) {
	$username = CleanInput($_GET['edit']);
	$user = GetUserInfo($username) ?? false;
	$company_list = GetCompanyList() ?? false;

	Render('edit_user.twig', ['user' => $user, 'companys' => $company_list]);
} else {
	$users = GetUsersList();
	Render('user_list.twig', ['users' => $users]);
}
