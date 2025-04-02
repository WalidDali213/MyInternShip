<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Offres de Stage</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Statistiques des Offres de Stage</h1>
    
    <h2>Répartition par compétence</h2>
    <?php if(!empty($allCompetences)): ?>
    <ul>
        <?php foreach ($allCompetences as $comp => $count): ?>
            <li><?= htmlspecialchars($comp) ?> : <?= $count ?></li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
        <p>Aucune donnée disponible.</p>
    <?php endif; ?>
    
    <h2>Top 5 des offres (plus de postulants)</h2>
    <?php if(!empty($topOffres)): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Entreprise</th>
            <th>Nb Postulants</th>
        </tr>
        <?php foreach ($topOffres as $offre): ?>
            <?php
            // Récupérer le nom de l'entreprise peut être fait dans le contrôleur, ici nous supposons que c'est déjà dans l'array
            ?>
            <tr>
                <td><?= htmlspecialchars($offre['id']) ?></td>
                <td><?= htmlspecialchars($offre['titre']) ?></td>
                <td><?= htmlspecialchars($offre['entreprise_nom'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($offre['nb_postulants']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Aucune offre disponible.</p>
    <?php endif; ?>
    <br>
    <a href="/public/index.php?controller=offre&action=list">Retour à la liste des offres</a>
    <br>
    <a href="/public/index.php?controller=dashboard&action=index">Retour au tableau de bord</a>
</body>
</html>
