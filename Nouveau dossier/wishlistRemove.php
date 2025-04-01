<?php
// candidatures/wishlistRemove.php
require_once 'Database.php';
require_once 'check_etudiant_admin.php';

if (!isset($_GET['id'])) {
    header("Location: wishlistList.php");
    exit;
}

$id = $_GET['id']; // ID de l'entrée dans la table wishlist
$stmt = $pdo->prepare("DELETE FROM wishlist WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: wishlistList.php");
exit;
?>
