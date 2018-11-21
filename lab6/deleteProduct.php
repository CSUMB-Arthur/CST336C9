<?php
    session_start();
    include "../lab5/dbconnection.php";

    $conn= getDatabaseConnection("ottermart");
    
    if (!isset($_SESSION['adminName'])){
        header("Location:login.php");
    }
    else{
        $sql="DELETE FROM om_product WHERE productId = ".$_GET['productId'];
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        header("Location:admin.php");
    }
?>