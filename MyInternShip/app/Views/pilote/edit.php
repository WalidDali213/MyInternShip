<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le pilote</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Modifier le pilote</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=pilote&action=edit&id=<?= htmlspecialchars($pilot['id']) ?>">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($pilot['prenom']) ?>" required>
        <br>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($pilot['nom']) ?>" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($pilot['email']) ?>" required>
        <br>
        <label for="password">Mot de passe (laisser vide pour ne pas modifier) :</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="confirm_password">Confirmer le mot de passe (laisser vide pour ne pas modifier) :</label>
        <input type="password" name="confirm_password" id="confirm_password">
        <br>
        <button type="submit">Modifier</button>
    </form>
    <br>
    <a href="/public/index.php?controller=pilote&action=list">Retour à la liste</a>
</body>
</html>
