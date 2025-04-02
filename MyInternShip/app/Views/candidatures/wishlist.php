<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Wish-list</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Mes Offres en Wish-list</h1>
    <?php if (count($offres) > 0): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID Offre</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($offres as $offre): ?>
            <tr>
                <td><?= htmlspecialchars($offre['id']) ?></td>
                <td><?= htmlspecialchars($offre['titre']) ?></td>
                <td><?= htmlspecialchars($offre['description']) ?></td>
                <td>
                    <a href="/public/index.php?controller=offre&action=view&id=<?= htmlspecialchars($offre['id']) ?>">Voir</a> |
                    <a href="/public/index.php?controller=candidature&action=wishlistRemove&id=<?= htmlspecialchars($offre['id']) ?>" onclick="return confirm('Retirer cette offre de votre wish-list ?');">Retirer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Aucune offre dans votre wish-list.</p>
    <?php endif; ?>
    <br>
    <a href="/public/index.php?controller=offre&action=list">Retour à la liste des offres</a>
</body>
</html>
