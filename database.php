<?php
require_once 'configuration.php';

function DBConnect() {
	try {
		$dbh = new PDO(
			DATABASE_URL,
			DATABASE_USER,
			DATABASE_PASSWORD,
			array(
				PDO::ATTR_PERSISTENT => true,
			)
		);
		return $dbh;
	} catch (Exception $e) {
		die("Unable to connect: " . $e->getMessage());
	}
}

function Register($user) {
	$password = password_hash(
		$user['password'],
		PASSWORD_ARGON2ID,
		[
			'memory_cost' => 2048,
			'time_cost' => 4,
			'threads' => 3,
		]
	);

	$dbh = DBConnect();
	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$stmt = $dbh->prepare(
			"INSERT INTO users
			(name, lastName, email, username, password)
			VALUES
			(:name, :lastName, :email, :username, :password)"
		);
		$stmt->bindParam(':name', $user['name']);
		$stmt->bindParam(':lastName', $user['lastname']);
		$stmt->bindParam(':email', $user['email']);
		$stmt->bindParam(':username', $user['username']);
		$stmt->bindParam(':password', $password);
		$stmt->execute();

		$dbh->commit();
		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return "Failed: " . $e->getMessage();
	}
}

function Login($user) {
	$dbh = DBConnect();
	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$user_by_username = $dbh->prepare(
			"SELECT * FROM users WHERE username=(:username)"
		);
		$user_by_username->bindParam(':username', $user['username']);

		$user_by_email = $dbh->prepare(
			"SELECT * FROM users WHERE email=(:email)"
		);
		$user_by_email->bindParam(':email', $user['email']);

		$user_by_username->execute();
		$user_by_email->execute();

		$by_username = $user_by_username->fetch(PDO::FETCH_ASSOC);
		$by_email = $user_by_email->fetch(PDO::FETCH_ASSOC);

		$dbh->commit();

		if ($by_username) {
			return $by_username;
		} elseif ($by_email) {
			return $by_email;
		} else {
			return false;
		}
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function GetNumberOfOffers() {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		$req = $dbh->prepare("SELECT COUNT(*) FROM offers WHERE OfferStatus=1");
		$req->execute();

		$request = $req->fetch(PDO::FETCH_ASSOC);
		$dbh->commit();
		return $request['COUNT(*)'];
	} catch (Exception $e) {
		$dbh->rollBack();
		return "Failed: " . $e->getMessage();
	}
}

function GetOffers($start = 0) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM offers JOIN company ON offers.company=company.id WHERE offers.id>=(:start) AND OfferStatus=1 LIMIT 100");
		$req->bindParam(':start', $start);

		$req->execute();

		$request = $req->fetchAll();
		$dbh->commit();

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return "Failed: " . $e->getMessage();
	}
}

function SearchOffers($search, $start = 0) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM offers JOIN company ON offers.company=company.id WHERE OfferTitle LIKE (:search) AND offers.id>=(:start) AND OfferStatus=1 ORDER BY OfferStarting LIMIT 100");
		$req->bindParam(':start', $start);
		$req->bindParam(':search', $search);

		$count = $dbh->prepare("SELECT COUNT(*) FROM offers WHERE OfferTitle LIKE (:search) AND id>=(:start) AND status=1");
		$count->bindParam(':start', $start);
		$count->bindParam(':search', $search);

		$req->execute();
		$count->execute();

		$request = $req->fetchAll();
		$affected = $req->fetch(PDO::FETCH_ASSOC);

		$affected_count = $affected['COUNT(*)'] ?? 0;

		$dbh->commit();

		return ['request' => $request, 'affected' => $affected_count];
	} catch (Exception $e) {
		$dbh->rollBack();
		return "Failed: " . $e->getMessage();
	}
}

function GetUserInfo($user) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM users LEFT JOIN company ON (users.company IS NOT NULL AND users.company=company.id) WHERE users.username=(:user)");
		$req->bindParam(':user', $user);

		$req->execute();

		$request = $req->fetch(PDO::FETCH_ASSOC);

		$dbh->commit();

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function GetCompanyList() {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT CompanyName FROM company");

		$req->execute();

		$request = $req->fetchAll();

		$dbh->commit();

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function DeleteAccount($username) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("DELETE FROM `users` WHERE `username`=(:username)");
		$req->bindParam(':username', $username);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function UpdateAccount($user) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE `users` SET `name`=(:name), `lastName`=(:lastname), `email`=(:email), `Description`=(:description) WHERE `username`=(:username)");
		$req->bindParam(':name', $user['name']);
		$req->bindParam(':lastname', $user['lastname']);
		$req->bindParam(':email', $user['email']);
		$req->bindParam(':description', $user['description']);
		$req->bindParam(':username', $user['username']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function UpdatePassword($user) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE `users` SET `password`=(:password) WHERE `username`=(:username)");
		$req->bindParam(':password', $user['password']);
		$req->bindParam(':username', $user['username']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function ChangeUserCompany($user) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE `users` SET `company`=(SELECT id FROM company WHERE `CompanyName`=(:company)) WHERE `username` = (:username)");
		$req->bindParam(':company', $user['company']);
		$req->bindParam(':username', $user['username']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function GetPermissions($id) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM `gps` WHERE `id`=(:id)");
		$req->bindParam(':id', $id);

		$req->execute();
		$request = $req->fetch(PDO::FETCH_ASSOC);

		$dbh->commit();

		$request['GroupRights'] = unserialize($request['GroupRights']);

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}
