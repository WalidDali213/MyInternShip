<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Pilotes</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Liste des Pilotes</h1>
    <a href="/public/index.php?controller=pilote&action=create">Ajouter un pilote</a>
    <form action="/public/index.php?controller=pilote&action=search" method="GET" style="margin-top:20px;">
       <input type="text" name="search" placeholder="Rechercher un pilote">
       <button type="submit">Rechercher</button>
    </form>
    <table border="1" cellpadding="5" cellspacing="0" style="margin-top:20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pilots as $pilot): ?>
            <tr>
                <td><?= htmlspecialchars($pilot['id']) ?></td>
                <td><?= htmlspecialchars($pilot['prenom']) ?></td>
                <td><?= htmlspecialchars($pilot['nom']) ?></td>
                <td><?= htmlspecialchars($pilot['email']) ?></td>
                <td>
                    <a href="/public/index.php?controller=pilote&action=view&id=<?= $pilot['id'] ?>">Voir</a> |
                    <a href="/public/index.php?controller=pilote&action=edit&id=<?= $pilot['id'] ?>">Modifier</a> |
                    <a href="/public/index.php?controller=pilote&action=delete&id=<?= $pilot['id'] ?>" onclick="return confirm('Voulez-vous supprimer ce pilote ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="/public/index.php?controller=dashboard&action=admin">Retour au tableau de bord</a>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Pilotes</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Liste des Pilotes</h1>
    <a href="/public/index.php?controller=pilote&action=create">Ajouter un pilote</a>
    <form action="/public/index.php?controller=pilote&action=search" method="GET" style="margin-top:20px;">
       <input type="text" name="search" placeholder="Rechercher un pilote">
       <button type="submit">Rechercher</button>
    </form>
    <table border="1" cellpadding="5" cellspacing="0" style="margin-top:20px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pilots as $pilot): ?>
            <tr>
                <td><?= htmlspecialchars($pilot['id']) ?></td>
                <td><?= htmlspecialchars($pilot['prenom']) ?></td>
                <td><?= htmlspecialchars($pilot['nom']) ?></td>
                <td><?= htmlspecialchars($pilot['email']) ?></td>
                <td>
                    <a href="/public/index.php?controller=pilote&action=view&id=<?= $pilot['id'] ?>">Voir</a> |
                    <a href="/public/index.php?controller=pilote&action=edit&id=<?= $pilot['id'] ?>">Modifier</a> |
                    <a href="/public/index.php?controller=pilote&action=delete&id=<?= $pilot['id'] ?>" onclick="return confirm('Voulez-vous supprimer ce pilote ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="/public/index.php?controller=dashboard&action=admin">Retour au tableau de bord</a>
</body>
</html>
