<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une Offre de Stage</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h1>Créer une Offre de Stage</h1>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="/public/index.php?controller=offre&action=create">
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
    <a href="/public/index.php?controller=offre&action=list">Retour à la liste des offres</a>
</body>
</html>
