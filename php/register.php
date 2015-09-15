<?php

include './lib/mysql.php';

$mysqli = connectToMySQL();

$postUsername = htmlspecialchars($_POST['username']);
$postEmail = str_replace('%2B', '+', htmlspecialchars($_POST['email']));
$postPassword = hash('sha256', htmlspecialchars($_POST['password']));

if(findUser($mysqli, $postEmail, false)) {
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
