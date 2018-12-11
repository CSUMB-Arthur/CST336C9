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
    $stmt -> execute($somearray);
    


    //$record = $stmt->fetch(PDO::FETCH_ASSOC);
    $somearray['type'] = "update";
    //return values that were used, so the table row can be modified from there on success
    echo json_encode($somearray);
?>

