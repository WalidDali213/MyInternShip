<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;

class EntrepriseController extends Controller {
    public function list() {
        Middleware::checkAuth();  // Accessible à tous les utilisateurs connectés
        global $pdo;
        
        $searchQuery = '';
        if (isset($_GET['search']) && trim($_GET['search']) !== '') {
            $searchQuery = trim($_GET['search']);
            $stmt = $pdo->prepare("SELECT * FROM entreprises 
                                   WHERE nom LIKE :query OR description LIKE :query OR email LIKE :query OR telephone LIKE :query");
            $stmt->execute([':query' => "%$searchQuery%"]);
        } else {
            $stmt = $pdo->query("SELECT * FROM entreprises");
        }
        $entreprises = $stmt->fetchAll();
        
        $this->render('entreprise/list', ['entreprises' => $entreprises, 'searchQuery' => $searchQuery]);
    }

    public function create() {
        // Vérifier que l'utilisateur est administrateur ou pilote
        Middleware::checkAdminOrPilote();
        global $pdo;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = trim($_POST['nom']);
            $description = trim($_POST['description']);
            $email = trim($_POST['email']);
            $telephone = trim($_POST['telephone']);
    
            if(empty($nom) || empty($email) || empty($telephone)) {
                $error = "Les champs Nom, Email et Téléphone sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO entreprises (nom, description, email, telephone) VALUES (:nom, :description, :email, :telephone)");
                if($stmt->execute([
                    ':nom' => $nom,
                    ':description' => $description,
                    ':email' => $email,
                    ':telephone' => $telephone
                ])) {
                    header("Location: /public/index.php?controller=entreprise&action=list");
                    exit();
                } else {
                    $error = "Erreur lors de la création de l'entreprise.";
                }
            }
        }
        
        $this->render('entreprise/create', ['error' => $error ?? null]);
    }

    public function edit() {
        // Vérifier que l'utilisateur est administrateur ou pilote
        Middleware::checkAdminOrPilote();
        global $pdo;
        
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=entreprise&action=list");
            exit();
        }
        $id = $_GET['id'];
        
        // Récupérer l'entreprise
        $stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $entreprise = $stmt->fetch();
        if (!$entreprise) {
            die("Entreprise non trouvée.");
        }
        
        // Traitement du formulaire d'édition
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = trim($_POST['nom']);
            $description = trim($_POST['description']);
            $email = trim($_POST['email']);
            $telephone = trim($_POST['telephone']);
    
            if (empty($nom) || empty($email) || empty($telephone)) {
                $error = "Les champs Nom, Email et Téléphone sont obligatoires.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email invalide.";
            } else {
                $stmt = $pdo->prepare("UPDATE entreprises SET nom = :nom, description = :description, email = :email, telephone = :telephone WHERE id = :id");
                if ($stmt->execute([
                    ':nom' => $nom,
                    ':description' => $description,
                    ':email' => $email,
                    ':telephone' => $telephone,
                    ':id' => $id
                ])) {
                    header("Location: /public/index.php?controller=entreprise&action=list");
                    exit();
                } else {
                    $error = "Erreur lors de la mise à jour de l'entreprise.";
                }
            }
        }
        
        // Afficher la vue d'édition
        $this->render('entreprise/edit', ['entreprise' => $entreprise, 'error' => $error ?? null]);
    }

    public function delete() {
        // Vérifier que l'utilisateur est admin ou pilote
        Middleware::checkAdminOrPilote();
        global $pdo;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM entreprises WHERE id = :id");
            $stmt->execute([':id' => $id]);
        }
        header("Location: /public/index.php?controller=entreprise&action=list");
        exit();
    }
    public function view() {
        Middleware::checkAuth();  // Accessible à tous les utilisateurs connectés
        global $pdo;
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=entreprise&action=list");
            exit();
        }
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $entreprise = $stmt->fetch();
        if (!$entreprise) {
            die("Entreprise non trouvée.");
        }
        
        // Calcul des évaluations
        $stmtEval = $pdo->prepare("SELECT AVG(evaluation) AS avgEval, COUNT(*) AS nbEvaluations FROM entreprise_evaluations WHERE entreprise_id = :id");
        $stmtEval->execute([':id' => $entreprise['id']]);
        $evalData = $stmtEval->fetch();
        $avgEval = $evalData['avgEval'] ? round($evalData['avgEval'], 1) : '-';
        $nbEval = $evalData['nbEvaluations'];
        
        $this->render('entreprise/view', [
            'entreprise' => $entreprise,
            'avgEval' => $avgEval,
            'nbEval' => $nbEval
        ]);
    }
    public function evaluate() {
        Middleware::checkAuth(); // Accessible à tous les utilisateurs connectés
        global $pdo;
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=entreprise&action=list");
            exit();
        }
        $entreprise_id = $_GET['id'];
        $utilisateur_id = $_SESSION['user']['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $evaluation = intval($_POST['evaluation']);
            if ($evaluation < 1 || $evaluation > 5) {
                $error = "Veuillez fournir une note entre 1 et 5.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO entreprise_evaluations (entreprise_id, utilisateur_id, evaluation) VALUES (:entreprise_id, :utilisateur_id, :evaluation)");
                if ($stmt->execute([
                    ':entreprise_id' => $entreprise_id,
                    ':utilisateur_id' => $utilisateur_id,
                    ':evaluation' => $evaluation
                ])) {
                    header("Location: /public/index.php?controller=entreprise&action=view&id=" . $entreprise_id);
                    exit();
                } else {
                    $error = "Erreur lors de l'enregistrement de l'évaluation.";
                }
            }
        }
        $this->render('entreprise/evaluate', ['entreprise_id' => $entreprise_id, 'error' => $error ?? null]);
    }
    
    

    
}
