<?php
    session_start();
    //include 'dbconnection.php';
    //$connect = getDatabaseConnection();
 
    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    //Check to see if an item has been added to the cart
    if(isset($_POST['class_id'])){
        
        //Creating an array to hold an item's properties
        $newItem = array();
        $newItem['class_id'] = $_POST['class_id'];
        $newItem['course_name'] = $_POST['course_name'];
        $newItem['semester'] = $_POST['semester'];
        $newItem['days_of_week'] = $_POST['days_of_week'];
        $newItem['time'] = $_POST['time'];
        $newItem['start_date'] = $_POST['start_date'];
        $newItem['room_number'] = $_POST['room_number'];
        $newItem['number_of_units'] = $_POST['number_of_units'];
        $newItem['cost'] = $_POST['cost'];    
        
        //Check to see if other items with this id are in the array. If so, this item isn't new. Only update quantity. Must be passed by reference so that each item can be updated!
        foreach ($_SESSION['cart'] as &$item){
            if ($newItem['class_id'] == $item['class_id']) {
                $found = true;
            }
        }
        
        //Else add it to array
        if($found != true) {
            array_push($_SESSION['cart'], $newItem);
        }
    }
    
    function displayCartCount(){
        echo count($_SESSION['cart']);
    }
    
    function displayAllCourses(){
        global $connect;
        
        $sql = "
        SELECT cl.room_number, cl.time, cl.days_of_week, cl.start_date, cl.semester, cl.class_id, co.course_name, co.number_of_units, co.cost
        FROM class cl join course co
            ON cl.course_id = co.course_id";
            
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<table class=\"table table-striped\">";
        foreach($records as $record){
            echo "<tr><td>". $record['course_name']."</td><td>".$record['semester']."</td><td>".$record['days_of_week']."</td><td>".$record['time'].
            "</td><td>".$record['start_date']."</td><td>".$record['room_number']."</td><td>".$record['number_of_units']."</td>";
            //Update form for this item
            echo"<form method='post'>";
            echo "<input type='hidden' name='class_id' value= '" . $record['class_id'] . "'>";
            echo "<input type='hidden' name='course_name' value= '" . $record['course_name'] . "'>";
            echo "<input type='hidden' name='semester' value= '" . $record['semester'] . "'>";
            echo "<input type='hidden' name='days_of_week' value= '" . $record['days_of_week'] . "'>";
            echo "<input type='hidden' name='time' value= '" . $record['time'] . "'>";
            echo "<input type='hidden' name='start_date' value= '" . $record['start_date'] . "'>";
            echo "<input type='hidden' name='room_number' value= '" . $record['room_number'] . "'>";
            echo "<input type='hidden' name='number_of_units' value= '" . $record['number_of_units'] . "'>";
            echo "<input type='hidden' name='cost' value= '" . $record['cost'] . "'>";
            if($_POST['class_id'] == $record['class_id']){
                echo "<td><button class='btn btn-success'>Added</button></td>";
            } else{
                echo "<td><button class='btn btn-warning'>Add</button></td>";
            }
            echo"</form>";
        }
        echo "</table>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
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
    <div class='container'>
        <div class='text-center'>
            
            <!-- Bootstrap Navagation Bar -->
            <nav class='navbar navbar-default - navbar-fixed-top'>
                <div class='container-fluid'>
                    <div class='navbar-header'>
                        <a class='navbar-brand' href='#'>Course Registration</a>
                    </div>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.html'>Home</a></li>
                        <li><a href='student.php'>Courses</a></li>
                        <li><a href='cart.php'>
                        <span class = 'glyphicon glyphicon-shopping-cart' aria-hidden ='true'></span>
                        Cart: <?=displayCartCount()?></a></li>
                    </ul>
                </div>
            </nav>
            <br /> <br /> <br />
            
         <div class="topbar">
          
                <h1 class="left">Cloud5 College</h1>
                <img class="right" src= "img/cloud5logo.png" class="image-rounded" alt="cloud5 logo"></img>
            
            <hr width="100%">
            <br>
        </div>
        <div class="bottombar">
            <h1>Search and Register for Classes</h1>
        </div>
        <form id='searchForm'>
            <strong class='searchCategory'>Search by Semester:</strong>
            <br>
            <div class='searchOptionsList'>
                 <input type="radio" name="semester" id="Spring" value="Spring"
                <?php $semester=$_GET['semester'];if (isset($semester) && $semester=="Spring") echo "checked";?>>Spring</input><br>
                
                <input type="radio" name="semester" id="Summer" value="Summer"
                <?php $semester=$_GET['font'];if (isset($summer) && $semester=="Summer") echo "checked";?>>Summer</input><br>
                
                <input type="radio" name="semester" id="Winter" value="Winter"
                <?php $semester=$_GET['semester'];if (isset($semester) && $semester=="Winter") echo "checked";?>>Winter</input><br>
           </div>
            
            <hr>
            
            <strong class='searchCategory'>Search by time of day:</strong>
            <br>
            <div class='searchOptionsList'>
                 <input type="radio" name="time" id="morning" value="morning"
                <?php $time=$_GET['time'];if (isset($time) && $time=="morning") echo "checked";?>>Morning</input><br>
                
                
                <input type="radio" name="time" id="afternoon" value="afternoon"
                <?php $time=$_GET['time'];if (isset($time) && $time=="afternoon") echo "checked";?>>Afternoon</input><br>
            </div>
            <hr>
            
            <strong class='searchCategory'>Search by days of week:</strong>
            <br>
            <div class='searchOptionsList'>
                <input type="radio" name="days" id="days" value="M"
                <?php $days=$_GET['days'];if (isset($days) && $days=="M") echo "checked";?>>Monday</input><br>
                
                 <input type="radio" name="days" id="days" value="T"
                <?php $days=$_GET['days'];if (isset($days) && $days=="T") echo "checked";?>>Tuesday</input><br>
                
                <input type="radio" name="days" id="days" value="W"
                <?php $days=$_GET['days'];if (isset($days) && $days=="W") echo "checked";?>>Wednesday</input><br>
                
                <input type="radio" name="days" id="days" value="W"
                <?php $days=$_GET['days'];if (isset($days) && $days=="Th") echo "checked";?>>Thursday</input><br>
                
                 <input type="radio" name="days" id="days" value="MW"
                <?php $days=$_GET['days'];if (isset($days) && $days=="MW") echo "checked";?>>Monday/Wednesday</input><br>
            
            
                <input type="radio" name="days" id="days" value="MTWTH"
                <?php $days=$_GET['days'];if (isset($days) && $days=="MTWTH") echo "checked";?>>Mon/Tue/Wed/Thurs</input><br>
            
           
            <br>
            <button type="submit" id='courseSearchBtn' class="btn btn-primary btn-lg">Search</button>
        </form>
        
        </div>
            <hr>
            <br>
        
        <br>
        <?php
        include 'functions.php';
        $semester=$_GET['semester'];
        $time = $_GET['time'];
        $days = $_GET['days'];
          echo "<br>";

        searchClasses($semester,$time,$days);
        ?>
        
            <?php
            /*
            <!-- Search Form -->
            <form enctype="text/plain">
                <div class="form-group">
                    <label for="pName">Product Name</label>
                    <input type="text" class="form-control" name="query" id="pName" placeholder="Name">
                </div>
                <input type="submit" value="Submit" class="btn btn-default">
                <br /><br />
            </form>
            
            <!-- Display Search Results -->
            
            <table>
                <tr id='thead'>
                    <td>Course</td>
                    <td>Semester</td>
                    <td>Days</td>
                    <td>Time</td>
                    <td>Start Date</td>
                    <td>Room</td>
                    <td>Units</td>
                </tr>
                <?=displayAllCourses()?>
            </table>*/
            ?>
        </div>
    </div>
    </body>
</html>