<?php
    function getDatabaseConnection($dbname='ottermart'){
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
    
    function displayCategories(){
        global $conn;
        
        $sql = "SELECT catID, catName FROM om_category ORDER BY catName";
        $stmt = $conn->prepare($sql);
        $stmt-> execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record){
            //echo "<option value='$record['catid']'>$record['catName']</option>";
            echo "<option value='" . $record['catid'] . "'>" . $record['catName'] . "</option>";
        }
    }
    
    function displaySearchResults(){
        global $conn;
        if (isset($_GET['searchForm'])){
            echo "<h3 id='returnmessage'>Products Found:</h3>";
            $namedParams = array();
            
            $sql="SELECT * FROM  om_product WHERE 1";
            
            if (!empty($_GET['product'])){
                $sql .= " AND productname LIKE :productname";
                $namedParams[":productname"] =  "%". $_GET['product'] ."%";
            }
            
            if (!empty($_GET['priceFrom'])){
                $sql .= " AND price >= :priceFrom";
                $namedParams[":priceFrom"] =  $_GET['priceFrom'];
            }
            
            if (!empty($_GET['priceTo'])){
                $sql .= " AND price <= :priceTo";
                $namedParams[":priceTo"] =  $_GET['priceTo'];
            }
            
            if (isset($_GET['orderBy'])){
                if ($_GET['orderBy'] == "price"){
                    $sql .= " ORDER BY price";
                }
                else{
                    $sql .= " ORDER BY productName";
                }
            }
            
            $stmt =$conn->prepare($sql);
            $stmt ->execute($namedParams);
            $records = $stmt-> fetchAll(PDO::FETCH_ASSOC);
            
            foreach($records as $record){
                echo "<div class='itemblock'>";
                echo "<span class='item'>".$record["productName"] . " " . $record["recordDescription"] . "</span>"."<a class='history' href=\"purchasehistory.php?productId=".$record['productId']."\">(History)</a> "."<br/> <span class='itemprice'>$" . $record["price"] . "</span><br/><br/>";
                echo "</div>";
            }
        }
        else{
            echo "<h3 id='returnmessage'>Type in a search entry</h3>";
        }
    }
?>