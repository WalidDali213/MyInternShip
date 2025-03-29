<?php
try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO('mysql:host=localhost;dbname=authentification', 'SOMPOUGDOUFabi', 'Holy19*spirit');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à MySQL avec PDO!";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>