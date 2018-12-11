<?php 
    include "../dbconnection.php";
    
    $conn = getDatabaseConnection();
    
    $sql = "SELECT * 
            FROM course;";
    
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($records);
?>