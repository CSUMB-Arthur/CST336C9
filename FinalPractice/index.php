
<?php
    include "dbconnection.php";
    
    $conn = getDatabaseConnection("finalPractice");
    
    $sql = "SELECT * 
            FROM superheroquiz
            ORDER BY firstName ASC";
            
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $imageCount = count($records);
    //print_r($records);
    $selectedIndex = rand(0,$imageCount-1);
    

    $heroData = $records[$selectedIndex];

    echo "<img src=\"img/superheroes/".$heroData['image'].".png\">";
    echo "<script>";
    echo "var fullName = '".$heroData['firstName']." ".$heroData['lastName']."';";
    echo "</script>";


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Superhero Quiz</title>
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <style>
            @import url("css/styles.css");
            body{
                text-align: center;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    </head>
    <body>
        <?php
            //include 'inc/header.php';
        ?>
        <form>
            <select id="asdf">
            "<option value='-1'>Select a name</option>"
        <?php
        
            foreach ($records as $record){
                $fullName = $record['firstName'] . " " . $record['lastName'];
                echo "<option value='".$fullName."'>".$fullName."</option>";
            }
        ?>
            </select>
            <br/>
            <input id="submit" type="button" value="Submit!">
        </form>
        
        <div id="errorPanel" style="hidden"></div>
        <script>
            
            $("#submit").click(function(e){
                console.log("Button pressed");
                console.log($("#asdf").prop("value"));
                if ($("#asdf").prop("value") == -1){
                    $("errorPanel").css("hidden",false);
                    $("errorPanel").empty();
                    $("errorPanel").append("Invalid selection, please choose a name");
                }
                else{
                    $("errorPanel").css("hidden",true);
                    if (fullName == $("#asdf").prop("value")){
                        console.log("You guessed correctly!");
                    }
                    else{
                        console.log("You guessed Incorrectly!");
                    }
                }
            
            });
            
        </script>
        

        <?php
            //include 'inc/footer.php';
        ?>
    </body>