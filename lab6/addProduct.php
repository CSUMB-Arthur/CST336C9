<?php
    session_start();
    include "../lab5/dbconnection.php";
    if (!isset($_SESSION['adminName'])){
        header("Location:login.php");
    }
    $conn= getDatabaseConnection("ottermart");
    function getCategories(){
        global $conn;
        $sql="SELECT * FROM om_category ORDER BY catName ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($records as $record){
            echo "<option value='".$record['catId']."'>".ucfirst($record['catName'])."</option>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="addupdate">
            <?php
                global $conn;
                if (isset($_GET['productName']) and $_GET['productName']!= ''){
                    $productname= $_GET['productName'];
                    $productdescription= $_GET['description'];
                    $productprice= $_GET['price'];
                    $productcategory= $_GET['catId'];
                    $productimg= $_GET['productImage'];
                    
                    $sql= "INSERT INTO om_product
                    (productName, productDescription, productImage, price, catId)
                    VALUES (:productName, :productDescription, :productImage, :price, :catId)";
                    
                    $np=array();
                    $np['productName'] = $productname;
                    $np['productDescription'] = $productdescription;
                    $np['productImage'] = $productimg;
                    $np['price'] = $productprice;
                    $np['catId'] = $productcategory;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($np);
                    echo "Product added ".$productname;
                }
            ?>
            <form>
                <strong>Product Name</strong><input type="text" class="form-control" name="productName"/><br/>
                <strong>Description</strong><textarea name="description" class="form-control" col="50" rows="4"></textarea><br/>
                <strong>Price</strong><input type="text" class="form-control" name="price"/><br/>
                <strong>Category</strong><select name="catId" class="form-control">
                    <option value="">Select One</option>
                    <?php getCategories()?>
                </select><br/>
                <strong>Set Img Url</strong><input type="text" name="productImage" class="form-control"/>
                <br/>
                <input type="submit" name="submitProduct" class="btn btn-primary" value="Add Product"/>
            </form>
        </div>
    </body>
</html>