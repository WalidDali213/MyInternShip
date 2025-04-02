<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;

class EtudiantController extends Controller {

    // Afficher la liste des étudiants
    public function list() {
        // Ici, vous pouvez restreindre l’accès selon la matrice de rôles
        Middleware::checkAdminOrPilote();
        global $pdo;
        $searchQuery = '';
        if(isset($_GET['search']) && !empty(trim($_GET['search']))){
            $searchQuery = trim($_GET['search']);
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE statut = 'etudiant' 
                                   AND (prenom LIKE :query OR nom LIKE :query OR email LIKE :query)");
            $stmt->execute([':query' => "%$searchQuery%"]);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE statut = 'etudiant'");
            $stmt->execute();
        }
        $students = $stmt->fetchAll();
        $this->render('etudiant/list', ['students' => $students, 'searchQuery' => $searchQuery]);
    }

    // Créer un compte étudiant
    public function create() {
        // Vérifier que seul admin ou pilote peut créer un étudiant (selon votre règle)
        Middleware::checkAdminOrPilote();
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
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (statut, prenom, nom, email, password) VALUES ('etudiant', :prenom, :nom, :email, :password)");
                    if($stmt->execute([
                        ':prenom' => $prenom,
                        ':nom' => $nom,
                        ':email' => $email,
                        ':password' => $hashedPassword
                    ])) {
                        header("Location: /public/index.php?controller=etudiant&action=list");
                        exit();
                    } else {
                        $error = "Erreur lors de la création du compte étudiant.";
                    }
                }
            }
        }
        $this->render('etudiant/create', ['error' => $error ?? null]);
    }

    // Modifier un compte étudiant
    public function edit() {
        Middleware::checkAdminOrPilote();
        global $pdo;
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=etudiant&action=list");
            exit();
        }
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id AND statut = 'etudiant'");
        $stmt->execute([':id' => $id]);
        $student = $stmt->fetch();
        if (!$student) {
            die("Compte étudiant non trouvé.");
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
                header("Location: /public/index.php?controller=etudiant&action=list");
                exit();
            }
        }
        $this->render('etudiant/edit', ['student' => $student, 'error' => $error ?? null]);
    }

    // Supprimer un compte étudiant
    public function delete() {
        Middleware::checkAdminOrPilote();
        global $pdo;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id AND statut = 'etudiant'");
            $stmt->execute([':id' => $id]);
        }
        header("Location: /public/index.php?controller=etudiant&action=list");
        exit();
    }

    // Statistiques d'un compte étudiant (Exemple basique)
    public function stats() {
        Middleware::checkAdminOrPilote();
        global $pdo;
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=etudiant&action=list");
            exit();
        }
        $id = $_GET['id'];
        // Exemple : Récupérer des statistiques fictives ou des données de suivi
        // Ici, vous pouvez récupérer des données sur le parcours de l'étudiant, etc.
        // Pour l'exemple, nous renvoyons juste le compte étudiant
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = :id AND statut = 'etudiant'");
        $stmt->execute([':id' => $id]);
        $student = $stmt->fetch();
        if (!$student) {
            die("Compte étudiant non trouvé.");
        }
        // Pour l'instant, nous affichons seulement des données de base
        $this->render('etudiant/stats', ['student' => $student]);
    }
}
