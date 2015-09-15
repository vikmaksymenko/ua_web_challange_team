<?php
include '../lib/mysql.php';

$mysqli = connectToMySQL();
$surveyID = $_POST['id'];

if(!$surveyID) {
    die('Survey id not provided, nothing to delete');
}

$query = 'DELETE FROM surveys WHERE id = ?';
$stmt = $mysqli->prepare($query);
$null = NULL;

$stmt->bind_param('i', $surveyID);

if($stmt->execute()) {
    echo 'true';
} else {
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}

$stmt->close();
$mysqli->close();
?>
