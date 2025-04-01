<?php
// offres/offreCreate.php
session_start();
require_once 'Database.php';
require_once 'check_admin_pilote.php'; // accès réservé admin et pilote

// Récupérer la liste des entreprises pour le champ de sélection
$stmtEntreprises = $pdo->query("SELECT id, nom FROM entreprises");
$entreprises = $stmtEntreprises->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entreprise_id = trim($_POST['entreprise_id']);
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $competences = trim($_POST['competences']);   
    $base_remuneration = trim($_POST['base_remuneration']);
    $date_debut = trim($_POST['date_debut']);
    $date_fin = trim($_POST['date_fin']);

    if(empty($entreprise_id) || empty($titre) || empty($competences) || empty($base_remuneration) || empty($date_debut) || empty($date_fin)) {
        $error = "Tous les champs obligatoires doivent être renseignés.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO offres (entreprise_id, titre, description, competences, base_remuneration, date_debut, date_fin) 
                               VALUES (:entreprise_id, :titre, :description, :competences, :base_remuneration, :date_debut, :date_fin)");
        if($stmt->execute([
            ':entreprise_id'   => $entreprise_id,
            ':titre'           => $titre,
            ':description'     => $description,
            ':competences'     => $competences,
            ':base_remuneration'=> $base_remuneration,
            ':date_debut'      => $date_debut,
            ':date_fin'        => $date_fin
        ])) {
            header("Location: offresList.php");
            exit;
        } else {
            $error = "Erreur lors de la création de l'offre.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Offre de Stage</title>
</head>
<body>
    <h1>Créer une Offre de Stage</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="entreprise_id">Entreprise :</label>
        <select name="entreprise_id" id="entreprise_id" required>
            <option value="">Sélectionnez une entreprise</option>
            <?php foreach ($entreprises as $entreprise): ?>
                <option value="<?= $entreprise['id'] ?>"><?= htmlspecialchars($entreprise['nom']) ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="titre">Titre de l'offre :</label>
        <input type="text" name="titre" id="titre" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" id="description"></textarea>
        <br>
        <label for="competences">Compétences (séparées par des virgules) :</label>
        <input type="text" name="competences" id="competences" required>
        <br>
        <label for="base_remuneration">Base de rémunération :</label>
        <input type="number" step="0.01" name="base_remuneration" id="base_remuneration" required>
        <br>
        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" id="date_debut" required>
        <br>
        <label for="date_fin">Date de fin :</label>
        <input type="date" name="date_fin" id="date_fin" required>
        <br>
        <button type="submit">Créer l'offre</button>
    </form>
    <br>
    <a href="offresList.php">Retour à la liste des offres</a>
</body>
</html>
