<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une entreprise</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Créer une entreprise</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=entreprise&action=create">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" id="description"></textarea>
        <br>
        <label for="email">Email de contact :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="telephone">Téléphone de contact :</label>
        <input type="text" name="telephone" id="telephone" required>
        <br>
        <button type="submit">Créer l'entreprise</button>
    </form>
    <br>
    <a href="/public/index.php?controller=entreprise&action=list">Retour à la liste</a>
</body>
</html>
