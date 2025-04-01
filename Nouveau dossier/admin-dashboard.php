<?php
session_start();
require_once 'Database.php';
require_once 'check_auth.php';

// Vérification du rôle administrateur
if ($_SESSION['user']['statut'] !== 'administrateur') {
    header("Location: index.php");
    exit();
}

// Récupération dynamique des statistiques
$entreprisesCount = $pdo->query("SELECT COUNT(*) FROM entreprises")->fetchColumn();
$offresCount = $pdo->query("SELECT COUNT(*) FROM offres")->fetchColumn();
$utilisateursCount = $pdo->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Administrateur | MyInternship</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <!-- CSS Global -->
  <link rel="stylesheet" href="globals.css" />
  <link rel="stylesheet" href="styleguide.css" />
  <link rel="stylesheet" href="style.css" />
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
      background: linear-gradient(135deg, #FFC107, #FFEB3B);
      padding: 15px 0;
      text-align: center;
    }
    header.dashboard-header .logo a {
      font-size: 28px;
      font-weight: 700;
      color: #333;
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
      color: #333;
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
    }
    aside.sidebar ul li {
      margin-bottom: 15px;
    }
    aside.sidebar ul li a {
      color: #ecf0f1;
      text-decoration: none;
      font-size: 16px;
    }
    main.dashboard-main {
      flex: 3 1 750px;
      padding: 30px;
    }
    main.dashboard-main h1 {
      margin-bottom: 20px;
      font-size: 32px;
      color: #333;
    }
    .dashboard-section {
      margin-bottom: 30px;
    }
    .dashboard-section h2 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #555;
    }
    .stats-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    .stat-card {
      background: #f0f0f0;
      flex: 1;
      min-width: 200px;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .stat-card h3 {
      font-size: 20px;
      margin-bottom: 10px;
      color: #333;
    }
    .stat-card p {
      font-size: 26px;
      font-weight: 600;
      color: #FF5722;
    }
    footer.dashboard-footer {
      background: #000;
      color: #fff;
      text-align: center;
      padding: 10px 0;
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
    }
  </style>
</head>
<body>
  <header class="dashboard-header">
    <div class="container header-content">
      <div class="logo"><a href="index.php">MyInternship</a></div>
      <nav class="nav-menu">
        <ul>
          <li><a href="admin-dashboard.php">Dashboard</a></li>
          <li><a href="companies.php">Entreprises</a></li>
          <li><a href="offers.php">Offres</a></li>
          <li><a href="users.php">Utilisateurs</a></li>
          <li><a href="logout.php">Déconnexion</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="dashboard-container container">
    <aside class="sidebar">
      <ul>
        <li><a href="admin-dashboard.php">Résumé</a></li>
        <li><a href="stats.php">Statistiques globales</a></li>
        <li><a href="companies.php">Gestion entreprises</a></li>
        <li><a href="offers.php">Gestion offres</a></li>
        <li><a href="users.php">Gestion utilisateurs</a></li>
      </ul>
    </aside>
    <main class="dashboard-main">
      <h1>Bienvenue, Administrateur</h1>
      <section class="dashboard-section">
        <h2>Vue d'ensemble</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <h3>Entreprises inscrites</h3>
            <p><?php echo htmlspecialchars($entreprisesCount); ?></p>
          </div>
          <div class="stat-card">
            <h3>Offres de stage</h3>
            <p><?php echo htmlspecialchars($offresCount); ?></p>
          </div>
          <div class="stat-card">
            <h3>Utilisateurs actifs</h3>
            <p><?php echo htmlspecialchars($utilisateursCount); ?></p>
          </div>
        </div>
      </section>
      <!-- Vous pouvez ajouter d'autres sections ici (graphes, liste récentes, etc.) -->
    </main>
  </div>

  <footer class="dashboard-footer">
    <div class="container">
      <p>&copy; 2025 MyInternship. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>
