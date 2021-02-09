<?php
require_once('../utils.php');
require_once('../database.php');

if ($_SESSION['login'] and ($_SESSION['group'] == 4 or $_SESSION['group'] == 5)) {
	if (isset($_GET["edit"]) and ($_GET["edit"] != "")) {
		$company = CleanInput($_GET['edit']);
		$company = GetCompanyInfo($company) ?? false;

		Render('edit_company.twig', ['company' => $company]);
	} else {
		$company = GetCompaniesList();

		Render('company_list.twig', ['company' => $company]);
	}
} elseif ($_SESSION['login']) {
	header('Location: /');
	exit;
} else {
	header('Location: /login');
	exit;
}
