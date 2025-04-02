<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Entreprises</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Liste des Entreprises</h1>
    <?php if(in_array($_SESSION['user']['statut'], ['administrateur', 'pilote'])): ?>
        <a href="/public/index.php?controller=entreprise&action=create">Créer une entreprise</a>
    <?php endif; ?>
    <form action="/public/index.php?controller=entreprise&action=list" method="GET" style="margin-top:20px;">
       <input type="text" name="search" placeholder="Rechercher une entreprise" value="<?= htmlspecialchars($searchQuery) ?>">
       <button type="submit">Rechercher</button>
    </form>
    <table border="1" cellpadding="5" cellspacing="0" style="margin-top:20px;">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Nb évaluations / Moyenne</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($entreprises as $entreprise): ?>
            <?php
            // Récupérer les évaluations pour cette entreprise
            $stmtEval = $pdo->prepare("SELECT AVG(evaluation) AS avgEval, COUNT(*) AS nbEvaluations 
                                       FROM entreprise_evaluations WHERE entreprise_id = :id");
            $stmtEval->execute([':id' => $entreprise['id']]);
            $evalData = $stmtEval->fetch();
            $avgEval = $evalData['avgEval'] ? round($evalData['avgEval'], 1) : '-';
            $nbEval = $evalData['nbEvaluations'];
            ?>
            <tr>
                <td><?= htmlspecialchars($entreprise['id']) ?></td>
                <td><?= htmlspecialchars($entreprise['nom']) ?></td>
                <td><?= htmlspecialchars($entreprise['description']) ?></td>
                <td><?= htmlspecialchars($entreprise['email']) ?></td>
                <td><?= htmlspecialchars($entreprise['telephone']) ?></td>
                <td><?= $nbEval ?> / <?= $avgEval ?></td>
                <td>
                    <a href="/public/index.php?controller=entreprise&action=view&id=<?= $entreprise['id'] ?>">Voir</a> |
                    <a href="/public/index.php?controller=entreprise&action=evaluate&id=<?= $entreprise['id'] ?>">Évaluer</a>
                    <?php if(in_array($_SESSION['user']['statut'], ['administrateur', 'pilote'])): ?>
                        | <a href="/public/index.php?controller=entreprise&action=edit&id=<?= $entreprise['id'] ?>">Modifier</a>
                        | <a href="/public/index.php?controller=entreprise&action=delete&id=<?= $entreprise['id'] ?>" onclick="return confirm('Confirmez la suppression ?');">Supprimer</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="/public/index.php?controller=dashboard&action=index">Retour au tableau de bord</a>
</body>
</html>
