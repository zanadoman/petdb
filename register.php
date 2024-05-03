<?php
    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        die($conn->connect_error);
    }

    if ($conn->query("SELECT * FROM users WHERE name LIKE '$user'")->num_rows !== 0) {
        $conn->close();
        die("Foglalt felhasználónév");
    }

    if (!$conn->query("INSERT INTO users (name, password) VALUES ('$user', '$pwd')")) {
        $conn->close();
        die("Sikertelen regisztráció");
    }
    
    $conn->close();

    session_start();
    $_SESSION["user"] = $user;

    require_once "dashboard.php";
?>
