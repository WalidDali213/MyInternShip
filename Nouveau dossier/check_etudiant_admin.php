<?php
session_start();
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['statut'], ['etudiant', 'administrateur'])) {
    header("Location: ../connexion2.php");
    exit;
}
?>
