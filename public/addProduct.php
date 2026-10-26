<?php

require_once "../private/autoloader.php";
session_start();

require_once "../private/managers/checklogin.php";
$categories = categoryManager::getAllCategories();

if ($_POST) {


// als file is geupload en geen error
    if ($_FILES["Product_picture"]["error"] == 0) {

        // unieke naam maken

        $filename = microtime() . "_" . $_FILES["Product_picture"]["name"];


        // bestand uploaden naar profile_pictures map
        move_uploaded_file(
            $_FILES["Product_picture"]["tmp_name"],
            "Product_pictures/" . $filename
        );


        $productPicture = "Product_pictures/" . $filename; // pad van profielfoto

        // alles inserten ook profilepicture path

        productmanager::addProduct($_POST["name"], $_POST["price"], $_POST["amount_in_storage"], $_POST["minimum_in_storage"], $productPicture, $_POST["category_id"]);
        header("location: mainscreen-admin.php");
        exit();
    }
    //als geen foto geselecteerd: insert zonder productpicture
    else{
        productmanager::addProduct($_POST["name"], $_POST["price"], $_POST["amount_in_storage"], $_POST["minimum_in_storage"], null, $_POST["category_id"]);
        header("location: mainscreen-admin.php");
        exit();
    }
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
    <h1 class="titel"> Product Toevoegen</h1>

<div class="wrapper">



    <form method="post" class="edit-addform" enctype="multipart/form-data">


    <div class="inputbox">
        Naam:<input class="input" type='text' name='name'><br>
        Prijs:<input class="input"  type='number' name='price' min='0'><br>
        Aantal in opslag:<input class="input"  type='number'  name='amount_in_storage' min='0'><br>
        Minimaal in opslag:<input  class="input" type='number'  name='minimum_in_storage'min='0'><br>
        Categorie:<div class="dropdown">
            <input type="text" class='text-input input'  placeholder="kies een categorie" readonly id="dropdownBtn" class="input">

            <ul id="dropdownMenu">
                <?php
                foreach ($categories as $c) {
                    echo "
                <li data-value='$c->id'>$c->name</li>
                ";
                }
                ?>
            </ul>

            <input type="hidden" name="category_id" id="dropdownValue" > 
            </div>
            <div class="afbeeldingpicker">
              <label class="afbeeldingknop" for="Product_picture">Kies een Afbeelding</label>
              <input type='file' id="Product_picture" name='Product_picture' hidden> <br>
              <div id="afbeelding">
              <div id="geenafbeelding">Geen afbeelding</div>
              <img data-exsists=""
               src='' id="gekozenbestand">
            </div>
        
    </div> <br>
        <div class="form-footer"><input type='submit' class=" btn opslaanbtn" value="opslaan">
     
    </div> 
    

 

      
    </form>
</div>
    <script src='dropdown.js'></script>
</body>

</html>