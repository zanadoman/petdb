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

    if ($conn->query("SELECT * FROM users WHERE name LIKE '$user'")->num_rows !== 0) {
        $conn->close();
        $_SESSION["error"] = "Foglalt felhasználónév";
        header("Location: error.php");
        exit;
    }
 
    $conn->query("INSERT INTO users (name, password) VALUES ('$user', '$pwd')");
    $conn->close();

    $_SESSION["user"] = $user;
    header("Location: api.php");
?>
