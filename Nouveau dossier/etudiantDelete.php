<?php
session_start();
require_once 'Database.php';
require_once 'check_admin_pilote.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id AND statut = 'etudiant'");
    $stmt->execute([':id' => $id]);
}
header("Location: etudiantList.php");
exit;
?>
