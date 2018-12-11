<?php

include 'dbconnection.php';
$conn=getDatabaseConnection();//"final_project");


function searchClasses($semester, $time, $days)
{
    //echo "IN SEARCH CLASSES";
    global $conn;
    //if user selected all three options
    if(isset($semester) && isset($time) && isset($days))
    {
        if($time=='morning')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id 
            WHERE time<'12:00' AND semester='$semester' AND days_of_week='$days'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
            //return $searchResult;
        }
        elseif($time=='afternoon')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time>'12:00' AND semester='$semester' AND days_of_week='$days'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
            //return $searchResult;
        }
    }
    //if user only selects time and semester
     if(isset($semester) && isset($time) && (!isset($days)))
     {
        if($time=='morning')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time<'12:00' AND semester='$semester'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
            //return $searchResult;
        }
        elseif($time=='afternoon')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time>'12:00' AND semester='$semester'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
            //return $searchResult;
        }
     }
     
     //if user only selects time and days
     elseif(isset($time) && isset($days) && (!isset($semester)))
     {
         if($time=='morning')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time<'12:00' AND days_of_week='$days'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
           // return $searchResult;
        }
        elseif($time=='afternoon')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time>'12:00' AND days_of_week='$days'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
           // return $searchResult;
        }
     }
     
     //if user only selects semester and days
     elseif(isset($semester) && isset($days) && (!isset($time)))
     {
        $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE semester='$semester' AND days_of_week='$days'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
        //return $searchResult;
     }
     
     //if user has not selected any thing
     elseif(!isset($semester) && !isset($days) && !isset($time))
     {
        $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
        //return $searchResult;
     }
     //if only semester is selected
     elseif(isset($semester) && !isset($days) && !isset($time))
     {
        $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE semester='$semester'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
        //return $searchResult;
     }
 
     //if only days are selected
     elseif(!isset($semester) && isset($days) && !isset($time))
     {
        $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE days_of_week='$days'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
        //return $searchResult;
     }
     //if only time is selected
     elseif(!isset($semester) && !isset($days) && isset($time))
     {
        if($time=='morning')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time<'12:00'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
           // return $searchResult;
        }
        elseif($time=='afternoon')
        {
            $sql="SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost, co.course_id
            FROM class cl join course co
            ON cl.course_id = co.course_id  WHERE time>'12:00'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $searchResult = $stmt->fetchALL(PDO::FETCH_ASSOC);
           // return $searchResult;
        }
     }
     displayResults($searchResult);
}
function displayResults($searchResult)
{
    if($searchResult==null)
    { //Display your search matched no criteria
        echo "Sorry your search matched no criteria. Please try again with different search values";
    }
    else
    {
        echo "<div class='container'>";
        echo "<table class='table table-hover table-bordered'>";
        
        echo "<thead class='thread-light'>
        <tr>
            <td><strong>Class ID</strong></td>
            <td><strong>Course ID</strong> </td>
            <td><strong>Course Name</strong> </td>
            <td><strong>Room Number</strong></td>
            <td><strong>Time</strong></td>
            <td><strong>Days</strong> </td>
            <td><strong>Start Date</strong></td>
            <td><strong>Semester</strong></td>
            <td><strong>Add Class</strong> </td>
        </tr>
        </thead>
        
        <tbody class='csumbStripes'>";
        //display search results

        for($i=0; $i<count($searchResult) ;$i++)
        {
            echo "<tr>";
            echo "<td>";
            echo $searchResult[$i]['class_id'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['course_id'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['course_name'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['room_number'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['time'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['days_of_week'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['start_date'];
            echo "</td>";
            
            echo "<td>";
            echo $searchResult[$i]['semester'];
            echo "</td>";
            
            echo"<form method='post'>";
            echo "<input type='hidden' name='class_id' value= '" . $searchResult[$i]['class_id'] . "'>";
            echo "<input type='hidden' name='course_name' value= '" . $searchResult[$i]['course_name'] . "'>";
            echo "<input type='hidden' name='semester' value= '" . $searchResult[$i]['semester'] . "'>";
            echo "<input type='hidden' name='days_of_week' value= '" . $searchResult[$i]['days_of_week'] . "'>";
            echo "<input type='hidden' name='time' value= '" . $searchResult[$i]['time'] . "'>";
            echo "<input type='hidden' name='start_date' value= '" . $searchResult[$i]['start_date'] . "'>";
            echo "<input type='hidden' name='room_number' value= '" . $searchResult[$i]['room_number'] . "'>";
            echo "<input type='hidden' name='number_of_units' value= '" . $searchResult[$i]['number_of_units'] . "'>";
            echo "<input type='hidden' name='cost' value= '" . $searchResult[$i]['cost'] . "'>";
            if($_POST['class_id'] == $searchResult[$i]['class_id']){
                echo "<td><button class='btn btn-success'>Added</button></td>";
            } else{
                echo "<td><button class='btn btn-warning'>Add</button></td>";
            }
            echo"</form>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
}

?>