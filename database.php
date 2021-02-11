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
		$user['UserPassword'],
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
			"INSERT INTO user
			(UserName, UserLastName, UserEmail, UserUsername, UserPassword, UserEnabled, groop)
			VALUES
			(:name, :lastName, :email, :username, :password, 1, 1)"
		);
		$stmt->bindParam(':name', $user['UserName']);
		$stmt->bindParam(':lastName', $user['UserLastname']);
		$stmt->bindParam(':email', $user['UserEmail']);
		$stmt->bindParam(':username', $user['UserUsername']);
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
			"SELECT * FROM user WHERE UserUsername=(:username)"
		);
		$user_by_username->bindParam(':username', $user['UserUsername']);

		$user_by_email = $dbh->prepare(
			"SELECT * FROM user WHERE UserEmail=(:email)"
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
		$req = $dbh->prepare("SELECT COUNT(*) FROM offer WHERE OfferStatus=1");
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

		$req = $dbh->prepare("SELECT * FROM offer JOIN company ON company=CompanyId WHERE OfferId>=(:start) AND OfferStatus=1 LIMIT 100");
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

		$req = $dbh->prepare("SELECT * FROM offer JOIN company ON company=CompanyId WHERE OfferTitle LIKE (:search) AND OfferId>=(:start) AND OfferStatus=1 ORDER BY OfferStarting LIMIT 100");
		$req->bindParam(':start', $start);
		$req->bindParam(':search', $search);

		$count = $dbh->prepare("SELECT COUNT(*) FROM offer WHERE OfferTitle LIKE (:search) AND OfferId>=(:start) AND OfferStatus=1");
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

		$req = $dbh->prepare("SELECT * FROM user LEFT JOIN company ON (company IS NOT NULL AND company=CompanyId) WHERE UserUsername=(:user)");
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

		$req = $dbh->prepare("DELETE FROM user WHERE UserUsername=(:username)");
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

		$req = $dbh->prepare("UPDATE user SET UserName=(:name), UserLastName=(:lastname), UserEmail=(:email), UserDescription=(:description) WHERE UserUsername=(:username)");
		$req->bindParam(':name', $user['UserName']);
		$req->bindParam(':lastname', $user['UserLastname']);
		$req->bindParam(':email', $user['UserEmail']);
		$req->bindParam(':description', $user['UserDescription']);
		$req->bindParam(':username', $user['UserUsername']);

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

		$req = $dbh->prepare("UPDATE user SET UserPassword=(:password) WHERE UserUsername=(:username)");
		$req->bindParam(':password', $user['UserPassword']);
		$req->bindParam(':username', $user['UserUsername']);

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

		$req = $dbh->prepare("UPDATE user SET company=(SELECT CompanyId FROM company WHERE CompanyName=(:company)) WHERE UserUsername = (:username)");
		$req->bindParam(':company', $user['company']);
		$req->bindParam(':username', $user['UserUsername']);

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

		$req = $dbh->prepare("SELECT * FROM groops WHERE GroupId=(:id)");
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

function GetUsersList() {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM user");

		$req->execute();

		$request = $req->fetchAll();

		$dbh->commit();

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function GetCompaniesList() {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM company");

		$req->execute();

		$request = $req->fetchAll();

		$dbh->commit();

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function GetCompanyInfo($name) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("SELECT * FROM company WHERE CompanyName=(:name)");
		$req->bindParam(':name', $name);

		$req->execute();

		$request = $req->fetch(PDO::FETCH_ASSOC);

		$dbh->commit();

		return $request;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function UpdateCompany($company) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE company SET CompanyName=(:name), CompanyDescription=(:description) WHERE CompanyId=(:id)");
		$req->bindParam(':name', $company['CompanyName']);
		$req->bindParam(':description', $company['CompanyDescription']);
		$req->bindParam(':id', $company['CompanyId']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function UpdateAccountById($user) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE user SET UserName=(:name), UserLastName=(:lastname), UserEmail=(:email), UserDescription=(:description), UserUsername=(:username) WHERE UserId=(:id)");
		$req->bindParam(':name', $user['UserName']);
		$req->bindParam(':lastname', $user['UserLastName']);
		$req->bindParam(':email', $user['UserEmail']);
		$req->bindParam(':description', $user['UserDescription']);
		$req->bindParam(':username', $user['UserUsername']);
		$req->bindParam(':id', $user['UserId']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function DisableAccount($user) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE user SET UserEnabled=IF(UserEnabled=1, 0, 1) WHERE UserUsername=(:username)");
		$req->bindParam(':username', $user['UserUsername']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function DisableCompany($company) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("UPDATE company SET CompanyEnabled=IF(CompanyEnabled=1, 0, 1) WHERE CompanyName=(:name)");
		$req->bindParam(':name', $company['CompanyName']);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}

function DeleteCompany($company) {
	$dbh = DBConnect();

	try {
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();

		$req = $dbh->prepare("DELETE FROM company WHERE CompanyName=(:company)");
		$req->bindParam(':company', $company);

		$req->execute();

		$dbh->commit();

		return true;
	} catch (Exception $e) {
		$dbh->rollBack();
		return false;
	}
}
