<?php
session_start();
require_once 'Database.php';
require_once 'check_admin_pilote.php';

if(!isset($_GET['id'])) {
    header("Location: etudiantList.php");
    exit;
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id AND statut = 'etudiant'");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$student) {
    die("Compte étudiant non trouvé.");
}

// Exemple de statistiques fictives : ici, vous pouvez interroger d'autres tables ou utiliser des données spécifiques
// Par exemple, nombre de candidatures, taux de réponses, etc.
$stats = [
    'nombre_candidatures' => 3,
    'offres_en_wishlist'  => 1
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques du compte étudiant</title>
</head>
<body>
    <h1>Statistiques pour <?= htmlspecialchars($student['prenom'] . " " . $student['nom']) ?></h1>
    <p><strong>Email :</strong> <?= htmlspecialchars($student['email']) ?></p>
    <h2>Statistiques de recherche de stage</h2>
    <p><strong>Nombre de candidatures :</strong> <?= $stats['nombre_candidatures'] ?></p>
    <p><strong>Nombre d'offres en wish list :</strong> <?= $stats['offres_en_wishlist'] ?></p>
    <br>
    <a href="etudiantList.php">Retour à la liste</a>
</body>
</html>
