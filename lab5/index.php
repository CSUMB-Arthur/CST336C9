<?php
    include "dbconnection.php";
    $conn= getDatabaseConnection("ottermart");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title>Ottermart Product Search</title>
    </head>
    <body>
        <div>
            <h1>OtterMart Product Search</h1>
            
            <form>
                <table id='inputarea'>
                    <tr>
                        <td class="inputdescription">
                            Product
                        </td>
                        <td class="inputs">
                            <input type ="text" name="product"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="inputdescription">
                            Category
                        </td>
                        <td >
                            <select name="category"> 
                            <option value="">Select One</option>
                            <?= displayCategories()?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="inputdescription">
                            Price
                        </td>
                        <td>
                            <input class="priceinputs" type="text" name="priceFrom" size="7" placeholder="min"/> to <input class="priceinputs" type="text" name="priceTo" size="7" placeholder="max"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="inputdescription">
                            Order By
                        </td>
                        <td>
                            <input type="radio" name="orderBy" value="price"/ checked> Price
                            <input type="radio" name="orderBy" value="name"/> Name
                        </td>
                    </tr>
                        
                    <tr>
                        <td colspan="2">
                            <div id='searchwrapper'>
                                <input id='searchbutton' type="submit" name="searchForm" value="Search"/>
                            </div>
                            
                        </td>
                    </tr>
                </table>
                
            </form>
            
            <br/>
            </div>
            <hr>
            <?=displaySearchResults()?>;
        </div>
    </body>
</html>