<?php
    session_start();

    if (!isset($_SESSION["error"])) {
        $_SESSION["error"] = "Ismeretlen hiba";
    } 
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Hiba</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <br><h1>Állattár</h1><br>
</header>
<main>
<br>
<h3><?=$_SESSION["error"]?></h3>
<form action="index.php"><input type="submit" value="Vissza"></form>
<br>
</main>
<footer>
    <br><p>Zana Domán, 2024</p><br>
</footer>
</body>
</html>
