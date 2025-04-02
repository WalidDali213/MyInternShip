<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Database;

class OffreController extends Controller {

    // Méthode pour afficher la liste des offres
    public function list() {
        Middleware::checkAuth(); // accessible à tous les utilisateurs connectés
        global $pdo;
        
        $searchQuery = '';
        if (isset($_GET['search']) && trim($_GET['search']) !== '') {
            $searchQuery = trim($_GET['search']);
            $stmt = $pdo->prepare("SELECT o.*, e.nom AS entreprise_nom FROM offres o 
                                   INNER JOIN entreprises e ON o.entreprise_id = e.id 
                                   WHERE o.titre LIKE :query OR o.description LIKE :query OR o.competences LIKE :query");
            $stmt->execute([':query' => "%$searchQuery%"]);
        } else {
            $stmt = $pdo->query("SELECT o.*, e.nom AS entreprise_nom FROM offres o 
                                 INNER JOIN entreprises e ON o.entreprise_id = e.id");
        }
        $offres = $stmt->fetchAll();
        
        $this->render('offre/list', ['offres' => $offres, 'searchQuery' => $searchQuery]);
    }
    
    // Méthode pour afficher le formulaire d'édition et traiter la modification d'une offre
    public function edit() {
        // Vérifier l'accès : admin ou pilote uniquement
        Middleware::checkAdminOrPilote();
        global $pdo;
        
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=offre&action=list");
            exit();
        }
        $id = $_GET['id'];
        
        // Récupérer l'offre
        $stmt = $pdo->prepare("SELECT * FROM offres WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $offre = $stmt->fetch();
        if (!$offre) {
            die("Offre non trouvée.");
        }
        
        // Récupérer la liste des entreprises
        $stmtEntreprises = $pdo->query("SELECT id, nom FROM entreprises");
        $entreprises = $stmtEntreprises->fetchAll();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $entreprise_id = trim($_POST['entreprise_id']);
            $titre = trim($_POST['titre']);
            $description = trim($_POST['description']);
            $competences = trim($_POST['competences']);
            $base_remuneration = trim($_POST['base_remuneration']);
            $date_debut = trim($_POST['date_debut']);
            $date_fin = trim($_POST['date_fin']);
        
            if(empty($entreprise_id) || empty($titre) || empty($competences) || empty($base_remuneration) || empty($date_debut) || empty($date_fin)) {
                $error = "Tous les champs obligatoires doivent être renseignés.";
            } else {
                $stmt = $pdo->prepare("UPDATE offres SET entreprise_id = :entreprise_id, titre = :titre, description = :description, competences = :competences, base_remuneration = :base_remuneration, date_debut = :date_debut, date_fin = :date_fin WHERE id = :id");
                if($stmt->execute([
                    ':entreprise_id'   => $entreprise_id,
                    ':titre'           => $titre,
                    ':description'     => $description,
                    ':competences'     => $competences,
                    ':base_remuneration'=> $base_remuneration,
                    ':date_debut'      => $date_debut,
                    ':date_fin'        => $date_fin,
                    ':id'              => $id
                ])) {
                    header("Location: /public/index.php?controller=offre&action=list");
                    exit();
                } else {
                    $error = "Erreur lors de la mise à jour de l'offre.";
                }
            }
        }
        
        $this->render('offre/edit', [
            'offre' => $offre,
            'entreprises' => $entreprises,
            'error' => $error ?? null
        ]);
    }
    
    // Méthode pour supprimer une offre
    public function delete() {
        Middleware::checkAdminOrPilote();
        global $pdo;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM offres WHERE id = :id");
            $stmt->execute([':id' => $id]);
        }
        header("Location: /public/index.php?controller=offre&action=list");
        exit();
    }
    
    // Méthode pour afficher les statistiques des offres
    public function stats() {
        Middleware::checkAuth(); // Accessible à tous les utilisateurs connectés
        global $pdo;
        
        // Statistique 1 : Répartition par compétence
        $stmt = $pdo->query("SELECT competences FROM offres");
        $allCompetences = [];
        while ($row = $stmt->fetch()) {
            $competences = explode(',', $row['competences']);
            foreach ($competences as $comp) {
                $comp = trim($comp);
                if (!empty($comp)) {
                    if (!isset($allCompetences[$comp])) {
                        $allCompetences[$comp] = 0;
                    }
                    $allCompetences[$comp]++;
                }
            }
        }
        
        // Statistique 2 : Top des offres par nombre de postulants
        $stmt2 = $pdo->query("SELECT * FROM offres ORDER BY nb_postulants DESC LIMIT 5");
        $topOffres = $stmt2->fetchAll();
        
        $this->render('offre/stats', [
            'allCompetences' => $allCompetences,
            'topOffres' => $topOffres
        ]);
    }
    
    // Méthode pour afficher les détails d'une offre
    public function view() {
        Middleware::checkAuth(); // Accessible à tous les utilisateurs connectés
        global $pdo;
        if (!isset($_GET['id'])) {
            header("Location: /public/index.php?controller=offre&action=list");
            exit();
        }
        $id = $_GET['id'];
        
        $stmt = $pdo->prepare("SELECT o.*, e.nom AS entreprise_nom FROM offres o 
                               INNER JOIN entreprises e ON o.entreprise_id = e.id 
                               WHERE o.id = :id");
        $stmt->execute([':id' => $id]);
        $offre = $stmt->fetch();
        if (!$offre) {
            die("Offre non trouvée.");
        }
        
        $this->render('offre/view', ['offre' => $offre]);
    }
}
