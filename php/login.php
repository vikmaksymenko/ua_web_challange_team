<?php
include './lib/mysql.php';

session_start();

$mysqli = connectToMySQL();

$query = "SELECT email FROM users WHERE email = ? AND password = ? LIMIT 1";
$statement = $mysqli->prepare($query);

$statement->bind_param('ss', htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));

$statement->execute();

$statement->bind_result($email);
$matchingUser = $statement->fetch();
if($matchingUser[0].$email) {
    $_SESSION['email'] = $matchingUser[0].$email;
    echo 'true';
} else {
    echo 'false';
}

$statement->close();
?>