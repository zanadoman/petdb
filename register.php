<?php
    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $errors = [];
    $contents = "";

    if (file_exists("users.txt"))
    {
        $contents = file_get_contents("users.txt");

        foreach (explode("\n", $contents) as $line)
        {
            if (explode(";", $line)[0] === $user)
            {
                $errors[] = "Felhasználónév foglalt";

                break;
            }
        }
    }

    if (count($errors) === 0)
    {
        file_put_contents("users.txt", $contents . $user . ";" . $pwd . "\n");
    }

    include_once "dashboard.php";
?>
