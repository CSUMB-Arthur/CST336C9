<?php
    $somearray = $_POST;
    
    include "../dbconnection.php";
    
    $conn = getDatabaseConnection();
    

    $sql = "INSERT INTO class 
            (course_id , room_number, days_of_week, time, semester, start_date)
            VALUES (:course_id, :room_number, :days_of_week, :time, :semester, :start_date);";

    $stmt = $conn -> prepare($sql);
    
    $np = array();
    $np[':course_id'] = $somearray[':course_id'];
    $np[':room_number'] = $somearray[':room_number'];
    $np[':days_of_week'] = $somearray[':days_of_week'];
    $np[':time'] = $somearray[':time'];
    $np[':semester'] = $somearray[':semester'];
    $np[':start_date'] = $somearray[':start_date'];
    $stmt -> execute($np);
    //if ($conn->query($sql) == true) {
        //$insertedid = $conn->insert_id;
        //$somearray['addedId'] = $insertedid;
        //echo "INSERT success, id: ".$id;
    //}

    
    //$record = $stmt->fetch(PDO::FETCH_ASSOC);
    $somearray['type'] = "add";
    
    //return values that were used, so the table row can be modified from there on success
    echo json_encode($somearray);
?>