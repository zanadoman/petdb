<?php
    $user = $_POST["user"];
    $name = $_POST["name"];
    $species = $_POST["species"];
    $img = $_POST["img"];

    $errors = [];
    $file = "db/" . $user . ".txt";
    $entry = $name . ";" . $species . ";" . $img . "\n";

    if (file_exists($file))
    {
        if (!str_contains(file_get_contents($file), $entry))
        {
            file_put_contents($file, file_get_contents($file) . $entry);
        }
    } 
    else
    {
        file_put_contents($file, $entry);
    }

    include_once "dashboard.php";
?>
