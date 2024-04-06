<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>Irányítópult</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header></header>
<main>
<br>
<?php if (count($errors) === 0): ?>
    <p><?php echo "Üdv " . $user ?></p>
    <div style="display: flex">
        <div style="margin: auto">
        <form action="add.php" method="POST">
            <input type="hidden" id="user" name="user" value=<?=$user?>>
            <label for="name">Név:</label><br>
            <input type="text" id="name" name="name" maxlength="50" required><br>
            <label for="species">Faj</label><br>
            <input type="radio" id="dog" name="species" value="Kutya" checked>
                Kutya</label><br>
            <input type="radio" id="cat" name="species" value="Macska">
                Macska</label><br>
            <input type="radio" id="fish" name="species" value="Hal">
                Hal</label><br>
            <input type="radio" id="bird" name="species" value="Madár">
                Madár</label><br>
            <input type="radio" id="hamster" name="species" value="Hörcsög">
                Hörcsög
            </label><br>
            <input type="submit" value="Hozzáad">
        </form>
        </div>
        <div style="margin: auto">
        <p>Állatok</p>
        <?php if (file_exists($user . ".txt")): ?>
        <table>
        <?php
            $index = 0;
            foreach (explode("\n", file_get_contents($user . ".txt")) as $line):
            $fields = explode(";", $line);
            if (count($fields) === 2):
        ?>
        <tr>
            <?php foreach ($fields as $field): ?>
                <td><?php echo $field; ?></td>
            <?php endforeach; ?>
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
        ?>
        </table>
        <?php else: ?>
        <p>Még nincs állatod.</p>
        <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <?php foreach ($errors as $error): ?> 
        <p><?php echo $error ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<br>
</main>
<footer></footer>
</body>
</html>
