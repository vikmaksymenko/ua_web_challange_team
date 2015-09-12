<?php
$servername = getenv('IP');
$username = getenv('C9_USER');
$password = "";
$database = "c9";
$dbport = 3306;

// Create connection
$mysqli = new mysqli($servername, $username, $password, $database, $dbport);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$postUsername = htmlspecialchars($_POST['username']);
$postEmail = htmlspecialchars($_POST['email']);
$postPassword = htmlspecialchars($_POST['password']);

//values to be inserted in database table
$email = '"'.$mysqli->real_escape_string($postEmail).'"';
$password = '"'.$mysqli->real_escape_string($postPassword).'"';

$query = "SELECT email FROM users WHERE email = ? AND password = ?";
$statement = $mysqli->prepare($query);

$statement->bind_param('ss', $postEmail, $postPassword);

$statement->execute();

$statement->bind_result($email);
$matchingUser = $statement->fetch();

$statement->close();
if($matchingUser[0].$email) {
    echo 'false';
} else {
    $insert_row = $mysqli->query("INSERT INTO users (email, password) VALUES($email, $password)");

    if($insert_row) {
        echo 'true';
    } else {
        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    }
}

?>