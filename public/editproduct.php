<?php
require_once "../private/autoloader.php";
session_start();
require_once "../private/managers/checklogin.php";


$product = productmanager::getProductById($_GET["id"]);
$categories = categoryManager::getAllCategories();

if ($_POST) {
    $is_admin = isset($_POST["is_admin"]) ? 1 : 0;


    // afbeelding = afbeelding in de database
    if ($product->photo !== null) {
        $productPicture = $product->photo;
    } else {
        $productPicture = "";
    }

    // nieuwe foto geuload zonder fouten
    if (isset($_FILES["Product_picture"]) && $_FILES["Product_picture"]["error"] == 0) {

        // Oude oude foto verwijderen
        if (!empty($productPicture)) { // bestaat foto al?
            $oldFilePath = $productPicture;
            if (file_exists($oldFilePath)) { // als bestaat, verwijder hem
                unlink($oldFilePath);
            }
        }

        // unieke naam maken
        $filename = uniqid() . "_" . basename($_FILES["Product_picture"]["name"]);


        // bestand uploaden naar product_pictures map
        move_uploaded_file(
            $_FILES["Product_picture"]["tmp_name"],
            "Product_pictures/" . $filename
        );

        $productPicture = "Product_pictures/" . $filename;
    }

    // als wachtwoord wordt ingevuld wordt de hash geupdate. 
    // als geen wachtwoord ingevuld wordt huidige ww van database gebruikt

    productmanager::updateProductById($_POST["name"], $_POST["price"], $_POST["amount_in_storage"], $_POST["minimum_in_storage"], $productPicture, $_POST["category_id"], $_GET["id"]);
    header("location: mainscreen-admin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='css/shared.css'>
    <link rel='stylesheet' href='css/edit-addproduct.css'>
    <script src="add-edit.js" defer></script>
</head>

<body>
    <?php include "includes/navbar.php" ?>
    <h1 class="titel"> info van: <?php echo $product->name ?> wijzigen</h1>

    <div class="wrapper">



        <form method="post" class="edit-addform" enctype="multipart/form-data">


            <div class="inputbox">
                Naam:<input class="input" type='text' value='<?php echo $product->name ?>' name='name'><br>
                Prijs:<input class="input" type='number' value='<?php echo $product->price ?>' name='price' min='0'><br>
                Aantal in opslag:<input class="input" type='number' value='<?php echo $product->amount_in_storage ?>' name='amount_in_storage' min='0'><br>
                Minimaal in opslag:<input class="input" type='number' value='<?php echo $product->minimum_in_storage ?>' name='minimum_in_storage' min='0'><br>
                Categorie:<div class="dropdown">
                    <input type="text" class='text-input input' value='<?php echo $product->category ?>' placeholder="kies een categorie" readonly id="dropdownBtn" class="input">

                    <ul id="dropdownMenu">
                        <?php
                        foreach ($categories as $c) {
                            echo "
                <li data-value='$c->id'>$c->name</li>
                ";
                        }
                        ?>
                    </ul>

                    <input type="hidden" name="category_id" id="dropdownValue" value="<?php echo $product->category_id; ?>">
                </div>
                <div class="afbeeldingpicker">
                    <label class="afbeeldingknop" for="Product_picture">Kies een Afbeelding</label>
                    <input type='file' id="Product_picture" name='Product_picture' hidden> <br>
                    <div id="afbeelding">
                        <div id="geenafbeelding">Geen afbeelding</div>
                        <img data-exsists="<?php echo "!empty($product->photo)? true : false" ?>"
                            src='<?php echo $product->photo ?>' id="gekozenbestand">
                    </div>

                </div> <br>
                <div class="form-footer"><input type='submit' class=" btn opslaanbtn" value="opslaan">
                    <?php echo "
        <img  class='product-qr' src='https://quickchart.io/qr?text=EditProductQuantity.php?id=$product->id'></img>"
                    ?>
                </div>





        </form>
    </div>
    <script src='dropdown.js'></script>
</body>

</html>