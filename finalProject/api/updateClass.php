<?php
    $somearray = $_POST;
    
    include "../dbconnection.php";
    
    $conn = getDatabaseConnection();
    
    $sql = "UPDATE class 
            SET course_id = :course_id, room_number = :room_number, 
            days_of_week = :days_of_week, time = :time, semester = :semester, 
            start_date = :start_date
            WHERE class_id = :id; --:course_name";

    $stmt = $conn -> prepare($sql);
    
        $np = array();
    $np[':course_id'] = $somearray[':course_id'];
    $np[':room_number'] = $somearray[':room_number'];
    $np[':days_of_week'] = $somearray[':days_of_week'];
    $np[':time'] = $somearray[':time'];
    $np[':semester'] = $somearray[':semester'];
    $np[':start_date'] = $somearray[':start_date'];
    $np[':id'] = $somearray[':id'];
    $stmt -> execute($np);
    


    //$record = $stmt->fetch(PDO::FETCH_ASSOC);
    $somearray['type'] = "update";
    //return values that were used, so the table row can be modified from there on success
    echo json_encode($somearray);
?>

