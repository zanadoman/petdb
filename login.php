<?php
    session_start();

    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        http_response_code(500);
        die($conn->connect_error);
    }

    $result = $conn->query("SELECT password FROM users WHERE name LIKE '$user'"); 
    
    if ($result->num_rows === 0) {
        $_SESSION["error"] = "Hibás felhasználónév";
    } else if ($pwd !== $result->fetch_assoc()["password"]) {
        $_SESSION["error"] = "Hibás jelszó";
    } else {
        $_SESSION["user"] = $user;
    }

    $conn->close();

    require_once "dashboard.php";
?>
