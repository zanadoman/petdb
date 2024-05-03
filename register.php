<?php
    session_start();

    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        http_response_code(500);
        die($conn->connect_error);
    }

    if ($conn->query("SELECT * FROM users WHERE name LIKE '$user'")->num_rows !== 0) {
        $_SESSION["error"] = "Foglalt felhasználónév";
    } else if (!$conn->query("INSERT INTO users (name, password) VALUES ('$user', '$pwd')")) {
        http_response_code(500);
        die($conn->error);        
    } else {
        $_SESSION["user"] = $user;
    }
    
    $conn->close();

    require_once "dashboard.php";
?>
