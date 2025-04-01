<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Administrateur | MyInternship</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/public/assets/globals.css" />
  <link rel="stylesheet" href="/public/assets/styleguide.css" />
  <link rel="stylesheet" href="/public/assets/style.css" />
  <style>
    /* Styles repris depuis votre code initial */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body { background: #f8f8f8; color: #333; }
    header.dashboard-header { background: linear-gradient(135deg, #FFC107, #FFEB3B); padding: 15px 0; text-align: center; }
    header.dashboard-header .logo a { font-size: 28px; font-weight: 700; color: #333; text-decoration: none; }
    nav.nav-menu ul { list-style: none; display: flex; justify-content: center; margin-top: 10px; }
    nav.nav-menu ul li { margin: 0 15px; }
    nav.nav-menu ul li a { color: #333; text-decoration: none; font-size: 18px; font-weight: 500; }
    .dashboard-container { display: flex; flex-wrap: wrap; margin: 20px auto; max-width: 1200px; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
    aside.sidebar { flex: 1 1 250px; background: #2c3e50; color: #ecf0f1; padding: 20px; }
    aside.sidebar ul { list-style: none; }
    aside.sidebar ul li { margin-bottom: 15px; }
    aside.sidebar ul li a { color: #ecf0f1; text-decoration: none; font-size: 16px; }
    main.dashboard-main { flex: 3 1 750px; padding: 30px; }
    main.dashboard-main h1 { margin-bottom: 20px; font-size: 32px; color: #333; }
    .dashboard-section { margin-bottom: 30px; }
    .dashboard-section h2 { margin-bottom: 20px; font-size: 24px; color: #555; }
    .stats-grid { display: flex; flex-wrap: wrap; gap: 20px; }
    .stat-card { background: #f0f0f0; flex: 1; min-width: 200px; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .stat-card h3 { font-size: 20px; margin-bottom: 10px; color: #333; }
    .stat-card p { font-size: 26px; font-weight: 600; color: #FF5722; }
    footer.dashboard-footer { background: #000; color: #fff; text-align: center; padding: 10px 0; position: fixed; bottom: 0; width: 100%; }
    footer.dashboard-footer p { font-size: 14px; }
    @media (max-width: 768px) { .dashboard-container { flex-direction: column; } aside.sidebar, main.dashboard-main { flex: 1 1 100%; } }
  </style>
</head>
<body>
  <header class="dashboard-header">
    <div class="container header-content">
      <div class="logo"><a href="/public/index.php">MyInternship</a></div>
      <nav class="nav-menu">
        <ul>
          <li><a href="/public/index.php?controller=dashboard&action=admin">Dashboard</a></li>
          <li><a href="/public/index.php?controller=entreprise&action=index">Entreprises</a></li>
          <li><a href="/public/index.php?controller=offre&action=index">Offres</a></li>
          <li><a href="/public/index.php?controller=user&action=index">Utilisateurs</a></li>
          <li><a href="/public/index.php?controller=auth&action=logout">Déconnexion</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="dashboard-container container">
    <aside class="sidebar">
      <ul>
        <li><a href="/public/index.php?controller=dashboard&action=admin">Résumé</a></li>
        <li><a href="/public/index.php?controller=dashboard&action=stats">Statistiques globales</a></li>
        <li><a href="/public/index.php?controller=entreprise&action=index">Gestion entreprises</a></li>
        <li><a href="/public/index.php?controller=offre&action=index">Gestion offres</a></li>
        <li><a href="/public/index.php?controller=user&action=index">Gestion utilisateurs</a></li>
      </ul>
    </aside>
    <main class="dashboard-main">
      <h1>Bienvenue, Administrateur</h1>
      <section class="dashboard-section">
        <h2>Vue d'ensemble</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <h3>Entreprises inscrites</h3>
            <p><?= htmlspecialchars($entreprisesCount); ?></p>
          </div>
          <div class="stat-card">
            <h3>Offres de stage</h3>
            <p><?= htmlspecialchars($offresCount); ?></p>
          </div>
          <div class="stat-card">
            <h3>Utilisateurs actifs</h3>
            <p><?= htmlspecialchars($utilisateursCount); ?></p>
          </div>
        </div>
      </section>
    </main>
  </div>

  <footer class="dashboard-footer">
    <div class="container">
      <p>&copy; 2025 MyInternship. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>
