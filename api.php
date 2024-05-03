<?php
    if (!isset($_SESSION["user"])) {
        die("Érvénytelen bejelentkezés");
    }

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        die($conn->connect_error);
    }

    switch ($_SERVER["REQUEST_METHOD"]) {
        case "GET":
           get($conn, $_SESSION["user"]); 
        break;

        case "POST":
            post($conn, $_SESSION["user"], json_decode(file_get_contents("php://input"), true));
        break;

        case "DELETE":
            del($conn, json_decode(file_get_contents("php://input"), true));
        break;

        default:
            http_response_code(405);
            die("Hibás kérés");
    }

    $conn->close();

    function get($conn, $user) {
        $pets = [];

        $result = $conn->query("SELECT * FROM pets WHERE user_name LIKE '$user'");
    
        while ($pet = $result->fetch_assoc()) {
            $pets[] = $pet;
        }

        echo json_encode($pets);
    }

    function post($conn, $user, $pet) {
        $name = $pet["name"];
        $species_id = $pet["species_id"];
        $image = $pet["image"];

        if ($conn->query("INSERT INTO pets (user_name, name, species_id, image)" .
            "VALUES ('$user', '$name', '$species_id', '$image')")) {
            echo("Állat hozzáadva");
        } else {
            http_response_code(500);
            die("Sikertelen hozzáadás");
        }
    }

    function del($conn, $pet) {
        $id = $pet["id"];

        if ($conn->query("DELETE FROM pets WHERE id == $id")) {
            echo("Állat törölve");
        } else {
            http_response_code(500);
            die("Sikertelen törlés");
        }
    }
?>
