<?php
// offres/offreView.php
session_start();
require_once 'Database.php';
require_once 'check_auth.php';

if(!isset($_GET['id'])) {
    header("Location: offresList.php");
    exit;
}
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT o.*, e.nom AS entreprise_nom FROM offres o 
                       INNER JOIN entreprises e ON o.entreprise_id = e.id 
                       WHERE o.id = :id");
$stmt->execute([':id' => $id]);
$offre = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$offre) {
    die("Offre non trouvée.");
}

// On peut imaginer afficher aussi la liste des évaluations si besoin.
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail de l'Offre de Stage</title>
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
    <a href="offresList.php">Retour à la liste des offres</a>
</body>
</html>
