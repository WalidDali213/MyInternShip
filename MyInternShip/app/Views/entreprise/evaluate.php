<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluer l'entreprise</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Évaluer l'entreprise</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=entreprise&action=evaluate&id=<?= htmlspecialchars($entreprise_id) ?>">
        <label for="evaluation">Note (1 à 5) :</label>
        <input type="number" name="evaluation" id="evaluation" min="1" max="5" required>
        <br>
        <button type="submit">Envoyer l'évaluation</button>
    </form>
    <br>
    <a href="/public/index.php?controller=entreprise&action=view&id=<?= htmlspecialchars($entreprise_id) ?>">Retour aux détails</a>
</body>
</html>
