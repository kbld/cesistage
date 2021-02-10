<?php
require_once('../utils.php');
require_once('../database.php');

if ($_SESSION['login'] and ($_SESSION['group'] == 4 or $_SESSION['group'] == 5)) {
	if (isset($_GET["edit"]) and ($_GET["edit"] != "")) {
		$company = CleanInput($_GET['edit']);
		$company = GetCompanyInfo($company) ?? false;
		$errors = array();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$name = '';
			$description = '';

			if (empty($_POST["nom"])) {
				$errors['nom'] = "Le nom est obligatoire";
			}
			else {
				$name = CleanInput($_POST["nom"]);
				if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
					$errors['nom'] = "Seule les lettres et les espaces sont autorisé";
				}
			}
			$description = CleanInput($_POST["description"]);

			$comp['CompanyId'] = $company['id'];
			$comp['CompanyName'] = $name;
			$comp['CompanyDescription'] = $description;

			if (isset($name) && isset($description)) {
				$result = UpdateCompany($comp);
				if (!$result) {
					$errors['user'] = "Update failed ! Internal server error. Error n°500";
				}
			}
			Render('edit_company.twig', ['errors' => $errors, 'company' => $company]);
		}
		else {
			Render('edit_company.twig', ['company' => $company]);
		}
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
