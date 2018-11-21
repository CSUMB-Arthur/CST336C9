<?php
    session_start();
    include "../lab5/dbconnection.php";
    $conn= getDatabaseConnection("ottermart");
    $username = $_POST['name'];
    $password = sha1($_POST['pass']);
    $sql = "SELECT *
    FROM om_admin
    WHERE username = :user
    AND password = :pass";
    $np = array();
    $np[':user'] = $username;
    $np[':pass'] = $password;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (empty($record)){
        $_SESSION['invalid'] = true;
        //echo("Login unsuccessful");
        header("Location:login.php");
    }
    else{
        $_SESSION['invalid'] = false;
        $_SESSION['adminName'] = $record['firstName']." ".$record['lastName'];
        //echo("Login successful");
        header("Location:admin.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!--<link href="css/styles.css" rel="stylesheet" type="text/css"/>-->
        <title>Login Page</title>
    </head>
    <body>
        <h1></h1>

    </body>
</html>