<?php
session_start();
// Connexion à la base de données
$host = 'localhost'; // Remplacez par votre serveur MySQL
$dbname = 'authentification'; // Remplacez par votre nom de base de données
$username = 'SOMPOUGDOUFabi'; // Nom d'utilisateur MySQL
$password = 'Holy19*spirit'; // Mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configuration des attributs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Requête préparée pour récupérer l'utilisateur par son email
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $login);
    $stmt->execute();

    // Vérifier si l'utilisateur existe
    if ($stmt->rowCount() > 0) {
        // Récupérer les données de l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le mot de passe correspond
        if (password_verify($password, $user['password'])) {
            // Enregistrer les informations de l'utilisateur en session
            $_SESSION['user'] = [
                'id'      => $user['id'],
                'statut'  => $user['statut'],
                'prenom'  => $user['prenom'],
                'nom'     => $user['nom'],
                'email'   => $user['email']
            ];
            echo "Connexion réussie !";

     // Redirection selon le rôle
            if ($user['statut'] == 'administrateur') {
                header("Location: gestion_pilotes.php?action=list");
            } else {
                // Pour pilote ou étudiant, redirigez vers un tableau de bord approprié
                header("Location: dashboard.php");
            }
            exit;
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email";
    }
}
?>



<!-- Formulaire de connexion -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
<h2>Connexion</h2>
    <form method="POST" action="">
        <label for="login">Email</label>
        <input type="email" name="login" required placeholder="Entrez votre email">

        <br>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" required placeholder="Entrez votre mot de passe">

        <br>

        <input type="submit" value="Se connecter">
    </form>
</body>
</html>