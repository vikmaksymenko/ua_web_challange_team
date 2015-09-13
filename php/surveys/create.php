<?php

include '../lib/mysql.php';

$mysqli = connectToMySQL();

$name = htmlspecialchars($_POST['name']);
$emails = htmlspecialchars($_POST['emails']) ?: 'NULL';
$data = htmlspecialchars($_POST['data']);
$startDate = htmlspecialchars($_POST['startDate']) ?: 'NULL';
$endDate = htmlspecialchars($_POST['endDate']) ?: 'NULL';
$ownerID = htmlspecialchars($_POST['ownerID']);

echo $emails;
// $emails = empty($emails) ? 'NULL' : $emails;

$query = 'INSERT INTO surveys (name, emails, data, start, end, owner) VALUES (?, ?, ?, ?, ?)';
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sssss', $name, "NULL", $data, "NULL", "NULL", $ownerID);

if($stmt->execute()) {
    echo 'true';
} else {
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

$stmt->close();
?>