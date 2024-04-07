<?php
    $user = $_POST["user"];
    $index = $_POST["index"];

    $errors = [];
    $file = "db/" . $user . ".txt";

    if (file_exists($file))
    {
        $content = file_get_contents($file);
        $content = str_replace(explode("\n", $content)[$index] . "\n", "", $content);
        file_put_contents($file, $content);
    }

    include_once "dashboard.php";
?>
