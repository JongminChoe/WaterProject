<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'water');
define('DB_USER', 'root'); // change to your id
define('DB_PASS', 'password'); // change to your password

$pdo = null;
try {
	$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS, array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	));
	$pdo->exec('SET NAMES utf8');
} catch (PDOException $e) {
	die($e->getMessage());
}

$result = array();

if (isset($_GET['start']) && isset($_GET['end'])) {
	if (!(isset($_GET['idlocation']) || isset($_GET['criteria']))) {
		badRequest();
	}
	$idlocation = $_GET['idlocation'];
	$criteria = $_GET['criteria'];
	$start_time = $_GET['start'];
	$end_time = $_GET['end'];
	
    $sth = $pdo->prepare(
		'SELECT `timestamp`, `value`
		FROM `datapoint`
		WHERE `idcriteria` = (
			SELECT `idcriteria`
			FROM `criteria`
			WHERE `desc` = ?
		) AND `idlocation` = ?
		AND `timestamp` BETWEEN ? AND ?
		ORDER BY `timestamp` ASC'
	);
	$sth->bindParam(1, $criteria, PDO::PARAM_STR);
	$sth->bindParam(2, $idlocation, PDO::PARAM_STR);
	$sth->bindParam(3, $start_time, PDO::PARAM_STR);
	$sth->bindParam(4, $end_time, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	foreach ($pdo_result as $row) {
		$result['data'][] = array(
			'timestamp' => $row['timestamp'],
			'value' => (double) $row['value']
		);
	}
}
else if (isset($_GET['criteria'])) {
	if (!(isset($_GET['idlocation']))) {
		badRequest();
	}
	$idlocation = $_GET['idlocation'];
	$criteria = $_GET['criteria'];
	
    $sth = $pdo->prepare(
		'SELECT MAX(`timestamp`) AS `max`, MIN(`timestamp`) AS `min`
		FROM (
			SELECT `timestamp`
			FROM `datapoint`
			WHERE `idcriteria` = (
				SELECT `idcriteria`
				FROM `criteria`
				WHERE `desc` = ?
			) AND `idlocation` = ?
		) AS `time`'
	);
	$sth->bindParam(1, $criteria, PDO::PARAM_STR);
	$sth->bindParam(2, $idlocation, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) != 1) {
		notFound();
	}

	$result['data'] = array(
		'first_date' => $pdo_result[0]['min'],
		'last_date' => $pdo_result[0]['max']
	);
}
else if (isset($_GET['idlocation'])) {
	$idlocation = $_GET['idlocation'];

    $sth = $pdo->prepare(
		'SELECT DISTINCT `desc`
		FROM `criteria`
		WHERE `idcriteria` IN (
			SELECT idcriteria
			FROM datapoint
			WHERE idlocation = ?
		)'
	);
	$sth->bindParam(1, $idlocation, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	foreach ($pdo_result as $row) {
		$result['data'][] = $row['desc'];
	}
}
else if (isset($_GET['L4'])) {
	if (!(isset($_GET['L1']) || isset($_GET['L2']) || isset($_GET['L3']))) {
		badRequest();
	}
	$L1 = $_GET['L1'];
	$L2 = $_GET['L2'];
	$L3 = $_GET['L3'];
	$L4 = $_GET['L4'];

    $sth = $pdo->prepare(
		'SELECT `idlocation`
		FROM `location`
		WHERE `location1` = ?
		AND `location2` = ?
		AND `location3` = ?
		AND `location4` = ?'
	);
	$sth->bindParam(1, $L1, PDO::PARAM_STR);
	$sth->bindParam(2, $L2, PDO::PARAM_STR);
	$sth->bindParam(3, $L3, PDO::PARAM_STR);
	$sth->bindParam(4, $L4, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) != 1) {
		notFound();
	}

	$idlocation = $pdo_result[0]['idlocation'];

    $sth = $pdo->prepare(
		'SELECT `desc`, `maxval`, `minval`, `value`, `unit`, `flag`
		FROM (
			SELECT `value`, `flag`, `datapoint`.`idcriteria`
			FROM (
				SELECT `idcriteria`, MAX(`timestamp`) AS `max`
				FROM (
					SELECT *
					FROM `datapoint`
					WHERE `idlocation` = :idlocation
				) AS `datapoint`
				GROUP BY `idcriteria`
			) AS `firstdatapoint`
			JOIN (
				SELECT *
				FROM `datapoint`
				WHERE `idlocation` = :idlocation
			) AS `datapoint`
			WHERE `firstdatapoint`.`idcriteria` = `datapoint`.`idcriteria`
			AND `firstdatapoint`.`max` = `datapoint`.`timestamp`
		) AS `datapoint`
		JOIN `criteria`
		WHERE `datapoint`.`idcriteria` = `criteria`.`idcriteria`'
	);
    $sth->bindParam(':idlocation', $idlocation, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	$result['idlocation'] = $idlocation;

	foreach ($pdo_result as $row) {
		$result['data'][] = array(
			'desc' => $row['desc'],
			'upperBound' => (double) $row['maxval'],
			'lowerBound' => (double) $row['minval'],
			'value' => (double) $row['value'],
			'unit' => $row['unit'],
			'flag' => (boolean) $row['flag']
		);
	}
}
else if (isset($_GET['L3'])) {
	if (!(isset($_GET['L1']) || isset($_GET['L2']))) {
		badRequest();
	}
	$L1 = $_GET['L1'];
	$L2 = $_GET['L2'];
	$L3 = $_GET['L3'];

    $sth = $pdo->prepare(
		'SELECT DISTINCT `location4`
		FROM `location`
		WHERE `location1` = ?
		AND `location2` = ?
		AND `location3` = ?'
	);
	$sth->bindParam(1, $L1, PDO::PARAM_STR);
	$sth->bindParam(2, $L2, PDO::PARAM_STR);
	$sth->bindParam(3, $L3, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	foreach ($pdo_result as $row) {
		$result['data'][] = $row['location4'];
	}
}
else if (isset($_GET['L2'])) {
	if (!(isset($_GET['L1']))) {
		badRequest();
	}
	$L1 = $_GET['L1'];
	$L2 = $_GET['L2'];

	$sth = $pdo->prepare(
		'SELECT DISTINCT `location3`
		FROM `location`
		WHERE `location1` = ?
		AND `location2` = ?'
	);
	$sth->bindParam(1, $L1, PDO::PARAM_STR);
	$sth->bindParam(2, $L2, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	foreach ($pdo_result as $row) {
		$result['data'][] = $row['location3'];
	}
}
else if (isset($_GET['L1'])) {
	$L1 = $_GET['L1'];

	$sth = $pdo->prepare(
		'SELECT DISTINCT `location2`
		FROM `location`
		WHERE `location1` = ?'
	);
	$sth->bindParam(1, $L1, PDO::PARAM_STR);
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	foreach ($pdo_result as $row) {
		$result['data'][] = $row['location2'];
	}
}
else if (count($_GET) == 0) {
	$sth = $pdo->prepare('SELECT DISTINCT `location1` FROM `location`');
	$sth->execute();
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$pdo_result = $sth->fetchAll();
	
	if ($pdo_result === false || count($pdo_result) <= 0) {
		notFound();
	}

	foreach ($pdo_result as $row) {
		$result['data'][] = $row['location1'];
	}
}
else {
	badRequest();
}
if (empty($result)) {
	notFound();
}

$pdo = null;

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
//echo json_encode($result, JSON_UNESCAPED_UNICODE); // debug

function badRequest() {
	header("HTTP/1.1 400 Bad Request");
	$pdo = null;
	exit;
}

function notFound() {
	header("HTTP/1.1 404 Not Found");
	$pdo = null;
	exit;
}
?>