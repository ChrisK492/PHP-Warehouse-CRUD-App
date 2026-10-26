<?php

require_once "../private/autoloader.php";

session_start();
require_once "../private/managers/checklogin.php";

$users = userManager::GetAllUsers();

if(isset($_GET["id"])){
    userManager::deleteUserById($_GET["id"]);
    header("location: userOverview.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link rel="stylesheet" href="css/shared.css">
   <link rel="stylesheet" href="css/overvieuwUsers.css">
</head>

<body>
        <?php include "includes/navbar.php" ?>
    <div id="usersbox">
        <h1>Gebruikers</h1>
    <a  class="btn adduserbtn" href='addUser.php'>Gebruiker toevoegen</a>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Gebruikersnaam</th>
                <th scope="col">Email-adres</th>
                <th scope="col">Admin</th>
                <th scope="col">profiel-Foto</th>
                <th scope="col">Beheer</th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $u) {
                $is_admin = $u->is_admin === 1 ? "Ja": "Nee";

                echo
                "
                    <tr>
                    <td>$u->id</td>
                    <td>$u->username</td>
                    <td>$u->email</td>
                    <td>$is_admin</td>
                    <td><img id='profile-pic' src='profile-picture.php?id=$u->id'></td>
                    <td><a class='btn editbtn' href='editUser.php?id=$u->id'>...</a> 
                    <a class='btn deletebtn' href='userOverview.php?id=$u->id'>X</a></td>
                  
                    </tr>
                    ";
            }
            ?>
    </table>
</div>
</body>

</html>