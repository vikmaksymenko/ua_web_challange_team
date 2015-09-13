<?php
include '../lib/mysql.php';

$mysqli = connectToMySQL();

$query = "INSERT INTO results (email, data, survey_id) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ssi', $_POST['email'], $_POST['data'], $_POST['survey_id']);
if($stmt->execute()) {
    echo 'true';
} else {
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

$stmt->close();
$mysqli->close();
?>
