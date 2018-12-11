<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
        <style>
            @import url("css/styles.css");
        </style>
    </head>
    <body style="text-align:center;">
         <div class="topbar">
          
                <h1 class="left">Cloud5 College</h1>
                <img class="right" src= "img/cloud5logo.png" class="image-rounded" alt="cloud5 logo"></img>
            
            <hr width="100%">
            <br>
        </div>
        <div class="bottombar">
            <h1>Administrator Login</h1>
        </div id="formbuttons">
            <form  method="POST" action="loginProcess.php">
            Username: <input type="text" name="user_name"/><br/><br>
            Password: <input type="password" name="password"/><br/><br>
            <!--<input type="submit" name="submitForm" value="Login!"/>-->
            <button type="submit" class="btn btn-primary btn btn-lg">Login</button>
            <br><br>
            <?php
                if($_SESSION['incorrect'])
                {
                    echo "<p class='lead' id='error' style='color:red'>";
                    echo "<strong>Incorrect Username or Password!</strong></p>";
                }
                
                if(isset($_SESSION['user_name'])){
                    echo "<h1>".$_SESSION['user_name']. "</h1>";
                }
                if(isset($_SESSION['password'])){
                    echo "<h1>".$_SESSION['password']. "</h1>";
                }
            ?>
        </form>
</body>
</html>