<?php
// candidatures/candidatureList.php
require_once 'Database.php';
require_once 'check_etudiant_admin.php';

$utilisateur_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT c.*, o.titre, o.entreprise_id, e.nom AS entreprise_nom FROM candidatures c 
                       INNER JOIN offres o ON c.offre_id = o.id 
                       INNER JOIN entreprises e ON o.entreprise_id = e.id 
                       WHERE c.utilisateur_id = :utilisateur_id");
$stmt->execute([':utilisateur_id' => $utilisateur_id]);
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Candidatures</title>
</head>
<body>
    <h1>Mes Candidatures</h1>
    <?php if(count($candidatures) > 0): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>Entreprise</th>
            <th>Offre</th>
            <th>Date de candidature</th>
            <th>Lettre de motivation</th>
            <th>CV</th>
        </tr>
        <?php foreach ($candidatures as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['entreprise_nom']) ?></td>
                <td><?= htmlspecialchars($c['titre']) ?></td>
                <td><?= htmlspecialchars($c['date_candidature']) ?></td>
                <td><?= nl2br(htmlspecialchars($c['lettre_motivation'])) ?></td>
                <td>
                    <a href="../uploads/<?= htmlspecialchars($c['cv']) ?>" target="_blank">Voir CV</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Vous n'avez pas encore postulé à une offre.</p>
    <?php endif; ?>
    <br>
    <a href="offresList.php">Retour aux offres</a>
</body>
</html>
