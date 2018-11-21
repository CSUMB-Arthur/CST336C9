<?php
    session_start();
    include "../lab5/dbconnection.php";
    $conn= getDatabaseConnection("ottermart");
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!--<link href="css/styles.css" rel="stylesheet" type="text/css"/>-->
        <title>Ottermart Admin Login</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    </head>
    <body>
        <h1>Login</h1>
        <div id="login">
            <form method="POST" action="loginProcess.php">
                Username: <input type="text" name="name" class="form-control"><br/>
                Password: <input type="password" name="pass" class="form-control"><br/>
                <input type="Submit" name="submitform" class="btn btn-primary" value="Log in">
                <?php
                if($_SESSION['invalid']){
                    echo "<p class='lead' id='error' style='color:red;'";
                    echo "<strong>Incorrect username or password</strong></p>";
                }
                ?>
            </form>
        </div>
    </body>
</html>