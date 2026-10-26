<?php
require_once "../private/autoloader.php";
session_start();
require_once "../private/managers/checklogin.php";


$currentUserInfo = userManager::getUserByID($_GET["id"]);

if ($_POST) {
    $is_admin = isset($_POST["is_admin"]) ? 1 : 0;


    // profilepicture = profielfoto in de database
    if ($currentUserInfo->Profile_picture !== null) {
        $profilePicture = $currentUserInfo->Profile_picture;
    } else {
        $profilePicture = "";
    }

    // nieuwe foto geuload zonder fouten
    if (isset($_FILES["Profile_picture"]) && $_FILES["Profile_picture"]["error"] == 0) {

        // Oude oude foto verwijderen
        if (!empty($profilePicture)) { // bestaat profielfoto al?
            $oldFilePath = "../private/" . $profilePicture;
            if (file_exists($oldFilePath)) { // als bestaat, verwijder hem
                unlink($oldFilePath);
            }
        }

        // unieke naam maken
        $filename = uniqid() . "_" . basename($_FILES["Profile_picture"]["name"]);


        // bestand uploaden naar profile_pictures map
        move_uploaded_file(
            $_FILES["Profile_picture"]["tmp_name"],
            "../private/Profile_pictures/" . $filename
        );

        $profilePicture = "Profile_pictures/" . $filename;
    }

    // als wachtwoord wordt ingevuld wordt de hash geupdate. 
    // als geen wachtwoord ingevuld wordt huidige ww van database gebruikt

    if (!empty($_POST["password"])) {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    } else {
        $password = $currentUserInfo->password;
    }

    userManager::UpdateUserById($_POST["username"], $_POST["email"], $is_admin, $profilePicture, $password, $_GET["id"]);
    header("location: mainscreen-admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker Bewerken</title>
    <link rel='stylesheet' href='css/shared.css'>
    <link rel='stylesheet' href='css/add-editUser.css'>
    <script src="add-edit.js" defer></script>

</head>

<body>
    <?php include "includes/navbar.php" ?>
    <h2>Gebruiker Bewerken</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="inputbox">
            Gebruikersnaam: <input value="<?php echo $currentUserInfo->username ?>" class="input" type='text' name='username'><br><br>
            Email: <input value="<?php echo $currentUserInfo->email ?>" type='email' class="input" name='email'><br><br>
            Wachtwoord (leeg = ongewijzigd): <input type='password' class="input" name='password'><br><br>
            <div> Admin: <input name='is_admin' type='checkbox' <?php echo ($currentUserInfo->is_admin == 1) ? 'checked' : ''; ?>></div><br><br>
            <div class="afbeeldingpicker">
                <label class="afbeeldingknop" for="Product_picture">Kies een Afbeelding</label>
                <input type='file' id="Product_picture" name='Product_picture' hidden> <br>
                <div id="afbeelding">
                    <div id="geenafbeelding">Geen afbeelding</div>
                    <img data-exsists=""
                        src='' id="gekozenbestand">
                </div>

            </div><br><br>
            <input type='submit' class=" btn opslaanbtn" value='opslaan'>
        </div>
    </form>
</body>

</html>