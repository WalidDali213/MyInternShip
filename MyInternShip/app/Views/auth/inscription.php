<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - MyInternship</title>
    <link rel="stylesheet" href="/public/assets/style.css">
</head>
<body>
    <h2>Inscrivez-vous et ouvrez les portes de l'opportunité</h2>
    <?php if(isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="/public/index.php?controller=auth&action=register" method="POST">
        <label for="statut">Statut*</label>
        <select id="statut" name="statut" required>
            <option value="">Sélectionner votre statut</option>
            <option value="etudiant">Étudiant</option>
            <option value="pilote">Pilote</option>
            <option value="administrateur">Administrateur</option>
        </select>
    
        <label for="prenom">Prénom*</label>
        <input type="text" id="prenom" name="prenom" required>
    
        <label for="nom">Nom*</label>
        <input type="text" id="nom" name="nom" required>
    
        <label for="email">Email*</label>
        <input type="email" id="email" name="email" required>
    
        <label for="password">Mot de passe*</label>
        <input type="password" id="password" name="password" required>
    
        <label for="confirmPassword">Confirmation du mot de passe*</label>
        <input type="password" id="confirmPassword" name="confirm_password" required>
    
        <button type="submit">M'inscrire</button>
    </form>
</body>
</html>
