<?php
require_once 'Database.php';
require_once 'check_auth.php';

if(!isset($_GET['id'])) {
    header("Location: entrepriseList.php");
    exit;
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = :id");
$stmt->execute([':id' => $id]);
$entreprise = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$entreprise) {
    die("Entreprise non trouvée.");
}

// Calcul des évaluations
$stmtEval = $pdo->prepare("SELECT AVG(evaluation) AS avgEval, COUNT(*) AS nbEvaluations FROM entreprise_evaluations WHERE entreprise_id = :id");
$stmtEval->execute([':id' => $entreprise['id']]);
$evalData = $stmtEval->fetch(PDO::FETCH_ASSOC);
$avgEval = $evalData['avgEval'] ? round($evalData['avgEval'], 1) : '-';
$nbEval = $evalData['nbEvaluations'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'entreprise</title>
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
    <a href="entrepriseList.php">Retour à la liste</a>
    <!-- Lien pour évaluer -->
    <a href="entrepriseEvaluate.php?id=<?= $entreprise['id'] ?>">Évaluer cette entreprise</a>
</body>
</html>
