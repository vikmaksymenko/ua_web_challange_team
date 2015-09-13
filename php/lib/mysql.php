<?php
function connectToMySQL () {
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
    
    return $mysqli;
}

function findUser($mysqli, $email) {
    $query = "SELECT username FROM users WHERE email = ? LIMIT 1";
    
    $statement = $mysqli->prepare($query);
    
    $statement->bind_param('s', $email);
    
    $statement->execute();
    
    $statement->bind_result($username);
    $matchingUser = $statement->fetch();
    $statement->close();
    
    return $matchingUser[0].$username;
}

?>
