<?php


    include "../dbconnection.php";
    
    $conn = getDatabaseConnection("pets");
    
    $sql = "SELECT *, YEAR(CURDATE()) - yob age 
            FROM pets
            WHERE id = :id";
    $np = array();
    $np[":id"] = $_GET['id'];
    
    $stmt = $conn -> prepare($sql);
    $stmt -> execute($np);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($record);
    
    
?>