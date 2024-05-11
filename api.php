<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        http_response_code(401);
        exit;
    }

    $conn = new mysqli("localhost", "root", "12345678", "petdb");

    switch ($_SERVER['REQUEST_METHOD']) {
        case "GET":
            if (isset($_GET["pets"])) {
                get_pets($conn);
            }
            elseif (isset($_GET["species"])) {
                get_species($conn);
            } else {
                http_response_code(400);
            }
        exit;

        case "POST":
            new_pet($conn);
        exit;

        case "PUT":
            modify_pet($conn);
        exit;

        case "DELETE":
            delete_pet($conn);
        exit;

        default:
            http_response_code(400);
        exit;
    }

    function get_pets($conn) {
        $user_name = $_SESSION["user"];

        $result = $conn->query(
            "SELECT pets.id, pets.name, species.name AS species, pets.image " . 
            "FROM pets INNER JOIN species ON pets.species_id = species.id " . 
            "WHERE user_name = '$user_name'"
        );

        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        http_response_code(200);
    }

    function get_species($conn) {
        $result = $conn->query("SELECT * FROM species");

        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        http_response_code(200);
    }

    function new_pet($conn) {
        $data = json_decode(file_get_contents("php://input"), true);

        $user_name = $_SESSION["user"];
        $name = $data["name"];
        $species_id = $data["species_id"];
        $image = $data["image"];

        if (!isset($name) || !isset($species_id) || !isset($image)) {
            http_response_code(422);
            return;
        }

        $result = $conn->query("SELECT * FROM species WHERE id = '$species_id'");

        if ($result->num_rows === 0) {
            http_response_code(422);
            return;
        }

        $result = $conn->query("SELECT * FROM pets WHERE image = '$image'");

        if ($result->num_rows !== 0) {
            http_response_code(422);
            return;
        }

        $conn->query("INSERT INTO pets (user_name, name, species_id, image) " . 
                     "VALUES ('$user_name', '$name', '$species_id', '$image')");

        http_response_code(200);
    }

    function modify_pet($conn) {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data["id"]; 
        $user_name = $_SESSION["user"];
        $name = $data["name"];
        $species_name = $data["species_name"];
        $image = $data["image"];

        if (!isset($id) || !isset($name) || !isset($species_name) || !isset($image)) {
            http_response_code(422);
            return;
        }

        $result = $conn->query("SELECT * FROM pets " . 
                               "WHERE id = $id AND user_name = '$user_name'");

        if ($result->num_rows === 0) {
            http_response_code(403);
            return;
        }

        $result = $conn->query("SELECT * FROM species WHERE name = '$species_name'");

        if ($result->num_rows === 0) {
            http_response_code(422);
            return;
        }

        $result = $conn->query("SELECT * FROM pets WHERE image = '$image'");

        if ($result->num_rows !== 0) {
            http_response_code(422);
            return;
        }

        $conn->query("UPDATE pets SET name = '$name', species_id = " .
                     "(SELECT id FROM species WHERE name = '$species_name'), " .
                     "image = '$image' WHERE id = $id");

        http_response_code(200);
    }

    function delete_pet($conn) {
        $id = json_decode(file_get_contents("php://input"), true)["id"];
        $user_name = $_SESSION["user"];

        if (!isset($id)) {
            http_response_code(422);
            return;
        }

        $result = $conn->query("SELECT * FROM pets " . 
                               "WHERE id = $id AND user_name = '$user_name'");

        if ($result->num_rows === 0) {
            http_response_code(403);
            return;
        }

        $conn->query("DELETE FROM pets WHERE id = $id");

        http_response_code(200);
    }
?>
