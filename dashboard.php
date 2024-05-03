<?php 
    session_start();
    
if ((!isset($_SESSION["user"]) || $_SESSION["user"] == null) &&
    (!isset($_SESSION["error"]) || $_SESSION["error"] == null)) {
        $user = null;
        $error = "Érvénytelen hozzáférés";
    } else {
        $user = $_SESSION["user"];
        $error = $_SESSION["error"];
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
<?php if ($user != null): ?>
    <h2>Üdv <?=$_SESSION["user"]?></h2>
    <div style="display: flex">
        <div style="margin: 0 auto auto auto;">
        <h3>Új állat</h3>
        <form action="add.php" method="POST" class="form">
            <input type="hidden" id="user" name="user" value=<?=$user?>>
            <label for="name">Név:</label><br>
            <input type="text" id="name" name="name" maxlength="50" required><br>
            <label for="species">Faj</label><br>
            <div style="width: max-content; margin: auto; text-align: left;">
            <input type="radio" id="dog" name="species" value="Kutya" checked>
                Kutya</label><br>
            <input type="radio" id="cat" name="species" value="Macska">
                Macska</label><br>
            <input type="radio" id="fish" name="species" value="Hal">
                Hal</label><br>
            <input type="radio" id="bird" name="species" value="Madár">
                Madár</label><br>
            <input type="radio" id="hamster" name="species" value="Hörcsög">
                Hörcsög</label><br>
            </div>
            <label for="img">Kép url:</label><br>
            <input type="text" id="img" name="img" required><br>
            <input type="submit" value="Hozzáad">
        </form>
        </div>
        <div style="margin: 0 auto auto auto">
        <h3>Állatok</h3>
        <table style="width: 35vw">
        <tr>
            <th>Név<th>
            <th>Faj<th>
            <th>Kép<th>
        </tr>
        <?php
            $file = "db/" . $user . ".txt";
            $index = 0;
            if (file_exists($file)):
            foreach (explode("\n", file_get_contents($file)) as $line):
            $fields = explode(";", $line);
            if (1 < count($fields)):
        ?>
        <tr>
            <td><?php echo $fields[0]; ?><td>
            <td><?php echo $fields[1]; ?><td>
            <td style="width: 17vw;">
                <img src=<?=$fields[2]?> style="width: 15vw;">
            </td>
            <td style="width: 3vw;">
                <form action="delete.php" method="POST">
                    <input type="hidden" id="user" name="user" value=<?=$user?>>
                    <input type="hidden" id="index" name="index" value=<?=$index++?>>
                    <input type="submit" value="Törlés">
                </form>
            </td>
        </tr>
        <?php
            endif;
            endforeach;
            endif;
        ?>
        </table>
        </div>
    </div>
    <br>
    <form action="index.php">
        <input type="submit" value="Kijelentkezés">
    </form>
<?php else: ?>
    <h3><?=$error?></h3>
    <form action="index.php"><input type="submit" value="Vissza"></form>
<?php endif; ?>
<br>
</main>
<footer>
    <br><p>Zana Domán, 2024</p><br>
</footer>
</body>
</html>
