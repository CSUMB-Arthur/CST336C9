
<?php
    session_start();
    include "../lab5/dbconnection.php";

    $conn= getDatabaseConnection("ottermart");
    function getCategories($catId){
        global $conn;
        $sql="SELECT * FROM om_category ORDER BY catName ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($records as $record){
            echo "<option ";
            echo ($record['catId']==$catId)? "selected ":"";
            echo "value='".$record['catId']."'>".ucfirst($record['catName'])."</option>";
        }
    }
    
    function getProductInfo(){
        global $conn;
        $sql="SELECT * FROM om_product WHERE productId = ".$_GET['productId'];
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    
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
                if (!isset($_SESSION['adminName'])){
                    header("Location:login.php");
                }
                global $conn;

                if (isset($_GET['updateProduct'])){
                    
                    $sql= 
                    "UPDATE om_product
                    SET productName = :productName,
                        productDescription = :productDescription,
                        productImage = :productImage,
                        price = :price,
                        catId = :catId
                    WHERE productId = :productId";
                    
                    $np=array();
                    $np[':productName'] = $_GET['productName'];
                    $np[':productDescription'] = $_GET['description'];
                    $np[':productImage'] = $_GET['productImage'];
                    $np[':price'] = $_GET['price'];
                    $np[':catId'] = $_GET['catId'];
                    $np[':productId'] = $_GET['productId'];
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($np);
                    echo "Product updated: ".$_GET['productName'];
                }
                
                if (isset($_GET['productId']) and $_GET['productId']!= ''){
                    $product= getProductInfo();
                    //print_r($product);
                }
                
            ?>
            <form>
                <input type="hidden" name="productId" value="<?=$product['productId']?>"/>
                <strong>Product Name</strong><input type="text" class="form-control" name="productName" value="<?php echo $product['productName'];?>"/><br/>
                <strong>Description</strong><textarea name="description" class="form-control" col="50" rows="4"><?php echo $product['productDescription'];?></textarea><br/>
                <strong>Price</strong><input type="text" class="form-control" name="price" value="<?php echo $product['price'];?>"/><br/>
                <strong>Category</strong><select name="catId" class="form-control">
                    <option value="">Select One</option>
                    <?php getCategories($product['catId'])?>
                </select><br/>
                <strong>Set Img Url</strong><input type="text" name="productImage" class="form-control" value="<?php echo $product['productImage'];?>"/>
                <br/>
                <input type="submit" name="updateProduct" class="btn btn-primary" value="Update Product"/>
            </form>
        </div>
    </body>
</html>