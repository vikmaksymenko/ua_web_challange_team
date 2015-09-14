<?php

include '../lib/mysql.php';
include '../../Sender/Email_sender.php';

session_start();

$mysqli = connectToMySQL();
$ownerID = findUser($mysqli, $_SESSION['email'], true);
$surveyName = $_POST['name'];

$query = 'INSERT INTO surveys (name, emails, data, start, end, owner) VALUES (?, ?, ?, ?, ?, ?)';
$stmt = $mysqli->prepare($query);
$null = NULL;
$stmt->bind_param('sbbssi', $surveyName, $null, $null, $_POST['startDate'], $_POST['endDate'], $ownerID);

$stmt->send_long_data(1, mysql_escape_string($_POST['emails']));
$stmt->send_long_data(2, mysql_escape_string($_POST['data']));

if($stmt->execute()) {
    echo 'true';
} else {
    die('Error : ('. $mysqli->errno .') '. $mysqli->error);
}
$survey_id = $mysqli->insert_id;

$stmt->close();


$es = new email_sender();
$send_data = [];
$emails = explode(" ", $_POST['emails']);
$query = "SELECT username, email FROM users WHERE id = ? LIMIT 1";
    
$statement = $mysqli->prepare($query);
    
$statement->bind_param('s', $ownerID);

$statement->execute();

$statement->bind_result($username, $email);
$sender = $statement->fetch();
$statement->close();

$query = 'INSERT INTO links (survey_id, email, hash) VALUES (?, ?, ?)';
$stmt = $mysqli->prepare($query);
for($i = count($emails) - 1; $i >= 0; $i--) {
    $hash = hash('sha256', $emails[$i] ." ". $survey_id);
    $send_data[$i] = [
            'email_sender' => $sender[0].$email,
            'name_sender' => $sender[0].$username,
            'name_survey' => $surveyName,
            'email_addressee' => $emails[$i],
            'link_survey' => $hash
        ];
    $stmt->bind_param('iss', $survey_id, $emails[$i], $hash);
    if(!$stmt->execute()) {
        echo 'Error : ('. $mysqli->errno .') '. $mysqli->error;
    }
}


$es->send_email($send_data);
$mysqli->close();
?>
