<?php

include '../lib/mysql.php';

$mysqli = connectToMySQL();

$query = 'INSERT INTO surveys (name, emails, data, start, end, owner) VALUES (?, ?, ?, ?, ?, ?)';
$stmt = $mysqli->prepare($query);
$null = NULL;
$stmt->bind_param('sbbssi', $_POST['name'], $null, $null, $_POST['startDate'], $_POST['endDate'], $_POST['ownerID']);

$stmt->send_long_data(1, mysql_escape_string($_POST['emails']));
$stmt->send_long_data(2, mysql_escape_string($_POST['data']));

if($stmt->execute()) {
    echo 'true';
} else {
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

$stmt->close();
$mysqli->close();
?>
