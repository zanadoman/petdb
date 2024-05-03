<?php
    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        die($conn->connect_error);
    }

    $result = $conn->query("SELECT password FROM users WHERE name LIKE '$user'"); 
    
    if ($result->num_rows === 0) {
        $conn->close();
        die("Hibás felhasználónév");
    }
    if ($result->fetch_assoc()["password"] !== $pwd) {
        $conn->close();
        die("Hibás jelszó");
    }

    $conn->close();

    session_start();
    $_SESSION["user"] = $user;

    require_once "dashboard.php";
?>
