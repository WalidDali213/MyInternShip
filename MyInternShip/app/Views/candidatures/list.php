<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Candidatures</title>
    <link rel="stylesheet" href="/public/assets/style.css">
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
                    <a href="/public/uploads/<?= htmlspecialchars($c['cv']) ?>" target="_blank">Voir CV</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Vous n'avez pas encore postulé à une offre.</p>
    <?php endif; ?>
    <br>
    <a href="/public/index.php?controller=offre&action=list">Retour aux offres</a>
</body>
</html>
