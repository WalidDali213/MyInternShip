
<?php
try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO('mysql:host=localhost;dbname=authentification', 'SOMPOUGDOUFabi', 'Holy19*spirit');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à MySQL avec PDO!";
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification de la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $statut = $_POST["statut"];
    $prenom = trim($_POST["prenom"]);
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Vérification des champs
    if (empty($statut) || empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($confirmPassword)) {
        die("Tous les champs sont requis !");
    }

    // Vérification du format de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email invalide !");
    }

    // Vérification de la longueur du mot de passe
    if (strlen($password) < 8) {
        die("Le mot de passe doit contenir au moins 8 caractères !");
    }

    // Vérification de la confirmation du mot de passe
    if ($password !== $confirmPassword) {
        die("Les mots de passe ne correspondent pas !");
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Vérification si l'email existe déjà dans la base de données
    $checkEmail = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
    $checkEmail->bindValue(':email', $email, PDO::PARAM_STR);
    $checkEmail->execute();

    if ($checkEmail->rowCount() > 0) {
        die("Cet email est déjà utilisé !");

    }

    // Insertion de l'utilisateur en base de données
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (statut, prenom, nom, email, password) VALUES (:statut, :prenom, :nom, :email, :password)");
    $stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
    $stmt->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Inscription réussie ! <a href='connexion2.php'>Connectez-vous</a>";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - MyInternship</title>
</head>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}
header {
    background: #333;
    padding: 15px 0;
}
nav {
    width: 80%;
    margin: auto;
}
.menu {
    display: flex;
    justify-content: space-around;
    list-style: none;
}
.menu li a {
    color: white;
    text-decoration: none;
    padding: 15px 10px;
}
.menu li a.active {
    border-bottom: 3px solid blue;
}
.menu li a:hover {
    color: lightblue;
}
.account {
    margin-left: auto;
}

.form-container {
    width: 40%;
    margin: 40px auto;
    padding: 30px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
label, input, select {
    display: block;
    width: 100%;
    margin-bottom: 15px;
}
input, select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
button {
    background: blue;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}
button:hover {
    background: darkblue;
}
.checkbox {
    display: flex;
    align-items: center;
}
.checkbox input {
    width: auto;
    margin-right: 10px;
}

footer {
    background: #111;
    color: white;
    padding: 20px;
    text-align: center;
}
.footer-container {
    display: flex;
    justify-content: space-around;
}
.footer-container .column {
    width: 20%;
}
.footer-container h4 {
    margin-bottom: 10px;
}
.footer-container a {
    display: block;
    color: white;
    text-decoration: none;
    font-size: 14px;
}

.footer-container a:hover {
    color: lightgray;
}

</style>
<body>

<header>
    <nav>
        <ul class="menu">
            <li><a href="#" class="active">Offres</a></li>
            <li><a href="#">Entreprises</a></li>
            <li class="account">
               <a href="#">👤 Mon compte</a>
            </li>
        </ul>
    </nav>
</header>

<main>
    <div class="form-container">
        <h2>Inscrivez-vous et ouvrez les portes de l'opportunité</h2>
        <form action="inscription.php" method="POST">
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

            <div class="checkbox">
                <input type="checkbox" id="conditions" name="conditions" required>
                <label for="conditions">J'accepte les conditions d'utilisation</label>
            </div>

            <button type="submit">M'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="#">Connectez-vous</a></p>
    </div>
</main>

<footer>
    <div class="footer-container">
        <div class="column">
            <h4>Étudiants</h4>
            <a href="#">S'inscrire</a>
            <a href="#">Chercher une offre de stage</a>
        </div>
        <div class="column">
            <h4>Entreprises</h4>
            <a href="#">Notre offre entreprise</a>
        </div>
        <div class="column">
            <h4>MyInternship</h4>
            <a href="#">A propos</a>
            <a href="#">Nous rejoindre</a>
        </div>
    </div>
    <p>@ 2025 MyInternship - Site de recherche de stage</p>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("form").addEventListener("submit", function (event) {
        let statut = document.getElementById("statut").value;
        let prenom = document.getElementById("prenom").value.trim();
        let nom = document.getElementById("nom").value.trim();
        let email = document.getElementById("email").value.trim();
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("confirmPassword").value;
        let conditions = document.getElementById("conditions").checked;

        if (!statut || !prenom || !nom || !email || !password || !confirmPassword) {
            alert("Tous les champs sont obligatoires !");
            event.preventDefault();
            return;
        }
        
        if (password.length < 8) {
            alert("Le mot de passe doit contenir au moins 8 caractères.");
            event.preventDefault();
            return;
        }

        if (password !== confirmPassword) {
            alert("Les mots de passe ne correspondent pas !");
            event.preventDefault();
            return;
        }

        if (!conditions) {
            alert("Vous devez accepter les conditions d'utilisation !");
            event.preventDefault();
        }
    });
});
</script>

</body>
</html>