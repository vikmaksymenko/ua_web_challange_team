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
    
    $query = "SELECT email, username FROM users";
    $results = $mysqli->query($query);
    
    $users = [];
    
    while($row = $results->fetch_assoc()) {
        array_push($users, $row);
    };
    
    echo json_encode($users);
    
    $results->free();
    $mysqli->close();
?>