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

function findUser($mysqli, $email, $returnID) {
    $query = "SELECT username, id FROM users WHERE email = ? LIMIT 1";
    
    $statement = $mysqli->prepare($query);
    
    $statement->bind_param('s', $email);
    
    if(!$statement->execute()) {
        return false;
    }
    
    $statement->bind_result($username, $id);
    $matchingUser = $statement->fetch();
    $statement->close();
    
    if($returnID) {
        return $matchingUser[0].$id;
    } else {
        return $matchingUser[0].$username;
    }
}

?>
