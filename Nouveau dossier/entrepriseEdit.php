<?php
require_once 'Database.php';
require_once 'check_admin_pilote.php';

if(!isset($_GET['id'])) {
    header("Location: entrepriseList.php");
    exit;
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = :id");
$stmt->execute([':id' => $id]);
$entreprise = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$entreprise) {
    die("Entreprise non trouvée.");
}

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
        $stmt = $pdo->prepare("UPDATE entreprises SET nom = :nom, description = :description, email = :email, telephone = :telephone WHERE id = :id");
        if($stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':email' => $email,
            ':telephone' => $telephone,
            ':id' => $id
        ])) {
            header("Location: entrepriseList.php");
            exit;
        } else {
            $error = "Erreur lors de la mise à jour de l'entreprise.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une entreprise</title>
</head>
<body>
    <h1>Modifier l'entreprise</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($entreprise['nom']) ?>" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" id="description"><?= htmlspecialchars($entreprise['description']) ?></textarea>
        <br>
        <label for="email">Email de contact :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($entreprise['email']) ?>" required>
        <br>
        <label for="telephone">Téléphone de contact :</label>
        <input type="text" name="telephone" id="telephone" value="<?= htmlspecialchars($entreprise['telephone']) ?>" required>
        <br>
        <button type="submit">Mettre à jour</button>
    </form>
    <br>
    <a href="entrepriseList.php">Retour à la liste</a>
</body>
</html>
