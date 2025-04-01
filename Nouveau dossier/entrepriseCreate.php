<?php
require_once 'Database.php';
require_once 'check_admin_pilote.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);

    if(empty($nom) || empty($email) || empty($telephone)) {
        $error = "Les champs Nom, Email et Téléphone sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO entreprises (nom, description, email, telephone) VALUES (:nom, :description, :email, :telephone)");
        if($stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':email' => $email,
            ':telephone' => $telephone
        ])) {
            header("Location: entrepriseList.php");
            exit;
        } else {
            $error = "Erreur lors de la création de l'entreprise.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une entreprise</title>
</head>
<body>
    <h1>Créer une entreprise</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" id="description"></textarea>
        <br>
        <label for="email">Email de contact :</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="telephone">Téléphone de contact :</label>
        <input type="text" name="telephone" id="telephone" required>
        <br>
        <button type="submit">Créer l'entreprise</button>
    </form>
    <br>
    <a href="entrepriseList.php">Retour à la liste</a>
</body>
</html>
