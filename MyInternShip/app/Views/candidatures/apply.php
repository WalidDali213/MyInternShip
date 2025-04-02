<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Postuler à l'Offre</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Postuler à l'Offre</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=candidature&action=apply&offre_id=<?= htmlspecialchars($offre_id) ?>" enctype="multipart/form-data">
        <label for="lettre_motivation">Lettre de motivation :</label><br>
        <textarea name="lettre_motivation" id="lettre_motivation" rows="8" cols="50" required></textarea>
        <br>
        <label for="cv">Téléverser votre CV :</label>
        <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" required>
        <br>
        <button type="submit">Envoyer ma candidature</button>
    </form>
    <br>
    <a href="/public/index.php?controller=offre&action=list">Retour aux offres</a>
</body>
</html>
