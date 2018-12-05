<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> CSUMB: Pet Shelter </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    </head>
    <body>
        <?php
            include 'inc/header.php';
        ?>

        <?php
            include "dbconnection.php";
            
            $conn = getDatabaseConnection("pets");
            
            $sql = "SELECT pictureURL 
                    FROM pets";
                    
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            $petURLs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $imageCount = count($petURLs);
            if ($imageCount > 7){
                $imageCount = 7;
            }
            $imageURLs = array();
            foreach ($petURLs as $array){
                array_push($imageURLs,$array['pictureURL']);
            }

        ?>
<div style="width:500px; margin:0 auto;">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
            <?php
            
                for ($i=0; $i<$imageCount;$i++){
                    echo "<li data-target=\"#carouselWithIndicators\" data-slide-to='$i'";
                    echo  ($i==0)?" class=\"active\"":"";
                    echo "></li>\n";
            
                }
            
            ?>
      </ol>
      <div class="carousel-inner" style=" width:100%; height: 500px !important;">
                        <?php
                            
                                //Display carousel
                            $maxindex = $imageCount-1;
                            for ($i = 0; $i < $imageCount; $i++){
                                $randomIndex = rand(0,$maxindex);
                
                                echo "<div class='carousel-item";
                                echo ($i== 0)?" active":"";
                                echo "'>";
                                echo "<img class=\"d-block w-100\" src=\"img/" . $imageURLs[$randomIndex] . "\"/>";
                                echo "</div>\n";
                                
                                $imageURLs[$randomIndex] = $imageURLs[$maxindex];
                                $maxindex--;
                            
                            }
                            
                            
                        ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
</div>
        
        <br/><br/>
            <a class='btn btn-outline-primary' href="pets.php" role="button">Adopt Now!</a>
        <br/><br/>
        <hr/>

        <?php
            include 'inc/footer.php';
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>