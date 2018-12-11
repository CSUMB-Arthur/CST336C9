<?php
    session_start();
    include 'dbconnection.php';
    $conn = getDatabaseConnection();
    
    function numberOfStudents(){ 
        global $conn;
        $sql = "
        SELECT COUNT(*) as numberOfStudents from student";
            
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($records as $record){
            echo"<h1 id='number'>Total Number of Students: ". $record['numberOfStudents']. ".</h1>";
        }
    }
    
    function avgCost(){
        global $conn;
        $sql = "
                SELECT ROUND(AVG(cost), 2) as avgCost from course";
            
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($records as $record){
            echo"<h1 id='cost'>Average Cost of Each Course: $". $record['avgCost']. "</h1>";
        }
    }

    function latestDate(){
        global $conn;
        $sql = "
                SELECT MAX(start_date) as latestDate from class";
            
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($records as $record){
            echo"<h1 id = 'latest'>The Latest Start Date: ". $record['latestDate']. "</h1>";
        }
    }
    function classCountForEachCourse(){
        global $conn;
        $sql = "
        SELECT co.course_name, COUNT(*) as number_of_classes
        FROM course co join class cl 
        ON co.course_id = cl.course_id
        Group BY co.course_id";
            
            
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo"<table class='table table-bordered' id='classCount'>";
        echo"<tr>";
        echo"<td><h4><strong>Course Name</strong></h4></td>";
        echo"<td><h4><strong>Class Count</strong></h4></td>";
        echo"</tr>";
        
        
        foreach($records as $record){
            echo"<tr><td><h4>". $record['course_name']. "</h4></td><td><h4>" . $record['number_of_classes'] ."</h4></td></tr>";
        }
        echo"</table>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @import url("css/styles.css");
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
        <style>
            @import url("css/styles.css");
        </style>
        <title>Registration Page</title>
    </head>
    <body>
          <div class="topbar">
          
                <h1 class="left">Cloud5 College</h1>
                <img class="right" src= "img/cloud5logo.png" class="image-rounded" alt="cloud5 logo"></img>
            
            <hr width="100%">
            <br>
        </div>
        <div class="bottombar">
            <h1>Generate Administrator Reports</h1>
        </div>
        <div id = 'reports'>
            <button class='btn btn-info' id='studentsShowButton'>Show Number of Students</button>
            <button class='btn btn-info' id='studentsHideButton'>Hide Number of Students</button>
            <?=numberOfStudents()?><br><br>
            
            <button class='btn btn-info' id='costShowButton'>Show Average Course Cost</button>
            <button class='btn btn-info' id='costHideButton'>Hide Average Course Cost</button>
            <?=avgCost()?><br><br>
            
            <button class='btn btn-info' id='dateShowButton'>Show Latest Class Start Date</button>
            <button class='btn btn-info' id='dateHideButton'>Hide Latest Class Start Date</button>
            <?=latestDate()?><br><br>
            
            <button class='btn btn-info' id='countShowButton'>Show Class Count Per Course</button>
            <button class='btn btn-info' id='countHideButton'>Hide Class Count Per Course</button>   
            <?=classCountForEachCourse()?>
        </div>
        <script src="js/reports.js"></script>
    </body>
</html>