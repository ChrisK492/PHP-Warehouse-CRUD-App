<?php

session_start();

require_once "../private/autoloader.php";
require_once "../private/managers/checklogin.php";

$userId = $_SESSION["id"];
$userInfo = userManager::getUserByID($userId);
$username = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='css/mainscreen-employee.css'>
    <link rel='stylesheet' href='css/shared.css'>
</head>

<body>

      <?php include "includes/navbar.php" ?>

    <h2>Welkom <?php echo " $username "?></h2>
    <p>Scan een product om te beginnen</p>
    <div id="reader">
    </div>



    <script src='libraries/html5-qrcode.min.js'></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            console.log(decodedText);

            // voorbeeld
            document.location.href = decodedText;
        }

        let config = {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            },
            rememberLastUsedCamera: true,
            // Only support camera scan type.
            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
        };

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", config, /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess);
    </script>

</body>

</html>