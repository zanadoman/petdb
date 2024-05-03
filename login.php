<?php
    session_start();
    $_SESSION["user"] = null;
    $_SESSION["pets"] = [];
    $_SESSION["species"] = [];
    $_SESSION["error"] = null;

    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    $conn = new mysqli("localhost", "root", "12345678", "petdb");
    if ($conn->connect_error) {
        $_SESSION["error"] = "Adatbázis hiba";
        header("Location: error.php");
        exit;
    }
    
    $result = $conn->query("SELECT password FROM users WHERE name LIKE '$user'");
    $conn->close();

    if ($result->num_rows == 0) {
        $_SESSION["error"] = "Hibás felhasználónév";
        header("Location: error.php");
        exit;
    } elseif ($pwd !== $result->fetch_assoc()["password"]) {
        $_SESSION["error"] = "Hibás jelszó";
        header("Location: error.php");
        exit;
    }

    $_SESSION["user"] = $user;
    header("Location: api.php");
?>
