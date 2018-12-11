<?php
session_start();
include 'dbconnection.php';

$conn=getDatabaseConnection();
$username= $_POST['user_name'];
$password= sha1($_POST['password']);


//Using double quotes prevents injection
$sql="SELECT * FROM administrator 
    WHERE user_name = :user_name 
    AND password = :password";
    
    $np = array();
    $np[":user_name"] = $username;
    $np[":password"] = $password;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $record = $stmt->fetch(PDO::FETCH_ASSOC); 
    
    //checks to see if the admin record exists
    //$_SESSION['user_name'] = $username;
    //$_SESSION['password'] = $password;
    if(empty($record))
    {
        $_SESSION['incorrect']=true;
        header('Location: adminLogin.php');
    }
    else
    {
        $_SESSION['incorrect']=false;
        $_SESSION['admin_name']=$record['user_name'];
        header('Location: admin.php');
    }
    
?>