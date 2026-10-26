<?php


require_once "../private/autoloader.php";
session_start();

require_once "../private/managers/checklogin.php";
if ($_POST) {
    $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $is_admin = isset($_POST["is_admin"]) ? 1 : 0;


    // als profielfoto geupload en geen error:
    if ($_FILES["Profile_picture"]["error"] == 0) {

        // unieke naam maken

        $filename = microtime() . "_" . $_FILES["Profile_picture"]["name"];

        // bestand uploaden naar profile_pictures map
        move_uploaded_file(
            $_FILES["Profile_picture"]["tmp_name"],
            "../private/Profile_pictures/" . $filename
        );


        $profilePicture = "Profile_pictures/" . $filename; // pad van profielfoto

        // alles inserten ook profilepicture path
        userManager::InsertUser($_POST["username"], $_POST["email"], $is_admin, $profilePicture, $passwordHash);

        header("location: mainscreen-admin.php");
        exit();
        // anders, profielfoto niet gekozen
    } else {
        userManager::InsertUser($_POST["username"], $_POST["email"], $is_admin, null, $passwordHash);
        header("location: mainscreen-admin.php");
    }
}

// als geen file geselecteerd is
// alles inserten zonder profilepicture











?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker Toevoegen</title>
    <link rel='stylesheet' href='css/shared.css'>
    <link rel='stylesheet' href='css/add-editUser.css'>
        <script src="add-edit.js" defer></script>

</head>

<body>
      <?php include "includes/navbar.php" ?>
    <h2>Gebruiker toevoegen</h2>
    <form method="post" enctype="multipart/form-data">
          <div class="inputbox">
        Gebruikersnaam:<input type='text' class="input" name='username'><br><br>
        Email<input type='email' class="input" name='email'><br><br>
        Wachtwoord<input type='password' class="input" name='password'><br><br>
      <div>  Admin <input name='is_admin' type='checkbox'></div><br><br>
         
         <div class="afbeeldingpicker">
              <label class="afbeeldingknop" for="Product_picture">Kies een Afbeelding</label>
              <input type='file' id="Profile_picture" name='Profile_picture' hidden> <br>
              <div id="afbeelding">
              <div id="geenafbeelding">Geen afbeelding</div>
              <img data-exsists=""
               src='' id="gekozenbestand">
            </div>
        
    </div><br><br>
        <input type='submit'class=" btn opslaanbtn" value='opslaan'>
     </div>
    </form>

</body>

</html>