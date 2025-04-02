<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques de l'étudiant</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Statistiques du compte étudiant</h1>
    <p>Nom : <?= htmlspecialchars($student['nom']) ?></p>
    <p>Prénom : <?= htmlspecialchars($student['prenom']) ?></p>
    <p>Email : <?= htmlspecialchars($student['email']) ?></p>
    <!-- Vous pouvez ajouter ici d'autres statistiques spécifiques -->
    <br>
    <a href="/public/index.php?controller=etudiant&action=list">Retour à la liste</a>
</body>
</html>
