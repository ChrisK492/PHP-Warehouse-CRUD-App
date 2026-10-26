
<?php

// Databaseverbinding inladen vanuit dezelfde map als autoloader.php
require_once __DIR__ . "/database.php";

// Mappen waarin PHP naar classes moet zoeken
$folders = [
    __DIR__,
    __DIR__ . "/managers/"
];

// Classes automatisch inladen
spl_autoload_register(function ($class_name) use ($folders) {

    foreach ($folders as $folder) {
        $file = $folder . "/" . $class_name . ".php";

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
