<?php
// offres/offreStats.php
session_start();
require_once 'Database.php';
require_once 'check_auth.php';

// Statistique 1 : Répartition par compétence
// Pour simplifier, nous allons supposer que le champ "competences" contient des listes séparées par des virgules
$stmt = $pdo->query("SELECT competences FROM offres");
$allCompetences = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $competences = explode(',', $row['competences']);
    foreach ($competences as $comp) {
        $comp = trim($comp);
        if (!empty($comp)) {
            if (!isset($allCompetences[$comp])) {
                $allCompetences[$comp] = 0;
            }
            $allCompetences[$comp]++;
        }
    }
}

// Statistique 2 : Top des offres (par nombre de postulants)
$stmt2 = $pdo->query("SELECT * FROM offres ORDER BY nb_postulants DESC LIMIT 5");
$topOffres = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Offres de Stage</title>
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
            // Récupérer le nom de l'entreprise
            $stmtEnt = $pdo->prepare("SELECT nom FROM entreprises WHERE id = :id");
            $stmtEnt->execute([':id' => $offre['entreprise_id']]);
            $entreprise = $stmtEnt->fetch(PDO::FETCH_ASSOC);
            ?>
            <tr>
                <td><?= htmlspecialchars($offre['id']) ?></td>
                <td><?= htmlspecialchars($offre['titre']) ?></td>
                <td><?= htmlspecialchars($entreprise['nom'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($offre['nb_postulants']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Aucune offre disponible.</p>
    <?php endif; ?>
    <br>
    <a href="offresList.php">Retour à la liste des offres</a>
    <br>
    <a href="../dashboard.php">Retour au tableau de bord</a>
</body>
</html>
