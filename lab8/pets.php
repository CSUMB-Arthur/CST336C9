<!DOCTYPE html>
<html>
    <head>
    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <style>
        @import url("css/styles.css");
                
        body{
            text-align: center;
        }
        
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>   


    </head>
    <body>
    <?php
        include 'inc/header.php';
    ?>
    <div id="petListing">
    <?php
        function getPetList(){
            include "dbconnection.php";
            
            $conn = getDatabaseConnection("pets");
            
            $sql = "SELECT * 
                    FROM pets";
                    
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $record;
        }
        
    
        
        $pets = getPetList();
            
        foreach ($pets as $pet){
            echo "<div class='infoGroup'>";
            echo "<img class='animalListImg' src='img/".$pet['pictureURL']."' width='100' height='100'>";
            echo "Name: ";
            echo "<a href='#' class='petLink', id='".$pet['id']."'>".$pet['name']."</a><br/>";
            echo "Type: ". $pet['type']."<br/>";
            echo "<button id='".$pet['id']."' type='button' class='btn btn-primary'>Adopt Me!</button>";
            echo "<hr><br/>";
            echo "</div>";
        }
    ?>
    </div>
    


    
    <div class="modal fade" id="petInfoModal" tabindex='-1' role='dialog' aria-labledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modaltitle' id='petNameModalLabel'></h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div id='petInfo'></div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <?php
            include 'inc/footer.php';
    ?>
    </body>
</html>

<script>
    $(document).ready(function(){
        $(".petLink").click(function(){
            $("#petInfoModal").modal("show");
            $("#petInfo").html("<img src='img/loading.gif'>");
            request = {
                type: "GET",
                url: "api/getPetInfo.php",
                dataType: "json",
                data: {"id":$(this).attr('id')}, //Passed data
                success: function(data,status){
                    console.log(data);
                    //On success, data now refers to the returned values from getPetInfo.php
                    //It can be changed to another variable by changing the anonymous function parameters
                    $("#petInfo").html("<img src='img/"+data.pictureURL+"'><br/>"+
                                        "Age: "+ data.age + "<br>"+
                                        "Breed: " + data.breed + "<br/>"+
                                        data.description);
                    $("#petInfoModalLabel").html(data.name);
                },
                complete: function(data,status){
                    
                }
            }
            
            $.ajax(request);
        });
    });
</script>

