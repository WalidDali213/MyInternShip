<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Database;

class CandidatureController extends Controller {
    
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    // Méthode pour postuler à une offre
    public function apply() {
        Middleware::checkEtudiantAdmin();
        
        if (!isset($_GET['offre_id'])) {
            header("Location: /public/index.php?controller=offre&action=list");
            exit();
        }

        $offre_id = $_GET['offre_id'];
        $utilisateur_id = $_SESSION['user']['id'];
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lettre = trim($_POST['lettre_motivation']);

            // Gestion de l'upload du CV
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
                $uploadDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $cvName = uniqid() . '_' . basename($_FILES['cv']['name']);
                $uploadFile = $uploadDir . $cvName;

                if (move_uploaded_file($_FILES['cv']['tmp_name'], $uploadFile)) {
                    // Insertion en base de données
                    $stmt = $this->pdo->prepare("INSERT INTO candidatures (utilisateur_id, offre_id, lettre_motivation, cv) VALUES (:utilisateur_id, :offre_id, :lettre_motivation, :cv)");

                    if ($stmt->execute([
                        ':utilisateur_id'   => $utilisateur_id,
                        ':offre_id'         => $offre_id,
                        ':lettre_motivation'=> $lettre,
                        ':cv'               => $cvName
                    ])) {
                        header("Location: /public/index.php?controller=candidature&action=list");
                        exit();
                    } else {
                        $error = "Erreur lors de l'enregistrement de la candidature.";
                    }
                } else {
                    $error = "Erreur lors de l'upload du CV.";
                }
            } else {
                $error = "Veuillez téléverser un CV.";
            }
        }

        $this->render('candidatures/apply', ['offre_id' => $offre_id, 'error' => $error]);
    }

    // Méthode pour lister les candidatures de l'utilisateur
    public function list() {
        Middleware::checkEtudiantAdmin();
        $utilisateur_id = $_SESSION['user']['id'];

        $stmt = $this->pdo->prepare("SELECT c.*, o.titre, o.entreprise_id, e.nom AS entreprise_nom FROM candidatures c INNER JOIN offres o ON c.offre_id = o.id INNER JOIN entreprises e ON o.entreprise_id = e.id WHERE c.utilisateur_id = :utilisateur_id");
        $stmt->execute([':utilisateur_id' => $utilisateur_id]);
        $candidatures = $stmt->fetchAll();

        $this->render('candidatures/list', ['candidatures' => $candidatures]);
    }

    // Méthode pour ajouter une offre à la wishlist
    public function wishlistAdd() {
        Middleware::checkEtudiantAdmin();

        if (!isset($_GET['offre_id'])) {
            header("Location: /public/index.php?controller=offre&action=list");
            exit();
        }

        $offre_id = $_GET['offre_id'];
        $utilisateur_id = $_SESSION['user']['id'];

        $stmt = $this->pdo->prepare("SELECT id FROM wishlist WHERE offre_id = :offre_id AND utilisateur_id = :utilisateur_id");
        $stmt->execute([':offre_id' => $offre_id, ':utilisateur_id' => $utilisateur_id]);

        if ($stmt->rowCount() == 0) {
            $stmt = $this->pdo->prepare("INSERT INTO wishlist (offre_id, utilisateur_id) VALUES (:offre_id, :utilisateur_id)");
            $stmt->execute([':offre_id' => $offre_id, ':utilisateur_id' => $utilisateur_id]);
        }

        header("Location: /public/index.php?controller=candidature&action=wishlistList");
        exit();
    }

    // Méthode pour supprimer une offre de la wishlist
    public function wishlistRemove() {
        Middleware::checkEtudiantAdmin();
        
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=candidature&action=wishlistList");
            exit();
        }

        $id = $_GET['id'];
        $stmt = $this->pdo->prepare("DELETE FROM wishlist WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header("Location: /public/index.php?controller=candidature&action=wishlistList");
        exit();
    }

    // Méthode pour afficher la wishlist de l'utilisateur
    public function wishlistList() {
        Middleware::checkEtudiantAdmin();
        $utilisateur_id = $_SESSION['user']['id'];
        
        $stmt = $this->pdo->prepare("SELECT w.id, o.* FROM wishlist w INNER JOIN offres o ON w.offre_id = o.id WHERE w.utilisateur_id = :utilisateur_id");
        $stmt->execute([':utilisateur_id' => $utilisateur_id]);
        $offres = $stmt->fetchAll();

        $this->render('candidatures/wishlist', ['offres' => $offres]);
    }
}
