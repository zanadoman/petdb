<?php
    session_start();

    $_SESSION["user"] = null;
    $_SESSION["error"] = null;

    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");

    if ($conn->connect_error) {
        $_SESSION["error"] = $conn->connect_error;
    } else if ($conn->query("SELECT * FROM users WHERE name LIKE '$user'")->num_rows !== 0) {
        $_SESSION["error"] = "Foglalt felhasználónév";
    } else if (!$conn->query("INSERT INTO users (name, password) VALUES ('$user', '$pwd')")) {
        $_SESSION["error"] = $conn->error;
    } else {
        $_SESSION["user"] = $user;
    }
    
    $conn->close();

    header("Location: dashboard.php");
?>
