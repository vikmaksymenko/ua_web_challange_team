<?php
include '../lib/mysql.php';

$mysqli = connectToMySQL();

$query = "SELECT * FROM surveys WHERE id = ".  $_GET['id'] ." LIMIT 1";
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
