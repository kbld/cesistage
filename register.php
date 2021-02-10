<?php
require_once('utils.php');
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = '';
	$lastname = '';
	$username = '';
	$email = '';
	$password = '';

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

	if (isset($errors)) {
		Render('register.twig', ['errors' => $errors]);
	} else {
		$user['UserName'] = $name;
		$user['UserLastName'] = $lastname;
		$user['UserUsername'] = $username;
		$user['UserEmail'] = $email;
		$user['UserPassword'] = $password;
		$result = Register($user);
		if (!$result) {
			$errors['register'] = "Register failed ! Internal server error. Error n°500";
			Render('register.twig', ['errors' => $errors]);
		}
		else {
			header("Location: /");
			exit;
		}
	}
}
else {
	Render('register.twig', []);
}
