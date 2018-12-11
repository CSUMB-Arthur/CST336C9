<?php
    $classid = $_GET['classId'];
    
    include "../dbconnection.php";
    
    $conn = getDatabaseConnection("class");
    
    $sql = "DELETE FROM class
            WHERE class_id = :id;";

    $np = array();
    $np[':id'] = $classid;
    $stmt = $conn -> prepare($sql);
    $stmt -> execute($np);
    header("Location:../admin.php");
?>

