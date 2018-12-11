<?php
    $somearray = $_POST;
    
    include "../dbconnection.php";
    
    $conn = getDatabaseConnection();
    

    $sql = "INSERT INTO class 
            (course_id , room_number, days_of_week, time, semester, start_date)
            VALUES (:course_id, :room_number, :days_of_week, :time, :semester, :start_date);
            /*:course_name :id*/";

    $stmt = $conn -> prepare($sql);
    $stmt -> execute($somearray);
    
    //if ($conn->query($sql) === true) {
    //    $insertedid = $conn->insert_id;
    //    $somearray['addedId'] = $insertedid;
    //    echo "INSERT success, id: ".$id;
    //}

    
    //$record = $stmt->fetch(PDO::FETCH_ASSOC);
    $somearray['type'] = "add";
    
    //return values that were used, so the table row can be modified from there on success
    echo json_encode($somearray);
?>

