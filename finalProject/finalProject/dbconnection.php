<?php
    function getDatabaseConnection(){
        $host='localhost';
        $username='csumbarthur';
        $password='';
        
        if (strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
            //$url = parse_url(getenv("mysql://bdcbf0758f5ed3:a0b1ef4d@us-cdbr-iron-east-01.cleardb.net/heroku_3d87761e8bb2af6?reconnect=true"));
            $host = "us-cdbr-iron-east-01.cleardb.net";
            $dbname = "heroku_3d87761e8bb2af6";
            $username = "bdcbf0758f5ed3";
            $password = "a0b1ef4d";
        }

        $dbConn= new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        
        $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $dbConn;
    }
    
?>