<?php
session_start();
require_once 'etudiantEdit.php';
require_once 'check_admin_pilote.php';

if(!isset($_GET['id'])) {
    header("Location: etudiantList.php");
    exit;
}
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id AND statut = 'etudiant'");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$student) {
    die("Compte étudiant non trouvé.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = trim($_POST['prenom']);
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if(empty($prenom) || empty($nom) || empty($email)) {
        $error = "Les champs prénom, nom et email sont requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif(!empty($password)) {
        if ($password !== $confirmPassword) {
            $error = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères.";
        }
    }
    
    if(!isset($error)) {
        if(!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE utilisateurs SET prenom = :prenom, nom = :nom, email = :email, password = :password WHERE id = :id");
            $stmt->execute([
                ':prenom' => $prenom,
                ':nom' => $nom,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':id' => $id
            ]);
        } else {
            $stmt = $pdo->prepare("UPDATE utilisateurs SET prenom = :prenom, nom = :nom, email = :email WHERE id = :id");
            $stmt->execute([
                ':prenom' => $prenom,
                ':nom' => $nom,
                ':email' => $email,
                ':id' => $id
            ]);
        }
        header("Location: etudiantList.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un compte étudiant</title>
</head>
<body>
    <h1>Modifier le compte étudiant</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($student['prenom']) ?>" required>
        <br>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($student['nom']) ?>" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        <br>
        <label for="password">Mot de passe (laisser vide pour ne pas modifier) :</label>
        <input type="password" name="password" id="password">
        <br>
        <label for="confirm_password">Confirmer le mot de passe (laisser vide pour ne pas modifier) :</label>
        <input type="password" name="confirm_password" id="confirm_password">
        <br>
        <button type="submit">Modifier</button>
    </form>
    <br>
    <a href="etudiantList.php">Retour à la liste</a>
</body>
</html>
