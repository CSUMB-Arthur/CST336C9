<?php 
    //concatId was passed as a string, such as classId23
    //We need to cut out the letters, then convert that into an integer.
    $classid = $_GET['concatId'];
    $classid = (int)substr($classid,7);
    include "../dbconnection.php";
    
    $conn = getDatabaseConnection();
    
    $sql = "SELECT * 
            FROM class
            JOIN course
            ON class.course_id = course.course_id
            WHERE class.class_id = :id";
    $np = array();
    $np[":id"] = $classid;
    
    $stmt = $conn -> prepare($sql);
    $stmt -> execute($np);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $sql = "SELECT course_name, course_id 
        FROM course;";

    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $courseNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(array($record, $courseNames));
?>