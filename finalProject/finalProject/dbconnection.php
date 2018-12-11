<?php
    function getDatabaseConnection(){//$dbname){
        $host='localhost';
        $username='wibaker';
        $password='';
        $dbname = 'final_project';
        /* Figure out who should host the final DB on heroku first
        if (strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
            //$url = parse_url(getenv());
            $host = 
            $dbname = 
            $username = 
            $password = 
        }
        */
        $dbConn= new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        
        $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $dbConn;
    }
    
?>