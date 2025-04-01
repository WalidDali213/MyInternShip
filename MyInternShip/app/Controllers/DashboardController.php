<?php
// Assurez-vous que votre autoload (via Composer ou config/autoload.php) est activé.
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/Middleware.php'; // Pour utiliser Middleware
// Vous aurez aussi besoin d'inclure votre connexion PDO via Database.php :
require_once __DIR__ . '/../Models/Database.php';

class DashboardController extends Controller {
    
    // Méthode pour le dashboard administrateur
    public function admin() {
        // Vérifier que l'utilisateur est administrateur
        Middleware::checkAdmin();

        // Récupération des statistiques (nous utilisons ici la variable $pdo créée dans Database.php)
        global $pdo;
        $entreprisesCount = $pdo->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
        $offresCount = $pdo->query("SELECT COUNT(*) FROM offres")->fetchColumn();
        $utilisateursCount = $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();

        // Renvoyer à la vue (nous allons créer la vue dashboard/admin_dashboard.php)
        $this->render('dashboard/admin_dashboard', [
            'entreprisesCount' => $entreprisesCount,
            'offresCount' => $offresCount,
            'utilisateursCount' => $utilisateursCount
        ]);
    }

    // Méthode pour le dashboard étudiant
    public function student() {
        // Vérifier que l'utilisateur est bien un étudiant
        if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] !== 'etudiant') {
            header("Location: /public/index.php?controller=auth&action=login");
            exit();
        }

        global $pdo;
        $utilisateur_id = $_SESSION['user']['id'];
        $stmt = $pdo->prepare("SELECT c.date_candidature, o.titre, e.nom AS entreprise
                            FROM candidatures c 
                            INNER JOIN offres o ON c.offre_id = o.id 
                            INNER JOIN entreprises e ON o.entreprise_id = e.id 
                            WHERE c.utilisateur_id = :uid
                            ORDER BY c.date_candidature DESC");
        $stmt->execute([':uid' => $utilisateur_id]);
        $candidatures = $stmt->fetchAll();

        $this->render('dashboard/student_dashboard', ['candidatures' => $candidatures]);
    }
}
?>
