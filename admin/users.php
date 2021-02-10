<?php
require_once('../utils.php');
require_once('../database.php');

if ($_SESSION['login'] and ($_SESSION['group'] == 4 or $_SESSION['group'] == 5)) {
	if (isset($_GET["edit"]) and ($_GET["edit"] != "")) {
		$username = CleanInput($_GET['edit']);
		$user = GetUserInfo($username) ?? false;
		$company_list = GetCompanyList() ?? false;
		$errors = array();

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST['personal'])) {
				$name = '';
				$prenom = '';
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
				if (empty($_POST["username"])) {
					$errors['username'] = "Le prénom est obligatoire";
				}
				else {
					$username = CleanInput($_POST["username"]);
					if (!preg_match("/^[a-zA-Z-_0-9]*$/",$username)) {
						$errors['username'] = "Seul les lettres, les chifres et les charactères _- sont autorisés";
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

				$user['UserName'] = $name;
				$user['UserLastName'] = $prenom;
				$user['UserEmail'] = $email;
				$user['UserDescription'] = $description;
				$user['UserUsername'] = $username;
				echo $user['UserId'];

				if (isset($user['UserName']) && isset($user['UserLastName']) && isset($user['UserEmail']) && isset($user['UserDescription']) && isset($user['UserUsername'])) {
					$result = UpdateAccountById($user);
					if (!$result) {
						$errors['user'] = "Update failed ! Internal server error. Error n°500";
					}
					echo $result;
				}
				Render('edit_user.twig', ['errors' => $errors, 'user' => $user, 'companys' => $company_list]);
			} elseif (isset($_POST['change_company'])) {
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
					$user['UserUsername'] = $username;
					$user['company'] = $company;
					$result = ChangeUserCompany($user);
					if (!$result) {
						$errors['company'] = "Update failed ! Internal server error. Error n°500";
					}
					Render('edit_user.twig', ['errors' => $errors, 'user' => $user, 'companys' => $company_list]);
				}
			}
		}
		else {
			Render('edit_user.twig', ['user' => $user, 'companys' => $company_list]);
		}
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
