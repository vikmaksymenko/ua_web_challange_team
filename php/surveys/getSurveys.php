<?php
include '../lib/mysql.php';

session_start();

$mysqli = connectToMySQL();
echo "session".$_SESSION['email'];
$userID = findUser($mysqli, $_SESSION['email'], true);
if($userID) {
    $query = "SELECT id, name, start, end FROM surveys WHERE owner = ". $userID;
    $results = $mysqli->query($query);
    
    $surveys = [];
    
    // Gather results
    while($row = $results->fetch_assoc()) {
        array_push($surveys, $row);
    };
    
    // Return results as json
    echo json_encode($surveys);

    // Disposing resources
    $results->free();
} else {
    echo 'false';
}

$mysqli->close();
?>
