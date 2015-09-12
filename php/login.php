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
    
    $query = "SELECT email FROM users WHERE email = ? AND password = ?";
    $statement = $mysqli->prepare($query);
    
    $statement->bind_param('ss', htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']));
    
    $statement->execute();
    
    $statement->bind_result($email);
    $matchingUser = $statement->fetch();
    
    if($matchingUser[0].$email) {
        echo 'true';
    } else {
        echo 'false';
    }
    
    $statement->close();
?>