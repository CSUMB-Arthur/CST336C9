<?php
    session_start();
    if (isset($_POST['removeId'])){
        foreach ($_SESSION['cart'] as $itemKey => $item){
            if ($item['class_id'] == $_POST['removeId']){
                unset($_SESSION['cart'][$itemKey]);
            }
        }
    }
    function displayCartCount(){
        echo count($_SESSION['cart']);
    }
    
    function displayCart(){
        if (isset($_SESSION['cart'])){
            echo "<table class='table'>";
            $total = 0;
            foreach ($_SESSION['cart'] as $item){
                $class_id = $item['class_id'];
                $course_name = $item['course_name'];
                $semester = $item['semester'];
                $days_of_week = $item['days_of_week'];
                $time = $item['time'];
                $start_date = $item['start_date'];
                $room_number = $item['room_number'];
                $number_of_units = $item['number_of_units'];
                $cost = $item['cost'];
                
                // Display item as table row
                echo '<tr>';
                echo "<td><h4>$course_name</h4></td>";
                echo "<td><h4>$semester</h4></td>";
                echo "<td><h4>$days_of_week</h4></td>";
                echo "<td><h4>$time</h4></td>";
                echo "<td><h4>$start_date</h4></td>";
                echo "<td><h4>$room_number</h4></td>";
                echo "<td><h4>$number_of_units</h4></td>";
                echo "<td><h4>$$cost</h4></td>";
                //Update form for this item
                echo'<form method="post">';
                echo"<input type = 'hidden' name='removeId' value = '$class_id'>";
                echo "<td><button class='btn btn-danger'>Remove</button></td>";
                echo"</form>";
                
                echo "</tr>";
                $total += $cost;
            }
            echo "<tr><td><h4>Subtotal :</h4></td><td><h4>$$total</h4></td></tr>";
            echo "<tr><td><h4>Campus Fee (2%) :</h4></td><td><h4>$" . $total * .02 . "</h4></td></tr>";
            echo "<tr><td><h4>Total :</h4></td><td><h4>$". $total *1.02 . "</h4></td></tr>";
            echo "</table>";
        }
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
        <title>Shopping Cart</title>
    </head>
    <body>
        <div class='container'>
            <div class='text-center'>
                
                <!-- Bootstrap Navagation Bar -->
                <nav class='navbar navbar-default - navbar-fixed-top'>
                    <div class='container-fluid'>
                        <div class='navbar-header'>
                            <a class='navbar-brand' href='#'>Registration</a>
                        </div>
                        <ul class='nav navbar-nav'>
                            <li><a href='index.html'>Home</a></li>
                            <li><a href='student.php'>Courses</a></li>
                            <li><a href='scart.php'>
                            <span class = 'glyphicon glyphicon-shopping-cart' aria-hidden ='true'></span>
                            Cart: <?=displayCartCount()?></a></li>
                        </ul>
                    </div>
                </nav>
                <br /> <br /> <br />
                <h2>Shopping Cart</h2>
                <!-- Cart Items -->
                <?php
                    displayCart();
                ?>
            </div>
        </div>
    </body>
</html>