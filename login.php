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

	$user['username'] = $username;
	$user['email'] = $username;
	$user['password'] = $password;

	$db_user = Login($user);

	if (!$db_user) {
		$errors['user'] = 'Unknown user or email';
		Render('login.twig', ['errors' => $errors]);
	}
	else {
		if (password_verify($user['password'], $db_user['password'])) {
			$_SESSION['id'] = $db_user['id'];
			$_SESSION['username'] = $db_user['username'];
			$_SESSION['salt'] = random_bytes(16);

			$_SESSION['hash'] = hash_pbkdf2("sha3-512", SECRET, $_SESSION['salt'], HASH_ITERATIONS, 0);
			$_SESSION['token'] = base64_encode($db_user['id']) . '.' . $_SESSION['hash'] . '.' . base64_encode($db_user['username']);

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
