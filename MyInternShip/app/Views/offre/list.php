<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Offres de Stage</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Liste des Offres de Stage</h1>
    <!-- Lien vers création de l'offre pour admin/pilote -->
    <?php if (in_array($_SESSION['user']['statut'], ['administrateur', 'pilote'])): ?>
        <a href="/public/index.php?controller=offre&action=create">Créer une offre</a>
    <?php endif; ?>

    <form action="/public/index.php?controller=offre&action=list" method="GET" style="margin-top:20px;">
       <input type="text" name="search" placeholder="Rechercher une offre" value="<?= htmlspecialchars($searchQuery) ?>">
       <button type="submit">Rechercher</button>
    </form>
    <table border="1" cellpadding="5" cellspacing="0" style="margin-top:20px;">
        <tr>
            <th>ID</th>
            <th>Entreprise</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Compétences</th>
            <th>Rémunération</th>
            <th>Dates</th>
            <th>Nb Postulants</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($offres as $offre): ?>
        <tr>
            <td><?= htmlspecialchars($offre['id']) ?></td>
            <td><?= htmlspecialchars($offre['entreprise_nom']) ?></td>
            <td><?= htmlspecialchars($offre['titre']) ?></td>
            <td><?= htmlspecialchars($offre['description']) ?></td>
            <td><?= htmlspecialchars($offre['competences']) ?></td>
            <td><?= htmlspecialchars($offre['base_remuneration']) ?> €</td>
            <td><?= htmlspecialchars($offre['date_debut']) ?> au <?= htmlspecialchars($offre['date_fin']) ?></td>
            <td><?= htmlspecialchars($offre['nb_postulants']) ?></td>
            <td>
                <a href="/public/index.php?controller=offre&action=view&id=<?= $offre['id'] ?>">Voir</a>
                <?php if (in_array($_SESSION['user']['statut'], ['administrateur', 'pilote'])): ?>
                    | <a href="/public/index.php?controller=offre&action=edit&id=<?= $offre['id'] ?>">Modifier</a>
                    | <a href="/public/index.php?controller=offre&action=delete&id=<?= $offre['id'] ?>" onclick="return confirm('Confirmez la suppression de cette offre ?');">Supprimer</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="/public/index.php?controller=dashboard&action=index">Retour au tableau de bord</a>
</body>
</html>
