<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'entreprise</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Détails de l'entreprise</h1>
    <p><strong>Nom :</strong> <?= htmlspecialchars($entreprise['nom']) ?></p>
    <p><strong>Description :</strong> <?= htmlspecialchars($entreprise['description']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($entreprise['email']) ?></p>
    <p><strong>Téléphone :</strong> <?= htmlspecialchars($entreprise['telephone']) ?></p>
    <p><strong>Date de création :</strong> <?= htmlspecialchars($entreprise['date_creation']) ?></p>
    <p><strong>Évaluations :</strong> <?= $nbEval ?> (Moyenne : <?= $avgEval ?>)</p>
    <br>
    <a href="/public/index.php?controller=entreprise&action=list">Retour à la liste</a>
    <a href="/public/index.php?controller=entreprise&action=evaluate&id=<?= $entreprise['id'] ?>">Évaluer cette entreprise</a>
</body>
</html>
