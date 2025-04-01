<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un pilote</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Ajouter un pilote</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=pilote&action=create">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" required>
        <br>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <br>
        <button type="submit">Ajouter</button>
    </form>
    <br>
    <a href="/public/index.php?controller=pilote&action=list">Retour à la liste</a>
</body>
</html>
