<?php
// app/Controllers/PiloteController.php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/Middleware.php';
require_once __DIR__ . '/../Models/Database.php'; // Connexion PDO
require_once __DIR__ . '/../../Models/User.php';

class PiloteController extends Controller {

    // Liste des pilotes
    public function list() {
        Middleware::checkAdmin(); // Seul l'administrateur peut gérer les pilotes
        
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE statut = 'pilote'");
        $stmt->execute();
        $pilots = $stmt->fetchAll();
        
        $this->render('pilote/list', ['pilots' => $pilots]);
    }

    // Création d'un pilote
    public function create() {
        Middleware::checkAdmin();

        global $pdo;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prenom = trim($_POST['prenom']);
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if (empty($prenom) || empty($nom) || empty($email) || empty($password) || empty($confirmPassword)) {
                $error = "Tous les champs sont requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($password) < 8) {
                $error = "Le mot de passe doit contenir au moins 8 caractères.";
            } else {
                $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
                $stmt->execute([':email' => $email]);
                if ($stmt->rowCount() > 0) {
                    $error = "Cet email est déjà utilisé.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (statut, prenom, nom, email, password) VALUES ('pilote', :prenom, :nom, :email, :password)");
                    if ($stmt->execute([
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

    // Édition d'un pilote
    public function edit() {
        Middleware::checkAdmin();

        global $pdo;
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=pilote&action=list");
            exit();
        }

        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id AND statut = 'pilote'");
        $stmt->execute([':id' => $id]);
        $pilot = $stmt->fetch();
        
        if (!$pilot) {
            die("Pilote non trouvé.");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prenom = trim($_POST['prenom']);
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if (empty($prenom) || empty($nom) || empty($email)) {
                $error = "Les champs prénom, nom et email sont requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } elseif (!empty($password)) {
                if ($password !== $confirmPassword) {
                    $error = "Les mots de passe ne correspondent pas.";
                } elseif (strlen($password) < 8) {
                    $error = "Le mot de passe doit contenir au moins 8 caractères.";
                }
            }

            if (!isset($error)) {
                if (!empty($password)) {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare("UPDATE utilisateurs SET prenom = :prenom, nom = :nom, email = :email, password = :password WHERE id = :id");
                    $stmt->execute([
                        ':prenom' => $prenom,
                        ':nom' => $nom,
                        ':email' => $email,
                        ':password' => $hashedPassword,
                        ':id' => $id
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE utilisateurs SET prenom = :prenom, nom = :nom, email = :email WHERE id = :id");
                    $stmt->execute([
                        ':prenom' => $prenom,
                        ':nom' => $nom,
                        ':email' => $email,
                        ':id' => $id
                    ]);
                }
                header("Location: /public/index.php?controller=pilote&action=list");
                exit();
            }
        }

        $this->render('pilote/edit', ['pilot' => $pilot, 'error' => $error ?? null]);
    }

    // Suppression d'un pilote
    public function delete() {
        Middleware::checkAdmin();

        global $pdo;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id AND statut = 'pilote'");
            $stmt->execute([':id' => $id]);
        }
        header("Location: /public/index.php?controller=pilote&action=list");
        exit();
    }
}
