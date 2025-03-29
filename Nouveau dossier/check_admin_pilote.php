<?php
session_start();
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['statut'], ['administrateur', 'pilote'])) {
    header("Location: ../connexion2.php");
    exit;
}
?>
