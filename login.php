<?php
    session_start();
    $_SESSION["user"] = null;
    $_SESSION["pets"] = [];
    $_SESSION["species"] = [];
    $_SESSION["error"] = null;

    $user = $_POST["user"];
    $pwd = $_POST["pwd"];

    try {
        $conn = new mysqli("localhost", "root", "12345678", "petdb");
    } catch (Exception $e) {
        $_SESSION["error"] = "Adatbázis hiba";
        header("Location: error.php");
        exit;
    }

    try {
        $result = $conn->query("SELECT password FROM users WHERE name LIKE '$user'");
    } catch (Exception $e) {
        $_SESSION["error"] = "Adatbázis hiba";
        header("Location: error.php");
        exit;
    }

    if ($result->num_rows === 0) {
        $_SESSION["error"] = "Hibás felhasználónév";
        header("Location: error.php");
        exit;
    }

    if ($result->fetch_assoc()["password"] !== $pwd) {
        $_SESSION["error"] = "Hibás jelszó";
        header("Location: error.php");
        exit;
    }

    $_SESSION["user"] = $user;
    header("Location: dashboard.php");
?>
