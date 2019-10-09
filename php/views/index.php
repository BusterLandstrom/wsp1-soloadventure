<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <p>
            <?= $story['body'] ?>
        </p>

        <ul>
            <?php foreach ($links as $link): ?>
                <li><?= $link['description'] ?></li>
            <?php endforeach ?>
        </ul>
    </main>
</body>
</html>