<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Irányítópult</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<header>
    <br><p><h1>Állattár</h1><p><br>
</header>
<main>
<br>
<?php if (count($errors) === 0): ?>
    <h2><?php echo "Üdv " . $user ?></h2>
    <div style="display: flex">
        <div style="margin: auto">
        <form action="add.php" method="POST">
            <input type="hidden" id="user" name="user" value=<?=$user?>>
            <label for="name">Név:</label><br>
            <input type="text" id="name" name="name" maxlength="50" required><br>
            <label for="species">Faj</label><br>
            <div class="radio">
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

        <div style="margin: auto">
        <h3>Állatok</h3>
        <table>
        <tr>
            <th>Név<th>
            <th>Faj<th>
            <th>Kép<th>
            <td><td>
        </tr>
        <?php
            $file = $user . ".txt";
            $index = 0;
            if (file_exists($file)):
            foreach (explode("\n", file_get_contents($file)) as $line):
            $fields = explode(";", $line);
            if (count($fields) === 3):
        ?>
        <tr>
            <td><?php echo $fields[0] ?><td>
            <td><?php echo $fields[1] ?><td>
            <td><img src=<?=$fields[2]?> class="img"></td>
            <td>
                <form action="del.php" method="POST">
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
<?php else: ?>
    <?php foreach ($errors as $error): ?> 
        <p><?php echo $error ?></p>
    <?php endforeach; ?>
    <form action="index.php">
        <input type="submit" value="Vissza">
    </form>
<?php endif; ?>
<br>
</main>
<footer>
    <br><p>Zana Domán, 2024</p><br>
</footer>
</body>
</html>
