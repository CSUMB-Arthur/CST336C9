<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Maze Generator </title>
        <?php
            include 'inc/functions.php';
        ?>
        
        <link href="css/styles.css" rel ="stylesheet" type="text/css"/>
        
    </head>
    <body>
<?php
    
    $prevoptions = array(1);
    $validoptions = array(3, 4, 5, 6);
    $prevoptionsindex = count($prevoptions);
    array_pop($prevoptions);
    $validoptionsindex = count($validoptions);
    printf(count($prevoptions));
    /*
    for ($k = 0; $k < 3; $k++){

            
			//Does the exact same thing as the above commented out code
			$temparray = array_diff($prevoptions, $validoptions);
			$tempindex = count($temparray);
			
			$found;
			for ($i = 0; $i < $prevoptionsindex;){
				$found = 0;
				for ($j = 0; $j < $validoptionsindex; $j++){
					if ($prevoptions[$i] == $validoptions[$j]){
						$found = 1;
						break;
					}
				}
				if ($found == 1){
					$prevoptions[$i] = $prevoptions[--$prevoptionsindex];
				}
				else{
					$i++;
				}
			}
			
			print_r($prevoptions);
			echo '<br/>';
			printf($prevoptionsindex);
			echo '<br/>';
			print_r($temparray);
			echo '<br/>';
			printf($tempindex);
			echo '<br/>';
			print_r($validoptions);
			echo '<br/>';
			echo '<br/>';
    }
    */

?>
</body>
</html>