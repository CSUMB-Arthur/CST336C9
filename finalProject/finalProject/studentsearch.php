<!DOCTYPE html>
<html>
    <title>Student Search</title>
    <head>
         <meta charset="utf-8">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="inc/styles.css" rel= "stylesheet" type="text/css" />
    </head>
    <body>
        <h1>Search for Classes</h1>
        <form>
            Search by Semester:
            <br>
             <input type="radio" name="semester" id="Spring" value="Spring"
            <?php $semester=$_GET['semester'];if (isset($semester) && $semester=="Spring") echo "checked";?>>Spring</input><br>
            
            <input type="radio" name="semester" id="Summer" value="Summer"
            <?php $semester=$_GET['font'];if (isset($summer) && $semester=="Summer") echo "checked";?>>Summer</input><br>
            
            <input type="radio" name="semester" id="Winter" value="Winter"
            <?php $semester=$_GET['semester'];if (isset($semester) && $semester=="Winter") echo "checked";?>>Winter</input><br>
           
            <br><br>
            
            Search by time of day:
            <br>
             <input type="radio" name="time" id="morning" value="morning"
            <?php $time=$_GET['time'];if (isset($time) && $time=="morning") echo "checked";?>>Morning</input><br>
            
            <input type="radio" name="time" id="afternoon" value="afternoon"
            <?php $time=$_GET['time'];if (isset($time) && $time=="afternoon") echo "checked";?>>Afternoon</input><br>
            <br>
            
            Search by days of week:
            <br>
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
            
            <input id="serach" type="submit" value="Submit"/>
        </form>
        <?php
        include 'functions.php';
        $semester=$_GET['semester'];
        $time = $_GET['time'];
        $days = $_GET['days'];
          echo "<br>";
/*        echo "Semester is: ".$semester;
        echo " isset: ".isset($semester);
        echo "<br>";
        echo "time is: ".$time;
          echo "<br>";
        echo "days is: ".$days;
          echo "<br>";*/
        searchClasses($semester,$time,$days);
        ?>
    </body>
</html>