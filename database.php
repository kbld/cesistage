<?php
require('configuration.php');

try {
	$dbh = new PDO(
		DATABASE_URL,
		DATABASE_USER,
		DATABASE_PASSWORD,
		array(
			PDO::ATTR_PERSISTENT => true
		)
	);
	catch (Exception $e) {
		die("Unable to connect: " . $e->getMessage());
	}
}

public function Register($user) {
	$pass = password_hash(
		$user['password'],
		PASSWORD_ARGON2I,
		[
			'memory_cost' => 2048,
			'time_cost' => 4,
			'threads' => 3
		]
	);

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$stmt = $dbh->prepare(
			"INSERT INTO users 
			(name, lastName, email, username, password, status, enabled, company, group)
			VALUES
			(:name, :lastName, :email, :username, :password, :status, :enabled, :company, :group)"
		);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':lastName', $lastname);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':status', $status);
		$stmt->bindParam(':enabled', 0);
		$stmt->bindParam(':company', $company);
		$stmt->bindParam(':group', $group);
		$stmt->execute();

		$dbh->commit();
	} catch (Exception $e) {
		$dbh->rollBack();
		echo "Failed: " . $e->getMessage();
	}
}

public function GetNumberOfOffers() {
	# code...
}

public function GetNumberOfOffersOf($type) {
	# code...
}
