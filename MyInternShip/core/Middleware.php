<?php
// core/Middleware.php

class Middleware {
    public static function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] !== 'administrateur') {
            header("Location: /public/index.php?controller=auth&action=login");
            exit();
        }
    }
    
    public static function checkEtudiantAdmin() {
        if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['statut'], ['etudiant', 'administrateur'])) {
            header("Location: /public/index.php?controller=auth&action=login");
            exit();
        }
    }

    public static function checkAuth() {
        if (!isset($_SESSION['user'])) {
            header("Location: /public/index.php?controller=auth&action=login");
            exit();
        }
    }
}
?>
