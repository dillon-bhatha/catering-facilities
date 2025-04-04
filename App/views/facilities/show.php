<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h2>Facility Details</h2>

    <p><strong>Facility Name:</strong> <?= htmlspecialchars($facility['name']) ?></p>

    <p><strong>Location:</strong>
        <?php if ($location): ?>
            <?= htmlspecialchars($location['city']) ?>, <?= htmlspecialchars($location['address']) ?>, <?= htmlspecialchars($location['zip_code']) ?>, <?= htmlspecialchars($location['country_code']) ?>
        <?php else: ?>
            Location not available
        <?php endif; ?>
    </p>

    <h3>Tags:</h3>
    <?php if (!empty($tags)): ?>
        <ul>
            <?php foreach ($tags as $tag): ?>
                <li><?= htmlspecialchars($tag['name']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tags available.</p>
    <?php endif; ?>

</body>
</html>