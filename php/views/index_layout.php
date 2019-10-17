<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$page_title?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <p class="charText">Character:  <?php echo $_SESSION['character'];?></p>
        <p class="charText">Primary hand: <?php echo $_SESSION['primary_hand']; ?></p>
        <p class="charText">Backpack: <?php print_r($_SESSION['backpack']); echo $item_name; ?></p>
        <div class="story">
            <p>Tillbaka till <a href="?id=1">början.</a></p>
            <p>Du har <?php echo $_SESSION['endurance'];?> liv.</p>
            <p>
                <?= $story['body'] ?>
            </p>
        </div>

        <ul>
            <?php foreach ($links as $link): ?>
                <li>
                    <a href="?id=<?= $link['target_id'] ?>">
                        <?= $link['description'] ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </main>
</body>
</html>