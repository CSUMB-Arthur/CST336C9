<?php
    function displaySymbol($r, $idnum){

        switch($r){
            case 0:
                $symbol = "seven";
                break;
            case 1:
                $symbol = "cherry";
                break;
            case 2:
                $symbol = "lemon";
                break;
            case 3:
                $symbol = "bar";
                break;
        }
        echo "<img id='reel$idnum' src='img/$symbol.png' alt='$symbol' title=". ucfirst($symbol) ." width='70'/>";
    }
    function displayPoints($r1, $r2, $r3){
        echo "<div id='output'>";
        if ($r1 == $r2 && $r1 == $r3){
            switch ($r1){
                case 0:
                    $totalpoints = 1000;
                    echo "<h1>Jackpot!</h1>";
                    break;
                case 1:
                    $totalpoints = 500;
                    break;
                case 2:
                    $totalpoints = 250;
                    break;
                case 3:
                    $totalpoints = 900;
                    break;
            }
            echo "<h2>You've won $totalpoints points</h2>";
        } else{
            echo "<h3> Try again!</h3>";
        }
        echo "</div>";
    }
    function play(){
        for ($i = 1; $i < 4; $i++){
            ${"randval".$i}=rand(0,3);
            displaySymbol(${"randval".$i},$i);
        }
        displayPoints($randval1, $randval2, $randval3);
    }
?>