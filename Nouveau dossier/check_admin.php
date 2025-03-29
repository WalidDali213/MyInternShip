<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] !== 'administrateur') {
    header("Location: ../connexion2.php");
    exit;
}
?>
