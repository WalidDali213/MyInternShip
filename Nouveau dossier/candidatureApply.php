<?php
// candidatures/candidatureApply.php
require_once 'Database.php';
require_once 'check_etudiant_admin.php';

if (!isset($_GET['offre_id'])) {
    header("Location: offresList.php");
    exit;
}

$offre_id = $_GET['offre_id'];
$utilisateur_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lettre = trim($_POST['lettre_motivation']);
    
    // Gestion du fichier CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        // Définir le dossier de destination et générer un nom unique
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $cvName = uniqid() . '_' . basename($_FILES['cv']['name']);
        $uploadFile = $uploadDir . $cvName;
        if (!move_uploaded_file($_FILES['cv']['tmp_name'], $uploadFile)) {
            $error = "Erreur lors de l'upload du CV.";
        }
    } else {
        $error = "Veuillez téléverser un CV.";
    }
    
    if (!isset($error)) {
        $stmt = $pdo->prepare("INSERT INTO candidatures (utilisateur_id, offre_id, lettre_motivation, cv) 
                               VALUES (:utilisateur_id, :offre_id, :lettre_motivation, :cv)");
        if ($stmt->execute([
            ':utilisateur_id'   => $utilisateur_id,
            ':offre_id'         => $offre_id,
            ':lettre_motivation'=> $lettre,
            ':cv'               => $cvName
        ])) {
            header("Location: candidatureList.php");
            exit;
        } else {
            $error = "Erreur lors de l'enregistrement de la candidature.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Postuler à l'Offre</title>
</head>
<body>
    <h1>Postuler à l'Offre</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="lettre_motivation">Lettre de motivation :</label><br>
        <textarea name="lettre_motivation" id="lettre_motivation" rows="8" cols="50" required></textarea>
        <br>
        <label for="cv">Téléverser votre CV :</label>
        <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" required>
        <br>
        <button type="submit">Envoyer ma candidature</button>
    </form>
    <br>
    <a href="offresList.php">Retour aux offres</a>
</body>
</html>
