<?php
session_start();

require_once __DIR__ . '/../private/autoloader.php';
require_once __DIR__ . '/../private/managers/userManager.php';


$Products = productmanager::getAllProducts();
$userId = $_SESSION["id"];
$userInfo = userManager::getUserByID($userId);
$restockError = "";

// verwijderen product
if (isset($_GET["id"])) {
    productmanager::deleteById($_GET["id"]);
    header("location: mainscreen-admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin scherm</title>
    <link rel='stylesheet' href='css/mainscreen-admin.css'>
    <link rel='stylesheet' href='css/shared.css'>
    <script src="main-admin.js" defer></script>
</head>

<body>
    <?php include "includes/navbar.php";
    foreach ($Products as $p) {
        if ($p->minimum_in_storage >= $p->amount_in_storage) {
            $restockError = "<p id='restockerror'>$p->name moet worden bijgevuld!</p>";
            echo "$restockError";
        }
    } ?>

    <div id="productsbox">
        <a class="btn" id="addproductbtn" href='addProduct.php'>Product toevoegen</a>
        <div id="productdiv-wrapper">

            <?php
            foreach ($Products as $p) {
                echo
                "<div class='productdiv'>
                <img class='product-pic' src='$p->photo'>
                <div class='product-eigenschap'> <b> Naam:</b> $p->name<br></div>
                <div class='product-eigenschap'> <b>prijs:</b> €$p->price<br></div>
                <div class='product-eigenschap'><b>aantal:</b> $p->amount_in_storage<br></div>
                <div class='product-eigenschap'><b>minimum:</b> $p->minimum_in_storage<br></div>
                <a class='btn product-editbtn' href='editproduct.php?id=$p->id'>Aanpassen</a>
                <a class='btn product-editbtn' href='productGrafiek.php?id=$p->id'>Statistiek bekijken</a>
                <a class='btn product-deletebtn' href='mainscreen-admin.php?id=$p->id'>X</a>
                <img  class='product-qr' src='https://quickchart.io/qr?text=EditProductQuantity.php?id=$p->id'></img>
             </div>";
            }
            ?>
        </div>
    </div>
    <div id="Bladerknoppenlijst"></div>
</body>

</html>