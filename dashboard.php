<?php 
    session_start();
    
    if (!isset($_SESSION["user"])) {
        $_SESSION["error"] = "Érvénytelen munkamenet";
        header("Location: error.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Irányítópult</title>
    <link rel="stylesheet" href="style.css">
    <script src="methods.js"></script>
</head>
<body onload="init()">
<header>
    <br><h1>Állattár</h1><br>
</header>
<main>
<br>
<h2>Üdv <?=$_SESSION["user"]?></h2>
<div style="display: flex">
    <div style="margin: 0 auto auto auto;">
        <h3>Új állat</h3>
        <form id="new" class="form">
        <label>Név:</label><br>
        <input type="text" name="name" maxlength="50" required><br>
        <label>Faj</label><br>
        <div id="species" style="width: max-content; margin: auto; text-align: left;">
        </div>
        <label>Kép url:</label><br>
        <input type="text" name="image" maxlength="500" required><br>
        <input type="button" onclick="POST()" value="Hozzáad">
        </form>
    </div>
    <div style="margin: 0 auto auto auto">
        <h3>Állatok</h3>
        <table id="pets" style="width: 30vw"></table>
    </div>
</div>
<br>
<form action="index.php">
    <input type="submit" value="Kijelentkezés">
</form>
<br>
</main>
<footer>
    <br><p>Zana Domán, 2024</p><br>
</footer>
</body>
</html>
