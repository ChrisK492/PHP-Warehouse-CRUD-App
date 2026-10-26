<?php
session_start();

require_once "../private/autoloader.php";
require_once "../private/managers/checklogin.php";

if (!isset($_SESSION["id"])) {
    header("location: index.php");
    exit();
}

$productId = (int)($_GET['id'] ?? 0);
$offset    = (int)($_GET['week'] ?? 0);

$chart = ChartsManager::MakeProductChart($productId, $offset);

$Products = productmanager::getAllProducts();
$userId = $_SESSION["id"];
$userInfo = userManager::getUserByID($userId);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel='stylesheet' href='css/mainscreen-admin.css'>
    <link rel='stylesheet' href='css/shared.css'>
    <link rel="stylesheet" href="css/grafiekStyle.css">
    <script src="main-admin.js" defer></script>
    <script src="https://cdn.plot.ly/plotly-4.0.0.min.js" charset="utf-8"></script>
</head>

<body>
    <?php include "includes/navbar.php" ?>
    
    <div class="buttonsContainer">
        <div class="buttonContainer">
            <a class="buttonWeek" href="?id=<?= $productId ?>&week=<?= $offset - 1 ?>">&laquo; Vorige week</a>
        </div>

        <div class="buttonContainer">
            <a class="buttonWeek" href="?id=<?= $productId ?>&week=<?= $offset + 1 ?>">Volgende week &raquo;</a>
        </div>
    </div>
    <div class="myPlot" id="myPlot"></div>

    <script>
        const xArray = <?= json_encode($chart['x']) ?>;
        const yArray = <?= json_encode($chart['y']) ?>;

        const data = [{
            x: xArray,
            y: yArray,
            mode: "lines+markers",
            type: "scatter"
        }];

        const layout = {
            title: "Voorraadwijzigingen per week",
            xaxis: {
                title: "Datum"
            },
            yaxis: {
                title: "Verandering in voorraad"
            }
        };

        Plotly.newPlot("myPlot", data, layout);
    </script>
</body>

</html>