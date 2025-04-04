<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Faciliteiten</h1>

        <form action="/facilities/search" method="GET">
            <label for="search">Zoek faciliteiten:</label>
            <input type="text" id="search" name="search" placeholder="Zoek op naam, tags, locatie..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
            <button type="submit">Zoeken</button>
        </form>

        <a href="/facilities/create">Voeg nieuwe faciliteit toe</a>

        <ul>
            <?php if (isset($facilities) && !empty($facilities)): ?>
                <?php foreach ($facilities as $facility): ?>
                    <li>
                        <?php echo htmlspecialchars($facility['name']); ?>

                        <div class="actions">
                            <a href="/facilities/<?php echo $facility['id']; ?>">Bekijk</a>

                            <a href="/facilities/<?php echo $facility['id']; ?>/edit">Bewerken</a>

                            <form action="/facilities/<?php echo $facility['id']; ?>/delete" method="POST" style="display:inline;">
                                <button type="submit" onclick="return confirm('Weet je zeker dat je deze faciliteit wilt verwijderen?');">
                                    Verwijder
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Geen faciliteiten gevonden.</p>
            <?php endif; ?>
        </ul>
    </div>

</body>
</html>
