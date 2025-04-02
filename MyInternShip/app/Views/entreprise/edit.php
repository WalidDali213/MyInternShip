<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une entreprise</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Modifier l'entreprise</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=entreprise&action=edit&id=<?= htmlspecialchars($entreprise['id']) ?>">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($entreprise['nom']) ?>" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" id="description"><?= htmlspecialchars($entreprise['description']) ?></textarea>
        <br>
        <label for="email">Email de contact :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($entreprise['email']) ?>" required>
        <br>
        <label for="telephone">Téléphone de contact :</label>
        <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($entreprise['telephone']) ?>" required>
        <br>
        <button type="submit">Mettre à jour</button>
    </form>
    <br>
    <a href="/public/index.php?controller=entreprise&action=list">Retour à la liste</a>
</body>
</html>
