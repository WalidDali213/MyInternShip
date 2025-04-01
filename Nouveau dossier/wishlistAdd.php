<?php
// candidatures/wishlistAdd.php
require_once 'Database.php';
require_once 'check_etudiant_admin.php';

if (!isset($_GET['offre_id'])) {
    header("Location: offresList.php");
    exit;
}

$offre_id = $_GET['offre_id'];
$utilisateur_id = $_SESSION['user']['id'];

// Vérifier si l'offre n'est pas déjà dans la wish-list
$stmt = $pdo->prepare("SELECT id FROM wishlist WHERE offre_id = :offre_id AND utilisateur_id = :utilisateur_id");
$stmt->execute([':offre_id' => $offre_id, ':utilisateur_id' => $utilisateur_id]);
if ($stmt->rowCount() == 0) {
    $stmt = $pdo->prepare("INSERT INTO wishlist (offre_id, utilisateur_id) VALUES (:offre_id, :utilisateur_id)");
    $stmt->execute([':offre_id' => $offre_id, ':utilisateur_id' => $utilisateur_id]);
}
header("Location: wishlistList.php");
exit;
?>
