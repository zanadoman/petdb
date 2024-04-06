<?php
    $user = $_POST["user"];
    $name = $_POST["name"];
    $species = $_POST["species"];

    $errors = [];
    $file = $user . ".txt";
    $entry = $name . ";" . $species . "\n";

    if (file_exists($file))
    {
        file_put_contents($file, file_get_contents($file) . $entry);
    } 
    else
    {
        file_put_contents($file, $entry);
    }

    include_once "dashboard.php";
?>
