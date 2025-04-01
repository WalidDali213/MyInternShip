<?php
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['statut'], ['etudiant', 'administrateur'])) {
    header("Location: /public/index.php?controller=auth&action=login");
    exit;
}
