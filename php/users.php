<?php
include './lib/mysql.php';

$mysqli = connectToMySQL();

$query = "SELECT email, username FROM users";
$results = $mysqli->query($query);

$users = [];

// Gather results
while($row = $results->fetch_assoc()) {
    array_push($users, $row);
};

// Return results as json
echo json_encode($users);

// Disposing resources
$results->free();
$mysqli->close();
?>