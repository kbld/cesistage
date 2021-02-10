<?php
require_once 'utils.php';
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = '';
	$password = '';

	if (empty($_POST["username"])) {
		$errors['username'] = "Le prénom est obligatoire";
	}
	else {
		$username = CleanInput($_POST["username"]);
	}
	if (empty($_POST["password"])) {
		$errors['password'] = "Veuillez renseigner un mot de passe";
	}
	else {
		$password = CleanInput($_POST["password"]);
	}

	$user['UserUsername'] = $username;
	$user['UserEmail'] = $username;
	$user['UserPassword'] = $password;

	$db_user = Login($user);

	if (!$db_user) {
		$errors['user'] = 'Unknown user or email';
		Render('login.twig', ['errors' => $errors]);
	}
	else {
		if (password_verify($user['UserPassword'], $db_user['UserPassword'])) {
			$_SESSION['id'] = $db_user['UserId'];
			$_SESSION['username'] = $db_user['UserUsername'];
			$_SESSION['salt'] = random_bytes(16);
			$_SESSION['group'] = $db_user['groop'];

			$_SESSION['hash'] = hash_pbkdf2("sha3-512", SECRET, $_SESSION['salt'], HASH_ITERATIONS, 0);
			$_SESSION['token'] = base64_encode($db_user['id']) . '.' . $_SESSION['hash'] . '.' . base64_encode($db_user['UserUsername']);

			$_SESSION['login'] = true;
			header("Location: /");
			exit;
		}
		else {
			$errors['password'] = 'Bad password';
			Render('login.twig', ['errors' => $errors]);
		}
	}
}
else {
	Render('login.twig', []);
}
