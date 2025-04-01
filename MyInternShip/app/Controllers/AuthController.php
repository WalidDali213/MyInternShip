<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les valeurs du formulaire
            $login = isset($_POST['login']) ? trim($_POST['login']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            $userModel = new User();
            $user = $userModel->findByEmail($login);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Enregistrer les informations de l'utilisateur en session
                    $_SESSION['user'] = [
                        'id'      => $user['id'],
                        'statut'  => $user['statut'],
                        'prenom'  => $user['prenom'],
                        'nom'     => $user['nom'],
                        'email'   => $user['email']
                    ];
                    // Redirection selon le rôle
                    if ($user['statut'] == 'administrateur') {
                        header("Location: /public/index.php?controller=dashboard&action=index");
                    } else {
                        header("Location: /public/index.php?controller=dashboard&action=index");
                    }
                    exit();
                } else {
                    $error = "Mot de passe incorrect";
                }
            } else {
                $error = "Aucun utilisateur trouvé avec cet email";
            }
        }
        // Affiche la vue login
        $this->render('auth/login', ['error' => $error ?? null]);
    }
    
    public function logout() {
        session_destroy();
        header("Location: /public/index.php?controller=auth&action=login");
        exit();
    }

    public function register() {  // Ajout correct de la fonction à l'intérieur de la classe
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Connexion à la BDD via le modèle Database déjà défini
            $prenom = trim($_POST["prenom"]);
            $nom = trim($_POST["nom"]);
            $email = trim($_POST["email"]);
            $statut = $_POST["statut"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirm_password"];
        
            if (empty($statut) || empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($confirmPassword)) {
                $error = "Tous les champs sont requis !";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide !";
            } elseif (strlen($password) < 8) {
                $error = "Le mot de passe doit contenir au moins 8 caractères !";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas !";
            }
        
            if (!isset($error)) {
                $userModel = new User();
                // Vérifier si l'email existe déjà
                if ($userModel->findByEmail($email)) {
                    $error = "Cet email est déjà utilisé !";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    // Insérer l'utilisateur en base
                    $db = Database::getInstance();
                    $stmt = $db->prepare("INSERT INTO utilisateurs (statut, prenom, nom, email, password) VALUES (:statut, :prenom, :nom, :email, :password)");
                    $result = $stmt->execute([
                        ':statut' => $statut,
                        ':prenom' => $prenom,
                        ':nom'    => $nom,
                        ':email'  => $email,
                        ':password' => $hashedPassword
                    ]);
                    if ($result) {
                        echo "Inscription réussie ! <a href='/public/index.php?controller=auth&action=login'>Connectez-vous</a>";
                        exit();
                    } else {
                        $error = "Erreur lors de l'inscription.";
                    }
                }
            }
        }
        $this->render('auth/inscription', ['error' => $error ?? null]);
    }
}
?>