<?php
include '../lib/mysql.php';

$mysqli = connectToMySQL();
$query = "SELECT survey_id FROM links WHERE hash = '". $_GET['hash'] ."' LIMIT 1";
$results = $mysqli->query($query);

if($results) {
    $survey = $results->fetch_assoc();
    $results->free();
    
    $query = "SELECT id, data, start, end FROM surveys WHERE id = ".  $survey['survey_id'] ." LIMIT 1";
    $results = $mysqli->query($query);
    
    $matchingSurvey = $results->fetch_object();
    
    if($matchingSurvey) {
        echo json_encode($matchingSurvey);
    } else {
        echo 'false';
    }
    
    $results->free();
} else {
    echo 'false';
}

$mysqli->close();
?>
