<?php
session_start();
require_once 'Database.php';
require_once 'check_auth.php';

// Vérifier que l'utilisateur est bien un pilote (ou, selon vos règles, un pilote de promotion)
if ($_SESSION['user']['statut'] !== 'pilote') {
    header("Location: index.php");
    exit();
}

// Exemple de récupération dynamique des statistiques et demandes
// Remplacez ces exemples par vos requêtes SQL adaptées à votre base
$nombreDemandes = 10; // Exemple : nombre total de demandes de stage récentes
$demandes = [
  ['etudiant' => 'Étudiant A', 'offre' => 'Stage Développeur', 'entreprise' => 'Entreprise A', 'statut' => 'En attente', 'date' => '12/03/2025'],
  ['etudiant' => 'Étudiant B', 'offre' => 'Stage Marketing', 'entreprise' => 'Entreprise B', 'statut' => 'Accepté', 'date' => '09/03/2025']
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Pilote de Promotion | MyInternship</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Liens vers vos CSS globaux si existants -->
  <link rel="stylesheet" href="globals.css">
  <link rel="stylesheet" href="styleguide.css">
  <link rel="stylesheet" href="style.css">
  <!-- CSS spécifique pour le dashboard -->
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    body {
      background: #f8f8f8;
      color: #333;
    }
    header.dashboard-header {
      background: linear-gradient(135deg, #FF9800, #FFC107);
      padding: 15px 0;
      text-align: center;
      color: white;
    }
    header.dashboard-header .logo a {
      font-size: 28px;
      font-weight: 700;
      color: white;
      text-decoration: none;
    }
    nav.nav-menu ul {
      list-style: none;
      display: flex;
      justify-content: center;
      margin-top: 10px;
    }
    nav.nav-menu ul li {
      margin: 0 15px;
    }
    nav.nav-menu ul li a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      font-weight: 500;
    }
    .dashboard-container {
      display: flex;
      flex-wrap: wrap;
      margin: 20px auto;
      max-width: 1200px;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    aside.sidebar {
      flex: 1 1 250px;
      background: #2c3e50;
      color: #ecf0f1;
      padding: 20px;
    }
    aside.sidebar ul {
      list-style: none;
      padding-left: 0;
    }
    aside.sidebar ul li {
      margin-bottom: 15px;
    }
    aside.sidebar ul li a {
      color: #ecf0f1;
      text-decoration: none;
      font-size: 16px;
      display: block;
      padding: 8px;
      border-radius: 4px;
      transition: background 0.3s;
    }
    aside.sidebar ul li a:hover {
      background: #34495e;
    }
    main.dashboard-main {
      flex: 3 1 750px;
      padding: 30px;
    }
    .dashboard-welcome {
      text-align: center;
      margin-bottom: 20px;
    }
    .dashboard-welcome h1 {
      font-size: 32px;
      color: #FF9800;
    }
    .dashboard-section {
      margin-bottom: 30px;
    }
    .dashboard-section h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #555;
      border-bottom: 2px solid #ddd;
      padding-bottom: 10px;
    }
    .dashboard-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }
    .dashboard-table thead {
      background: #FF9800;
      color: white;
    }
    .dashboard-table th, .dashboard-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }
    .dashboard-table tr:hover {
      background: #f1f1f1;
    }
    footer.dashboard-footer {
      background: #000;
      color: white;
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    footer.dashboard-footer p {
      font-size: 14px;
    }
    /* Responsive */
    @media (max-width: 768px) {
      .dashboard-container {
        flex-direction: column;
      }
      aside.sidebar, main.dashboard-main {
        flex: 1 1 100%;
      }
      .dashboard-welcome h1 {
        font-size: 28px;
      }
    }
  </style>
</head>
<body>
  <header class="dashboard-header">
    <div class="container header-content">
      <div class="logo"><a href="index.php">MyInternship</a></div>
      <nav class="nav-menu">
        <ul>
          <li><a href="pilot-dashboard.php">Tableau de bord</a></li>
          <li><a href="demandes.php">Demandes de stage</a></li>
          <li><a href="profile.php">Profil</a></li>
          <li><a href="offresList.php">offres</a></li>
          <li><a href="entrepriseList.php">Gestion des entreprises</a></li>
          <li><a href="candidatureList.php">Gestion des candidatures</a></li>
          <li><a href="logout.php">Déconnexion</a></li>

          

        </ul>
      </nav>
    </div>
  </header>

  <div class="dashboard-container container">
    <aside class="sidebar">
      <ul>
        <li><a href="pilot-dashboard.php">Demandes récentes</a></li>
        <li><a href="stats.php">Statistiques</a></li>
        <li><a href="messages.php">Messages</a></li>
        <li><a href="settings.php">Paramètres</a></li>
      </ul>
    </aside>
    <main class="dashboard-main">
      <div class="dashboard-welcome">
        <h1>Bonjour, <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?></h1>
        <p>Suivez et gérez les demandes de stage de vos étudiants.</p>
      </div>
      <section class="dashboard-section">
        <h2>Suivi des demandes de stage</h2>
        <table class="dashboard-table">
          <thead>
            <tr>
              <th>Étudiant</th>
              <th>Offre</th>
              <th>Entreprise</th>
              <th>Statut</th>
              <th>Date de candidature</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($demandes as $demande): ?>
            <tr>
              <td><?php echo htmlspecialchars($demande['etudiant']); ?></td>
              <td><?php echo htmlspecialchars($demande['offre']); ?></td>
              <td><?php echo htmlspecialchars($demande['entreprise']); ?></td>
              <td><?php echo htmlspecialchars($demande['statut']); ?></td>
              <td><?php echo htmlspecialchars($demande['date']); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
      <!-- Vous pouvez ajouter d'autres sections, comme un résumé statistique ou des graphiques dynamiques. -->
    </main>
  </div>

  <footer class="dashboard-footer">
    <div class="container">
      <p>&copy; 2025 MyInternship. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>
