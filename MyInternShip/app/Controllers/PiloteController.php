<?php
// app/Controllers/PiloteController.php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/Middleware.php';
require_once __DIR__ . '/../Models/Database.php'; // Pour la connexion PDO

class PiloteController extends Controller {
    public function list() {
        // On vérifie que l'utilisateur est admin ou pilote (selon vos règles)
        Middleware::checkAdmin(); // Pour ce module, nous supposons que seul l'administrateur peut gérer les pilotes
        
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE statut = 'pilote'");
        $stmt->execute();
        $pilots = $stmt->fetchAll();
        
        // Renvoyer la vue avec les données des pilotes
        $this->render('pilote/list', ['pilots' => $pilots]);
    }
}

class PiloteController extends Controller {
    // Affiche le formulaire de création d'un pilote et le traite
    public function create() {
        // Vérifier que l'utilisateur est administrateur (si c'est la règle)
        Middleware::checkAdmin();  // ou checkAdminOrPilote() selon vos règles

        global $pdo;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prenom = trim($_POST['prenom']);
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if(empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($confirmPassword)) {
                $error = "Tous les champs sont requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($password) < 8) {
                $error = "Le mot de passe doit contenir au moins 8 caractères.";
            } else {
                // Vérifier si l'email existe déjà
                $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
                $stmt->execute([':email' => $email]);
                if($stmt->rowCount() > 0){
                    $error = "Cet email est déjà utilisé.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (statut, prenom, nom, email, password) VALUES ('pilote', :prenom, :nom, :email, :password)");
                    if($stmt->execute([
                        ':prenom' => $prenom,
                        ':nom' => $nom,
                        ':email' => $email,
                        ':password' => $hashedPassword
                    ])) {
                        header("Location: /public/index.php?controller=pilote&action=list");
                        exit;
                    } else {
                        $error = "Erreur lors de l'ajout du pilote.";
                    }
                }
            }
        }
        $this->render('pilote/create', ['error' => $error ?? null]);
    }
}