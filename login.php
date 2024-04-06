<?php
    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $errors = []; 
    $found = false;

    if (file_exists("users.txt"))
    {
        foreach (explode("\n", file_get_contents("users.txt")) as $line)
        {
            $fields = explode(";", $line);

            if ($fields[0] === $user)
            {
                $found = true;

                if ($fields[1] !== $pwd)
                {
                    $errors[] = "Hibás jelszó";
                }

                break;
            }
        }
    }

    if (!$found)
    {
        $errors[] = "Hibás felhasználónév";
    }

    include_once "dashboard.php";
?>
