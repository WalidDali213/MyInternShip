<?php
// candidatures/wishlistList.php
require_once 'Database.php';
require_once 'check_etudiant_admin.php';

$utilisateur_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT w.id, o.* FROM wishlist w 
                       INNER JOIN offres o ON w.offre_id = o.id 
                       WHERE w.utilisateur_id = :utilisateur_id");
$stmt->execute([':utilisateur_id' => $utilisateur_id]);
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ma Wish-list</title>
</head>
<body>
    <h1>Mes Offres en Wish-list</h1>
    <?php if (count($offres) > 0): ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID Offre</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($offres as $offre): ?>
            <tr>
                <td><?= htmlspecialchars($offre['id']) ?></td>
                <td><?= htmlspecialchars($offre['titre']) ?></td>
                <td><?= htmlspecialchars($offre['description']) ?></td>
                <td>
                    <a href="offreView.php?id=<?= $offre['id'] ?>">Voir</a> |
                    <a href="wishlistRemove.php?id=<?= $offre['id'] ?>" onclick="return confirm('Retirer cette offre de votre wish-list ?');">Retirer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Aucune offre dans votre wish-list.</p>
    <?php endif; ?>
    <br>
    <a href="offresList.php">Retour à la liste des offres</a>
</body>
</html>
