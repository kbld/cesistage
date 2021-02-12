<?php
require_once('utils.php');
require_once('database.php');

if ($_SESSION['login'] and ($_SESSION['group'] >= 3)) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = '';
		$logo = '';
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
		if (empty($_POST["description"])) {
			$errors['description'] = "La description est obligatoire";
		}
		else {
			$description = CleanInput($_POST["description"]);
		}

		if (isset($errors)) {
			Render('registercorp.twig', ['errors' => $errors]);
		} else {
			$company['CompanyName'] = $name;
			$company['CompanyDescription'] = $description;

			$result = RegisterCorp($company);

			if (!$result) {
				$errors['register'] = "Register failed ! Internal server error. Error n°500";
				Render('registercorp.twig', ['errors' => $errors]);
			}
			else {
				header("Location: /");
				exit;
			}
		}
	} else {
		Render('registercorp.twig', []);
	}
} elseif ($_SESSION['login']) {
	header('Location: /');
	exit;
} else {
	header('Location: /login');
	exit;
}

