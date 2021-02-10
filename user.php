<?php
require_once 'utils.php';
require_once 'database.php';

$user = array();
$errors = array();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['personal'])) {
		$name = '';
		$lastname = '';
		$username = '';
		$email = '';
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
		if (empty($_POST["prenom"])) {
			$errors['prenom'] = "Le prénom est obligatoire";
		}
		else {
			$prenom = CleanInput($_POST["prenom"]);
			if (!preg_match("/^[a-zA-Z-']*$/",$prenom)) {
				$errors['prenom'] = "Seul les lettres sont autorisés";
			}
		}
		if (empty($_POST["email"])) {
			$errors['email'] = "L'adresse mail est obligatoire";
		}
		else {
			$email = CleanInput($_POST["email"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Email invalide";
			}
		}
		$description = CleanInput($_POST["description"]);

		$user['UserName'] = $prenom;
		$user['UserLastname'] = $name;
		$user['UserEmail'] = $email;
		$user['UserDescription'] = $description;
		$user['UserUsername'] = $_SESSION['username'];

		if (isset($prenom) && isset($username) && isset($lastname) && isset($email) && isset($description)) {
			$result = UpdateAccount($user);
			if (!$result) {
				$errors['user'] = "Update failed ! Internal server error. Error n°500";
			}
		}
	}
	elseif (isset($_POST['password_up'])) {
		$old_password = '';
		$password = '';
		$password2 = '';

		if (empty($_POST["old_password"])) {
			$errors['old_password'] = "Veuillez renseigner un mot de passe";
		}
		else {
			$old_password = CleanInput($_POST["old_password"]);
		}
		if (empty($_POST["password"])) {
			$errors['password'] = "Veuillez renseigner un mot de passe";
		}
		else {
			$password = CleanInput($_POST["password"]);
		}
		if (empty($_POST["password2"])) {
			$errors['password2'] = "Veuillez renseigner un mot de passe";
		}
		else {
			$password2 = CleanInput($_POST["password2"]);
		}
		if ($password != $password2) {
			$errors['password2'] = $errors['password'] = "Les mots de passe ne sont pas identiques";
		}

		$user['UserUsername'] = $_SESSION['username'];
		$user = Login($user);

		if (password_verify($old_password, $user['UserPassword'])) {
			$user['UserPassword'] = password_hash(
				$password,
				PASSWORD_ARGON2ID,
				[
					'memory_cost' => 2048,
					'time_cost' => 4,
					'threads' => 3,
				]
			);
			$result = UpdatePassword($user);
			if (!$result) {
				$errors['user'] = "Update failed ! Internal server error. Error n°500";
			}
		}
		else {
			$errors['old_password'] = 'Mauvais mot de passe';
		}
	}
	elseif (isset($_POST['change_company'])) {
		$company = '';

		if (empty($_POST["company"])) {
			$errors['company'] = "Le nom de l'entreprise est obligatoire";
		}
		else {
			$company = CleanInput($_POST["company"]);
			if (!preg_match("/^[a-zA-Z-']*$/",$company)) {
				$errors['company'] = "Seul les lettres sont autorisés";
			}
		}

		if (isset($company)) {
			$user['UserUsername'] = $_SESSION['username'];
			$user['company'] = $company;
			$result = ChangeUserCompany($user);
			if (!$result) {
				$errors['company'] = "Update failed ! Internal server error. Error n°500";
			}
		}
	}
}

if ((isset($_GET['user']) && $_GET['user'] != '')) {
	$username = CleanInput($_GET['user']);
	$user = GetUserInfo($username) ?? false;
	$company_list = GetCompanyList() ?? false;

	Render('user.twig', ['user' => $user, 'companys' => $company_list]);
} else {
	if (!isset($_SESSION['username'])) {
		return header("Location: /login");;
		die;
	}
	$username = $_SESSION['username'] ?? false;
	$user = GetUserInfo($username) ?? false;
	$company_list = GetCompanyList() ?? 0;

	Render('user.twig', ['user' => $user, 'companys' => $company_list, 'errors' => $errors]);
}
