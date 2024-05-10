<?php
    session_start();

    if (!isset($_SESSION["user"]) || $_SESSION["user"] == null) {
        $_SESSION["error"] = "Érvénytelen munkamenet";
        header("Location: error.php");
        exit;
    }

    try {
        $conn = new mysqli("localhost", "root", "12345678", "petdb");
    } catch (Exception $e) {
        $_SESSION["error"] = "Adatbázis hiba";
        header("Location: error.php");
        exit;
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            get_pets($conn);
            header("Location: dashboard.php");
        exit;

        case "POST":
            new_pet($conn);
            header("Location: dashboard.php");
        exit;

        case "DELETE":
            delete_pet($conn);
        exit;

        default:
            $_SESSION["error"] = "Hibás kérés";
            header("Location: error.php");
        exit;
    }

    function get_pets($conn) {
        $user = $_SESSION["user"];
        $_SESSION["pets"] = [];
        $_SESSION["species"] = [];

        try {
            $result = $conn->query(
                "SELECT pets.id, pets.name, species.name AS species, pets.image " . 
                "FROM pets INNER JOIN species ON pets.species_id = species.id " . 
                "WHERE user_name LIKE '$user'"
            );
        } catch (Exception $e) {
            $_SESSION["error"] = "Adatbázis hiba";
            header("Location: error.php");
            exit;
        }

        while ($pet = $result->fetch_assoc()) {
            $_SESSION["pets"][] = $pet;
        }

        try {
            $result = $conn->query("SELECT * FROM species");
        } catch (Exception $e) {
            $_SESSION["error"] = "Adatbázis hiba";
            header("Location: error.php");
            exit;
        }

        while ($species = $result->fetch_assoc()) {
            $_SESSION["species"][] = $species;
        }
    }

    function new_pet($conn) {
        $user_name = $_SESSION["user"];
        $name = $_POST["name"];
        $species_id = $_POST["species_id"];
        $image = $_POST["image"];

        try {
            $conn->query("INSERT INTO pets (user_name, name, species_id, image) " . 
                         "VALUES ('$user_name', '$name', '$species_id', '$image')");
        } catch (Exception $e) {
            $_SESSION["error"] = "Adatbázis hiba";
            header("Location: error.php");
            exit;
        }
    }

    function delete_pet($conn) {
        $id = $_GET["id"]; 

        try {
            $conn->query("DELETE FROM pets WHERE id = $id");
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
        }
    }
?>
