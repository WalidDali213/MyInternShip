<?php
require_once 'Database.php';
require_once 'check_auth.php';

$searchQuery = '';
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $searchQuery = trim($_GET['search']);
    $stmt = $pdo->prepare("SELECT * FROM entreprises 
                           WHERE nom LIKE :query OR description LIKE :query OR email LIKE :query OR telephone LIKE :query");
    $stmt->execute([':query' => "%$searchQuery%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM entreprises");
}
$entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Entreprises</title>
</head>
<body>
    <h1>Liste des Entreprises</h1>
    <!-- Lien vers la création (accessible uniquement si pilote ou administrateur) -->
    <?php if(in_array($_SESSION['user']['statut'], ['administrateur','pilote'])): ?>
        <a href="entrepriseCreate.php">Créer une entreprise</a>
    <?php endif; ?>

    <form action="entrepriseList.php" method="GET" style="margin-top:20px;">
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
            // Récupération des évaluations pour cette entreprise
            $stmtEval = $pdo->prepare("SELECT AVG(evaluation) AS avgEval, COUNT(*) AS nbEvaluations 
                                       FROM entreprise_evaluations WHERE entreprise_id = :id");
            $stmtEval->execute([':id' => $entreprise['id']]);
            $evalData = $stmtEval->fetch(PDO::FETCH_ASSOC);
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
                    <a href="entrepriseView.php?id=<?= $entreprise['id'] ?>">Voir</a> |
                    <!-- Pour évaluer, tous les utilisateurs connectés ont accès -->
                    <a href="entrepriseEvaluate.php?id=<?= $entreprise['id'] ?>">Évaluer</a>
                    <?php if(in_array($_SESSION['user']['statut'], ['administrateur','pilote'])): ?>
                        | <a href="entrepriseEdit.php?id=<?= $entreprise['id'] ?>">Modifier</a>
                        | <a href="entrepriseDelete.php?id=<?= $entreprise['id'] ?>" onclick="return confirm('Confirmez la suppression ?');">Supprimer</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="dashboard.php">Retour au tableau de bord</a>
</body>
</html>
