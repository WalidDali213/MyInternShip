<?php
session_start();
require_once 'Database.php';

// Si une recherche est demandée
if(isset($_GET['search']) && !empty(trim($_GET['search']))){
    $searchQuery = trim($_GET['search']);
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE statut = 'etudiant' 
                           AND (prenom LIKE :query OR nom LIKE :query OR email LIKE :query)");
    $stmt->execute([':query' => "%$searchQuery%"]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Sinon, on affiche tous les étudiants
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE statut = 'etudiant'");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
</head>
<body>
    <h1>Liste des Étudiants</h1>
    <a href="etudiantCreate.php">Créer un compte étudiant</a>
    <form action="etudiantList.php" method="GET" style="margin-top:20px;">
       <input type="text" name="search" placeholder="Rechercher un étudiant">
       <button type="submit">Rechercher</button>
    </form>
    <table border="1" cellpadding="5" cellspacing="0" style="margin-top:20px;">
        <tr>
            <th>ID</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['id']) ?></td>
            <td><?= htmlspecialchars($student['prenom']) ?></td>
            <td><?= htmlspecialchars($student['nom']) ?></td>
            <td><?= htmlspecialchars($student['email']) ?></td>
            <td>
                <a href="etudiantView.php?id=<?= $student['id'] ?>">Voir</a> |
                <a href="etudiantEdit.php?id=<?= $student['id'] ?>">Modifier</a> |
                <a href="etudiantDelete.php?id=<?= $student['id'] ?>" onclick="return confirm('Voulez-vous supprimer ce compte étudiant ?');">Supprimer</a> |
                <a href="etudiantStats.php?id=<?= $student['id'] ?>">Statistiques</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="../dashboard.php">Retour au tableau de bord</a>
</body>
</html>
