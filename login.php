<?php
    session_start();

    $_SESSION["user"] = null;
    $_SESSION["error"] = null;

    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    
    if ($conn->connect_error) {
        $_SESSION["error"] = $conn->connect_error;
    } else if (!($result = $conn->query("SELECT password FROM users WHERE name LIKE '$user'"))) {
        $_SESSION["error"] = $conn->connect;
    } else if ($result->num_rows === 0) {
        $_SESSION["error"] = "Hibás felhasználónév";
    } else if ($pwd !== $result->fetch_assoc()["password"]) {
        $_SESSION["error"] = "Hibás jelszó";
    } else {
        $_SESSION["user"] = $user;
    }

    $conn->close();

    header("Location: dashboard.php");
?>
