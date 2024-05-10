<?php
    session_start();

    if (!isset($_SESSION["user"]) || $_SESSION["user"] == null) {
        http_response_code(401);
        exit;
    }

    try {
        $conn = new mysqli("localhost", "root", "12345678", "petdb");
    } catch (Exception $e) {
        http_response_code(500);
        exit;
    }

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_GET["pets"])) {
                get_pets($conn);
                exit;
            }
            
            if (isset($_GET["species"])) {
                get_species($conn);
                exit;
            }

        case "POST":
            new_pet($conn);
        exit;

        case "DELETE":
            delete_pet($conn);
        exit;

        default:
            http_response_code(400);
        exit;
    }

    function get_pets($conn) {
        $user = $_SESSION["user"];

        try {
            $result = $conn->query(
                "SELECT pets.id, pets.name, species.name AS species, pets.image " . 
                "FROM pets INNER JOIN species ON pets.species_id = species.id " . 
                "WHERE user_name LIKE '$user'"
            );
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
        }
    }

    function get_species($conn) {
        try {
            $result = $conn->query("SELECT * FROM species");
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
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
            http_response_code(200);
        } catch (Exception $e) {
            http_response_code(500);
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
