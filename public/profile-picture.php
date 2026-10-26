<?php

// dit bestand zorgt ervoor dat we toch profielfoto's uit de private map kunnen lezen
// dit bestand is gewoon een plaatje.
// img src kan je namelijk niet aanroepen uit de private, maar zo'n bestand dus wel

require_once "../private/autoloader.php";

$userId = $_GET["id"];
$user = userManager::getUserByID($userId);

$file = "../private/" . $user->Profile_picture;

var_dump($file);

//header("Content-Type: image/jpeg");
//readfile($file);
