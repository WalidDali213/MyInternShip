<?php
session_start();
require_once 'Database.php';
require_once 'check_admin.php';

if(!isset($_GET['id'])) {
    header("Location: pilotList.php");
    exit;
}
$id = $_GET['id'];

// Récupérer les données du pilote
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id AND statut = 'pilote'");
$stmt->execute([':id' => $id]);
$pilot = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$pilot) {
    die("Pilote non trouvé.");
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
        // Si un mot de passe est saisi, vérifie la confirmation et la longueur
        if ($password !== $confirmPassword) {
            $error = "Les mots de passe ne correspondent pas.";
        } elseif (strlen($password) < 8) {
            $error = "Le mot de passe doit contenir au moins 8 caractères.";
        }
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
    header("Location: pilotList.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Modifier le pilote</title>
</head>
<body>
<h1>Modifier le pilote</h1>
<?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($pilot['prenom']) ?>" required>
        <br>
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($pilot['nom']) ?>" required>
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($pilot['email']) ?>" required>
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
    <a href="pilotList.php">Retour à la liste</a>
</body>
</html>