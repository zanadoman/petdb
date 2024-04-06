<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Főoldal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header></header>
<main>
<br>
<form action="register.php" method="POST">
    <label for="user">Felhasználó:</label><br>
    <input type="text" id="user" name="user"
     pattern="^[^;]*$" maxlength="50" required><br>
    <label for="pwd">Jelszó:</label><br>
    <input type="password" id="pwd" name="pwd" 
     pattern="^[^;]*$" minlength="8" maxlength="50" required><br>
    <input type="submit" value="Regisztrál">
</form>
<br>
<form action="login.php" method="POST">
    <label for="user">Felhasználó:</label><br>
    <input type="text" id="user" name="user"
     pattern="^[^;]*$" maxlength="50" required><br>
    <label for="pwd">Jelszó:</label><br>
    <input type="password" id="pwd" name="pwd" 
     pattern="^[^;]*$" minlength="8" maxlength="50" required><br>
    <input type="submit" value="Bejelentkezés">
</form>
<br>
</main>
<footer></footer>
</body>
</html>
