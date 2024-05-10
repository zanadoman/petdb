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
            }
            if (isset($_GET["species"])) {
                get_species($conn);
            }

        case "POST":
            new_pet($conn);

        case "PUT":
            modify_pet($conn);

        case "DELETE":
            delete_pet($conn);

        default:
            http_response_code(400);
    }

    exit;

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
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }

    function get_species($conn) {
        try {
            $result = $conn->query("SELECT * FROM species");
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
            http_response_code(200);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }

    function new_pet($conn) {
        $user_name = $_SESSION["user"];

        $data = json_decode(file_get_contents("php://input"), true);

        $name = $data["name"];
        $species_id = $data["species_id"];
        $image = $data["image"];

        try {
            $conn->query("INSERT INTO pets (user_name, name, species_id, image) " . 
                         "VALUES ('$user_name', '$name', '$species_id', '$image')");
            http_response_code(200);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }

    function modify_pet($conn) {
        $user_name = $_SESSION["user"];

        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data["id"]; 
        $name = $data["name"];
        $species_name = $data["species_name"];
        $image = $data["image"];

        try {
            $result = $conn->query("SELECT * FROM pets " . 
                                   "WHERE id = $id AND user_name LIKE '$user_name'");
            if ($result->num_rows === 0) {
                http_response_code(403);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }

        try {
            $result = $conn->query("SELECT * FROM species WHERE name LIKE '$species_name'");
            if ($result->num_rows === 0) {
                http_response_code(422);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }

        try {
            $conn->query("UPDATE pets SET name = '$name', species_id = " .
                         "(SELECT id FROM species WHERE name LIKE '$species_name'), " .
                         "image = '$image' WHERE id = $id");
            http_response_code(200);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }

    function delete_pet($conn) {
        $user_name = $_SESSION["user"];

        $id = json_decode(file_get_contents("php://input"), true)["id"];

        try {
            $conn->query("SELECT * FROM pets WHERE id = $id AND user_name = '$user_name'");
            if ($conn->num_rows === 0) {
                http_response_code(403);
                exit;
            }
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }

        try {
            $conn->query("DELETE FROM pets WHERE id = $id");
            http_response_code(200);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }
?>
