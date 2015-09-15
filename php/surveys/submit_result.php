<?php
include '../lib/mysql.php';

$mysqli = connectToMySQL();
$email = str_replace('%2B', '+', $_POST['email']);

$query = "INSERT INTO results (email, data, survey_id) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($query);
$null = NULL;
$stmt->bind_param('sbi', $email, $null, $_POST['survey_id']);
$stmt->send_long_data(1, $_POST['data']);
if($stmt->execute()) {
    echo 'true';
} else {
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

$stmt->close();
$mysqli->close();
?>
