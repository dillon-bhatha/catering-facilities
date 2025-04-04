<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <form action="/facilities/create" method="POST" class="facility-form">
        <label for="name">Facility Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="location">Location:</label>
        <select id="location" name="location_id" required>
            <?php foreach ($locations as $location): ?>
                <option value="<?= htmlspecialchars($location['id']) ?>">
                    <?= htmlspecialchars($location['city']) ?>, <?= htmlspecialchars($location['address']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="tags">Tags:</label>
        <div class="tags-container">
            <?php foreach ($tags as $tag): ?>
                <div class="tag-option">
                    <input type="checkbox" id="tag_<?= $tag['id'] ?>" name="tags[]" value="<?= $tag['id'] ?>">
                    <label for="tag_<?= $tag['id'] ?>"><?= htmlspecialchars($tag['name']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="submit" class="submit-btn">Add Facility</button>
    </form>
</body>
</html>