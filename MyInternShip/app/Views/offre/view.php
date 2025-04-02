<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l'Offre de Stage</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Détail de l'Offre de Stage</h1>
    <p><strong>ID :</strong> <?= htmlspecialchars($offre['id']) ?></p>
    <p><strong>Entreprise :</strong> <?= htmlspecialchars($offre['entreprise_nom']) ?></p>
    <p><strong>Titre :</strong> <?= htmlspecialchars($offre['titre']) ?></p>
    <p><strong>Description :</strong> <?= htmlspecialchars($offre['description']) ?></p>
    <p><strong>Compétences requises :</strong> <?= htmlspecialchars($offre['competences']) ?></p>
    <p><strong>Base de rémunération :</strong> <?= htmlspecialchars($offre['base_remuneration']) ?> €</p>
    <p><strong>Dates :</strong> <?= htmlspecialchars($offre['date_debut']) ?> au <?= htmlspecialchars($offre['date_fin']) ?></p>
    <p><strong>Nombre de postulants :</strong> <?= htmlspecialchars($offre['nb_postulants']) ?></p>
    <br>
    <a href="/public/index.php?controller=offre&action=list">Retour à la liste des offres</a>
</body>
</html>
