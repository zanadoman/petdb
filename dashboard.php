<?php 
    session_start();
    
    if (!isset($_SESSION["user"]) || $_SESSION["user"] == null) {
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
</head>
<body>
<header>
    <br><h1>Állattár</h1><br>
</header>
<main>
<br>
<h2>Üdv <?=$_SESSION["user"]?></h2>
<div style="display: flex">
    <div style="margin: 0 auto auto auto;">
        <h3>Új állat</h3>
        <form action="api.php" method="POST" class="form">
        <label>Név:</label><br>
        <input type="text" name="name" maxlength="50" required><br>
        <label>Faj</label><br>
        <div style="width: max-content; margin: auto; text-align: left;">
        <?php foreach($_SESSION["species"] as $line): ?>
        <input type="radio" name="species_id" value="<?=$line["id"]?>" required>
        <label><?=$line["name"]?></label><br>
        <?php endforeach; ?>
        </div>
        <label>Kép url:</label><br>
        <input type="text" name="image" maxlength="500" required><br>
        <input type="submit" name="post" value="Hozzáad">
        </form>
    </div>
    <div style="margin: 0 auto auto auto">
        <h3>Állatok</h3>
        <table style="width: 30vw">
        <tr>
            <th>Név</th>
            <th>Faj</th>
            <th>Kép</th>
        </tr>
        <?php foreach($_SESSION["pets"] as $line): ?>
        <tr>
            <td><?=$line["name"]?></td>
            <td>
                <?=array_column($_SESSION["species"], "name", "id")[$line["species_id"]]?>
            </td>
            <td style="width: 15vw;">
                <img src=<?=$line["image"]?> style="width: 15vw;">
            </td>
            <td style="width: 4vw;">
                <form action="api.php" method="POST">
                <input type="hidden" name="id" value="<?=$line["id"]?>">
                <input type="submit" name="delete" value="Törlés">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </table>
    </div>
</div>
<br>
<form action="api.php" method="GET">
    <input type="submit" value="Frissítés">
</form>
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
