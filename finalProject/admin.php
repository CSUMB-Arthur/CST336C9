<?php
    session_start();
    //takes user back to login.php if admin name is not set (in case they find this url without loggin in)
    if (!isset($_SESSION['admin_name'])){
        header("Location:adminLogin.php");
    }

    include "dbconnection.php";
    $conn = getDatabaseConnection("final_project");
    
    function displayClassesAdmin(){
        global $conn;
        $sql="SELECT * FROM class JOIN course ON class.course_id = course.course_id ORDER BY class.start_date";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($np);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //$keys = array_keys($records[0]);
        $keys = ["class_id","course_id","room_number","time","days_of_week","start_date","semester"];
        echo "<table id='adminClassDisplay' class='table table-striped'>";
        echo "<tr style='font-weight: bold;'>";
        foreach ($keys as $key){
            echo "<td>".$key."</td>";
        }
            echo "<td>course_name</td>";
            echo "<td>edit</td>";
            echo "<td>delete</td>";
        echo "</tr>";
        foreach ($records as $record){
            echo "<tr>";
            foreach($keys as $key){
                echo "<td>".$record[$key]."</td>";
            }
            //<a class='btn btn-primary' href='updateProduct.php?productId=".$record['course_name']."'>Update</a>
                echo "<td><input class='btn' type='button' value='".$record['course_name']."'></td>";
                echo "<td><a id='classId".$record['class_id']."'class='editbtn btn btn-primary' >Edit</a></td>";
                
                echo "<form action='php/deleteClass.php' onsubmit='return confirmDelete()'>";
                    echo "<input type='hidden' name='classId' value='".$record['class_id']."' />";
                    echo "<td> <input type='submit' class='btn btn-danger' value='Remove'></td>";
                echo "</form>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
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
<script>
    function flickerRow(rowEle){
        /*global editedRow*/
        /*global colorizedRows*/
        /*global colorizeInterval*/
        
        var originalColor = rowEle.css("background-color");
        rowEle.css("background-color","rgba(255,255,0,255)");
        var RGBTarget = originalColor.replace(/[^0-9,]/g,'').split(",");
        if (RGBTarget.length == 4){
                originalColor = $("body").css("background-color");
                RGBTarget = originalColor.replace(/[^0-9,]/g,'').split(",");
        }
        
        var RGBStart = rowEle.css("background-color").replace(/[^0-9,]/g,'').split(",");

        for (var i = 0; i < 3; i++){
            RGBTarget[i] = parseInt(RGBTarget[i]);
            RGBStart[i] = parseInt(RGBStart[i]);
            
        }
        //console.log(RGBStart);
        //console.log(RGBTarget);
        //console.log("Original color Str: "+originalColor);
        
        colorizedRows.push({"rowElement":rowEle,"RGBStart":RGBStart,"RGBTarget":RGBTarget,"MaxTicks":20,"CurrentTicks":0});
        if (colorizeInterval == null){
            colorizeInterval = setInterval(function(){
                for(var rowObj of colorizedRows){
                    //console.log("Ticks: "+rowObj.CurrentTicks);
                    if (rowObj.CurrentTicks <= rowObj.MaxTicks){
                        //var colorStr = rowObj.rowElement.css("background-color");
                        //var RGB = colorStr.replace(/[^0-9,]/g,'').split(",");
                        var RGBCurrent = [];
                        var t = rowObj.CurrentTicks/(1.0*rowObj.MaxTicks);
                        //console.log(t);
                        RGBCurrent.push(parseInt(rowObj.RGBStart[0] + t*(rowObj.RGBTarget[0]-rowObj.RGBStart[0])));
                        RGBCurrent.push(parseInt(rowObj.RGBStart[1] + t*(rowObj.RGBTarget[1]-rowObj.RGBStart[1])));
                        RGBCurrent.push(parseInt(rowObj.RGBStart[2] + t*(rowObj.RGBTarget[2]-rowObj.RGBStart[2])));
                        //console.log(RGBCurrent);
                        rowObj.rowElement.css("background-color","rgba("+RGBCurrent[0]+","+RGBCurrent[1]+","+RGBCurrent[2]+",255)");
                        
                        //console.log(rowObj.rowElement.css("background-color"));
                        rowObj.CurrentTicks++;
                    }
                    else{
                        colorizedRows.shift();
                    }
                    
                }
                if (colorizedRows.length == 0){
                    //console.log("All Flickers Completed, stopping interval");
                    clearInterval(colorizeInterval);
                    colorizeInterval = null;
                }
            },40);
        }
    }
    function getCourses(){
        var request = {
            type: "POST",
            url: "api/getClassCourseInfo.php",
            dataType: "json",
            data: '', 
            success: function(data,status){
                console.log("course data retrieved");
                courses = data;
                
            },
            complete: function(data,status){
                
            }
        }
        
        $.ajax(request);
    }
</script>
<!DOCTYPE html>
<html>
    <title>Admin Page</title>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
        <style>
            @import url("css/styles.css");
        </style>
        <script>
            function confirmDelete(){
                return confirm("Are you sure you want to delete this class?");
            }
        </script>
    </head>
    <body>
       <div class="topbar">
          
                <h1 class="left">Cloud5 College</h1>
                <img class="right" src= "img/cloud5logo.png" class="image-rounded" alt="cloud5 logo"></img>
            
            <hr width="100%">
            <br>
        </div>
        <div class="bottombar">
            <h1>You are logged in as an Administrator</h1>
            <form action='logout.php'>
                <input type='submit' class= 'btn btn-secondary' name='logout' value='Log out' />
            </form>
        </div>
        
        <div class="modal fade" id="adminInfoModal" tabindex='-1' role='dialog' aria-labledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                        <h3 class='modaltitle' id='adminModalLabel'></h3>
                    </div>
                    
                    <div class='modal-body'>
                        <div id='classInfo'>
                            <table>
                                <tr>
                                    <td>Semester: </td>
                                    <td class='classInfoInput'><input type='textfield' id='classSemesterInfo'></td>
                            
                                    <td>Starting Date: </td>
                                    <td class='classInfoInput'><input type='textfield' id='classStartDateInfo'></td>
                                </tr>
                                <tr>
                                    <td>Room Number: </td>
                                    <td class='classInfoInput'><input type='textfield' id='roomNumberInfo'></td>
                            
                                    <td>Days of the Week: </td>
                                    <td class='classInfoInput'><input type='textfield' id='classDaysInfo'></td>
                                </tr>
                                <tr>
                                    <td>Starting Time: </td>
                                    <td class='classInfoInput'><input type='textfield' id='classStartTimeInfo'></td>
                                    
                                    <td>Course: </td>
                                    <td class='classInfoInput'><select type='textfield' id='classCourseInfo'></select></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class='modal-footer'>
                        <button id='updateClassBtn' type='button' class='btn btn-secondary' data-dismiss='modal'>Update</button>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        /*global $*/
            var courses
            var editedRow;
            var colorizedRows = [];
            var colorizeInterval = null;
            $(document).ready(function(){
                courses = getCourses();
                $(".editbtn").click(function(){
                    //console.log("Button clicked: "+$(this).attr('id'));
                    //$(this).
                    editedRow = $(this).parent().parent();
                    console.log(editedRow.css("background-color"));
                    $("#adminInfoModal").modal("show");
                    //$("#classInfo").html("<img src='img/loading.gif'>");
                    
                    var request = {
                        type: "GET",
                        url: "api/getClassInfo.php",
                        dataType: "json",
                        data: {"concatId":$(this).attr('id')}, //Passed data
                        success: function(data,status){
                            //console.log(data);
                            $("#adminModalLabel").html("Class Id "+data[0].class_id);
                            $("#roomNumberInfo").attr("value",data[0].room_number);
                            $("#classDaysInfo").attr("value",data[0].days_of_week);
                            $("#classStartTimeInfo").attr("value",data[0].time);
                            $("#classSemesterInfo").attr("value",data[0].semester);
                            $("#classStartDateInfo").attr("value",data[0].start_date);
                            $("#classCourseInfo").empty();
                            
                            $("#classCourseInfo").append("<option value='"+data[0].course_id+"' selected>"+data[0].course_name+"</option>");
                            for (var course of data[1]){
                                if (course.course_id != data[0].course_id){
                                    $("#classCourseInfo").append("<option value='"+course.course_id+"'>"+course.course_name+"</option>");
                                }
                            }

                        },
                        complete: function(data,status){
                            
                        }
                    }
                    
                    $.ajax(request);
                    
                });
                
                /*global flickerRow*/
                
                $("#updateClassBtn").click(function(e){
                    var updatedData = {};
                    updatedData[':id'] = $("#adminModalLabel").html().slice(9);
                    updatedData[':room_number'] = $("#roomNumberInfo").prop("value");
                    updatedData[':days_of_week'] = $("#classDaysInfo").prop("value");
                    updatedData[':time'] = $("#classStartTimeInfo").prop("value");
                    updatedData[':semester'] = $("#classSemesterInfo").prop("value");
                    updatedData[':start_date'] = $("#classStartDateInfo").prop("value");
                    updatedData[':course_id'] = $("#classCourseInfo :selected").prop("value");
                    updatedData[':course_name'] = $("#classCourseInfo :selected").html();
                    //console.log("Course name: "+updatedData[':course_name']);
                    //console.log("Updating class info: ");
                    //console.log(updatedData);
                    var url = "api/updateClass.php"
                    if ($("#adminModalLabel").html() == "Add Class"){
                        console.log("Adding class");
                        url = "api/addClass.php";
                    }
                    var request = {
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: updatedData, //Passed data
                        success: function(data,status){
                            console.log("success");
                            console.log(data);
                            if (data['type'] == "add"){
                                console.log("Update type: add");
                                //Add new row here, without querying the database.
                                alert("Class added, refresh page to view.");
                                /*
                                var row = $("#adminClassDisplay tr:first");
                                row = row.next();
                                row.after("<tr></tr>");
                                console.log(row);
                                for (var i = 0; i < 10; i++){
                                    row.append("<td></td>");
                                }
                                var cols = row.children();
                                //console.log(cols);
                                //console.log(data);
                                cols[0].innerHTML = data['addedId'];
                                flickerRow(row);
                                cols[8].innerHTML = "<a id='classId"+data['addedId']+"'class='editbtn btn btn-primary' >Edit</a>";
                                cols[9].innerHTML = "<form action='deleteClass.php' onsubmit='return confirmDelete()'>"+
                                "<input type='hidden' name='classId' value='"+data['addedId']+"' />"+
                                "<td> <input type='submit' class='btn btn-danger' value='Remove'></td>"+
                                "</form>";
                                */
                            }
                            else{
                                console.log("Update type: update");
                                var cols = editedRow.children();
                                flickerRow(editedRow);
                            }

                            cols[1].innerHTML = data[':course_id']
                            cols[2].innerHTML = data[':room_number'];
                            cols[3].innerHTML = data[':time'];
                            cols[4].innerHTML = data[':days_of_week'];
                            cols[5].innerHTML = data[':start_date'];
                            cols[6].innerHTML = data[':semester'];
                            cols[7].innerHTML = "<input class='btn' type='button' value='"+data[':course_name']+"'>";
                            
                            
                        },
                        complete: function(data,status){
                            
                        }
                    }
                    
                    $.ajax(request);
                    
                });
                
                $(".addclassbtn").click(function(){
                    //console.log("Button clicked: "+$(this).attr('id'));
                    //$(this).
                    //editedRow = $(this).parent().parent();
                    //console.log(editedRow.css("background-color"));
                    $("#adminInfoModal").modal("show");
                    $("#adminModalLabel").html("Add Class");
                    
                    $("#roomNumberInfo").attr("value",'');
                    $("#classDaysInfo").attr("value",'');
                    $("#classStartTimeInfo").attr("value",'');
                    $("#classSemesterInfo").attr("value",'');
                    $("#classStartDateInfo").attr("value",'');
                    $("#classCourseInfo").empty();
                    

                    //Eventually add value 'courses', which is retrieved via query.
                    for (var course of courses){
                        $("#classCourseInfo").append("<option value='"+course.course_id+"'>"+course.course_name+"</option>");
                    }
                    //$("#classCourseInfo").firstchild().prop('selected', true);
                       
                    
                });
        });
        </script>
        <a id='addClass' class='addclassbtn btn btn-primary' >Add Class</a>

        
    
        <!--<a id='addCourse' class='addcoursebtn btn btn-primary' >Add Course</a> -->
        <?php
        //TODO: create modal that opens when a course button is clicked, that displays the details of the course.
            displayClassesAdmin();
        ?>
        <br>
        <h1><center>Admin Reports</center></h1>
        <br><br>
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
        <br>
        <script src="js/reports.js"></script>
    </body>
</html>