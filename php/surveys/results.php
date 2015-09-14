<?php

include '../lib/mysql.php';

$mysqli = connectToMySQL();
$survey_id = $_GET['surveyID'];

$query = 'SELECT email, data from results WHERE survey_id = '. $survey_id;
$answer = $mysqli->query($query);

$results = [];
while($row = $answer->fetch_assoc()) {
    array_push($results, $row);
}

echo json_encode($results);

$answer->free();
$mysqli->close();

?>
