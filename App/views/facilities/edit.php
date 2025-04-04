<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="form-container">
        <h1>Bewerk Faciliteit</h1>

        <form action="/facilities/<?php echo $facility['id']; ?>/edit" method="POST">
            <label for="name">Naam:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($facility['name']); ?>" required><br>

            <label for="location_id">Locatie:</label>
            <select name="location_id" id="location_id" required>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo $location['id']; ?>" <?php echo $facility['location_id'] == $location['id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($location['city']) ?>, <?= htmlspecialchars($location['address']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <div class="checkbox-group">
                <label for="tags">Tags:</label><br>
                <?php foreach ($tags as $tag): ?>
                    <div>
                        <input type="checkbox" name="tags[]" value="<?php echo $tag['id']; ?>"
                            <?php echo in_array($tag['id'], $selectedTags) ? 'checked' : ''; ?>>
                        <label for="tags"><?php echo htmlspecialchars($tag['name']); ?></label><br>
                    </div>
                <?php endforeach; ?>
            </div><br>

            <button type="submit">Bewerk Faciliteit</button>
        </form>

        <a href="/facilities/<?php echo $facility['id']; ?>">Terug naar faciliteit</a><br>
        <a href="/facilities">Terug naar overzicht</a>
    </div>

</body>
</html>
