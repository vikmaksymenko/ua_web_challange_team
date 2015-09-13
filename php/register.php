<?php
include './lib/mysql.php';

$mysqli = connectToMySQL();

$postUsername = htmlspecialchars($_POST['username']);
$postEmail = htmlspecialchars($_POST['email']);
$postPassword = htmlspecialchars($_POST['password']);



//Searching if no same user created already
$query = "SELECT email FROM users WHERE email = ? OR username = ?";
$statement = $mysqli->prepare($query);

$statement->bind_param('ss', $postEmail, $postUsername);

$statement->execute();

$statement->bind_result($email);
$matchingUser = $statement->fetch();

$statement->close();

if($matchingUser[0].$email) {
    echo 'false';
} else {
    //values to be inserted in database table
    $username = '"'.$mysqli->real_escape_string($postUsername).'"';
    $email = '"'.$mysqli->real_escape_string($postEmail).'"';
    $password = '"'.$mysqli->real_escape_string($postPassword).'"';

    $insert_row = $mysqli->query("INSERT INTO users (username, email, password) VALUES($username, $email, $password)");

    if($insert_row) {
        echo 'true';
    } else {
        die('Error : ('. $mysqli->errno .') '. $mysqli->error);
    }
}

?>