<?php
    session_start();
    $_SESSION["user"] = null;
    $_SESSION["error"] = null;
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Főoldal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <br><h1>Állattár</h1><br>
</header>
<main>
<br>
<form action="register.php" method="POST" class="form">
    <label>Felhasználó:</label><br>
    <input type="text" name="user" maxlength="50" required><br>
    <label>Jelszó:</label><br>
    <input type="password" name="pwd" minlength="8" maxlength="50" required><br>
    <input type="submit" value="Regisztrál">
</form>
<br>
<form action="login.php" method="POST" class="form">
    <label>Felhasználó:</label><br>
    <input type="text" name="user" maxlength="50" required><br>
    <label>Jelszó:</label><br>
    <input type="password" name="pwd" minlength="8" maxlength="50" required><br>
    <input type="submit" value="Bejelentkezés">
</form>
<br>
</main>
<footer>
    <br><p>Zana Domán, 2024</p><br>
</footer>
</body>
</html>
