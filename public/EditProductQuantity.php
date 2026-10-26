<?php
require_once "../private/autoloader.php";
session_start();
require_once "../private/managers/checklogin.php";


$product = productmanager::getProductById($_GET["id"]);
$stockInfo = stockchangeManager::getStockChangeById($_GET["id"]);
$userId = $_SESSION["id"];

if ($_POST) {
    $oldstock = $product->amount_in_storage;
    $newStock = $_POST["quantity"];
    $stockChange = $newStock - $oldstock;

    stockchangeManager::insertStockChange($userId, $stockChange, $oldstock, $newStock, date("Y-m-d H:i:s"), $_GET["id"]);
    productmanager::updateAmountInStorageById($newStock, $_GET["id"]);

    header("location: mainscreen-employee.php");
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
</head>

<body>
    <?php include "includes/navbar.php" ?>
    <h1 class="titel"> Aantal van: <?php echo $product->name ?> wijzigen</h1>

    <div class="wrapper">



        <form method="post" class="edit-addform">


            <div class="inputbox">
                <?php if (!empty($product->photo)) { ?>
                    <div id="afbeelding">
                        <img class="product-preview-img" src='<?php echo $product->photo ?>' alt='<?php echo $product->name ?>'>
                    </div>
                    <br>
                <?php } ?>
                Aantal in opslag:
                <div class="quantity-box">
                    <button type="button" class="btn quantity-btn" id="minus">-</button>
                    <input class="input quantity-input" name="quantity" min="0" id="quantity" type="number" value="<?php echo $product->amount_in_storage; ?>" readonly>
                    <button type="button" class="btn quantity-btn" id="plus">+</button>
                </div>
                <br>
            </div>

            <div class="form-footer"><input type='submit' class=" btn opslaanbtn" value="opslaan">
                <?php echo "
        <img  class='product-qr' src='https://quickchart.io/qr?text=EditProductQuantity.php?id=$product->id'></img>"
                ?>
            </div>





        </form>
    </div>

    <script>
        const PlusKnop = document.getElementById("plus");
        const minKnop = document.getElementById("minus");
        const Veldje = document.getElementById("quantity");

        PlusKnop.addEventListener("click", () => {
            Veldje.value = Number(Veldje.value) + 1;
        })

        minKnop.addEventListener("click", () => {
            if (Number(Veldje.value) > 0) {
                Veldje.value = Number(Veldje.value) - 1;
            }
        })
    </script>
</body>

</html>