<?php
    session_start();

    if (!isset($_SESSION["user"]) || $_SESSION["user"] == null) {
        $_SESSION["error"] = "Érvénytelen munkamenet";
        header("Location: error.php");
        exit;
    }

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        $_SESSION["error"] = "Adatbázis hiba";
        header("Location: error.php");
        exit;
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            get_pets($conn);
        break;

        case "POST":
            if (isset($_POST["post"])) {
                new_pet($conn);
            } elseif (isset($_POST["delete"])) {
                delete_pet($conn);
            } else {
                $_SESSION["error"] = "Hibás kérés";
                header("Location: error.php");
                exit;
            }
        break;

        default:
            $_SESSION["error"] = "Hibás kérés";
            header("Location: error.php");
        exit;
    }

    $conn->close();
    header("Location: dashboard.php");

    function get_pets($conn) {
        $user = $_SESSION["user"];
        $_SESSION["pets"] = [];
        $_SESSION["species"] = [];

        $result = $conn->query(
            "SELECT pets.id, pets.name, species.name AS species, pets.image " . 
            "FROM pets INNER JOIN species ON pets.species_id = species.id " . 
            "WHERE user_name LIKE '$user'"
        );

        while ($pet = $result->fetch_assoc()) {
            $_SESSION["pets"][] = $pet;
        }

        $result = $conn->query("SELECT * FROM species");

        while ($species = $result->fetch_assoc()) {
            $_SESSION["species"][] = $species;
        }
    }

    function new_pet($conn) {
        $user_name = $_SESSION["user"];
        $name = $_POST["name"];
        $species_id = $_POST["species_id"];
        $image = $_POST["image"];

        $conn->query("INSERT INTO pets (user_name, name, species_id, image) " . 
                     "VALUES ('$user_name', '$name', '$species_id', '$image')");
    }

    function delete_pet($conn) {
        $id = $_POST["id"];

        $conn->query("DELETE FROM pets WHERE id = $id");
    }
?>
