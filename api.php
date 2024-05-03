<?php
    session_start();

    if (!isset($_SESSION["user"]) || $_SESSION["user"] == null) {
        $_SESSION["error"] = "Érvénytelen hozzáférés";
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
            get_pets($conn, $_SESSION["user"]);
        break;

        case "POST":
            new_pet($conn, json_decode(file_get_contents("php://input")), true);
        break;

        case "DELETE":
            delete_pet($conn, file_get_contents("php://input"));
        break;
    }

    $conn->close();
    header("Location: dashboard.php");

    function get_pets($conn, $user) {
        $_SESSION["pets"] = [];
        $_SESSION["species"] = [];

        $result = $conn->query("SELECT id, name, species_id, image " . 
                               "FROM pets WHERE user_name LIKE '$user'");

        while ($pet = $result->fetch_assoc()) {
            $_SESSION["pets"] = json_encode($pet);
        }

        $result = $conn->query("SELECT * FROM species");

        while ($species = $result->fetch_assoc()) {
            $_SESSION["species"] = json_encode($species);
        }
    }

    function new_pet($conn, $pet) {
        $user_name = $_SESSION["user"];
        $name = $pet["name"];
        $species_id = $pet["species_id"];
        $image = $pet["image"];

        $conn->query("INSERT INTO pets (user_name, name, species_id, image) " . 
                     "VALUES ('$user_name', '$name', '$species_id', '$image')");
    }

    function delete_pet($conn, $id) {
        $conn->query("DELETE FROM pets WHERE id = $id");
    }
?>
