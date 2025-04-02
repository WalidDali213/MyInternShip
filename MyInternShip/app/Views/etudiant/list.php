<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Liste des Étudiants</h1>
    <a href="/public/index.php?controller=etudiant&action=create">Créer un compte étudiant</a>
    <form action="/public/index.php?controller=etudiant&action=list" method="GET" style="margin-top:20px;">
       <input type="text" name="search" placeholder="Rechercher un étudiant" value="<?= htmlspecialchars($searchQuery ?? '') ?>">
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
                <a href="/public/index.php?controller=etudiant&action=view&id=<?= $student['id'] ?>">Voir</a> |
                <a href="/public/index.php?controller=etudiant&action=edit&id=<?= $student['id'] ?>">Modifier</a> |
                <a href="/public/index.php?controller=etudiant&action=delete&id=<?= $student['id'] ?>" onclick="return confirm('Voulez-vous supprimer ce compte étudiant ?');">Supprimer</a> |
                <a href="/public/index.php?controller=etudiant&action=stats&id=<?= $student['id'] ?>">Statistiques</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="/public/index.php?controller=dashboard&action=index">Retour au tableau de bord</a>
</body>
</html>
