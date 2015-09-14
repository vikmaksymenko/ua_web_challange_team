<?php
include '../lib/mysql.php';

session_start();

$mysqli = connectToMySQL();
$userID = findUser($mysqli, $_SESSION['email'], true);
$query = "SELECT * FROM surveys WHERE id = ".  $userID ." LIMIT 1";
$results = $mysqli->query($query);


$matchingSurvey = $results->fetch_object();

if($matchingSurvey) {
    echo json_encode($matchingSurvey);
} else {
    echo 'false';
}

// Disposing resources
$results->free();
$mysqli->close();
?>
