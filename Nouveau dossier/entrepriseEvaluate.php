<?php
require_once 'Database.php';
require_once 'check_auth.php';

if(!isset($_GET['id'])) {
    header("Location: entrepriseList.php");
    exit;
}
$entreprise_id = $_GET['id'];
$utilisateur_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $evaluation = intval($_POST['evaluation']);
    if($evaluation < 1 || $evaluation > 5) {
        $error = "Veuillez fournir une note entre 1 et 5.";
    } else {
        // Pour simplifier, on insère une nouvelle évaluation
        $stmt = $pdo->prepare("INSERT INTO entreprise_evaluations (entreprise_id, utilisateur_id, evaluation) VALUES (:entreprise_id, :utilisateur_id, :evaluation)");
        if($stmt->execute([
            ':entreprise_id' => $entreprise_id,
            ':utilisateur_id' => $utilisateur_id,
            ':evaluation' => $evaluation
        ])) {
            header("Location: entrepriseView.php?id=" . $entreprise_id);
            exit;
        } else {
            $error = "Erreur lors de l'enregistrement de l'évaluation.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Évaluer l'entreprise</title>
</head>
<body>
    <h1>Évaluer l'entreprise</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="evaluation">Note (1 à 5) :</label>
        <input type="number" name="evaluation" id="evaluation" min="1" max="5" required>
        <br>
        <button type="submit">Envoyer l'évaluation</button>
    </form>
    <br>
    <a href="entrepriseView.php?id=<?= $entreprise_id ?>">Retour aux détails</a>
</body>
</html>
