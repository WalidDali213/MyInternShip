<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Étudiant | MyInternship</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/public/assets/globals.css">
  <link rel="stylesheet" href="/public/assets/styleguide.css">
  <link rel="stylesheet" href="/public/assets/style.css">
  <style>
    /* (Intégrez ici les styles déjà fournis) */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
    body { background: #f8f8f8; color: #333; }
    header.dashboard-header { background: linear-gradient(135deg, #007bff, #00c3ff); padding: 15px 0; text-align: center; color: white; }
    header.dashboard-header .logo a { font-size: 28px; font-weight: 700; color: white; text-decoration: none; }
    nav.nav-menu ul { list-style: none; display: flex; justify-content: center; margin-top: 10px; }
    nav.nav-menu ul li { margin: 0 15px; }
    nav.nav-menu ul li a { color: white; text-decoration: none; font-size: 18px; font-weight: 500; }
    .dashboard-container { display: flex; flex-wrap: wrap; margin: 20px auto; max-width: 1200px; background: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
    aside.sidebar { flex: 1 1 250px; background: #2c3e50; color: #ecf0f1; padding: 20px; }
    aside.sidebar ul { list-style: none; padding-left: 0; }
    aside.sidebar ul li { margin-bottom: 15px; }
    aside.sidebar ul li a { color: #ecf0f1; text-decoration: none; font-size: 16px; display: block; padding: 8px; border-radius: 4px; transition: background 0.3s; }
    aside.sidebar ul li a:hover { background: #34495e; }
    main.dashboard-main { flex: 3 1 750px; padding: 30px; }
    .dashboard-welcome { text-align: center; margin-bottom: 20px; }
    .dashboard-welcome h1 { font-size: 32px; color: #007bff; }
    .dashboard-welcome p { font-size: 16px; color: #555; }
    .dashboard-section { margin-bottom: 30px; }
    .dashboard-section h2 { margin-bottom: 20px; font-size: 24px; color: #555; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
    .dashboard-table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
    .dashboard-table thead { background: #007bff; color: white; }
    .dashboard-table th, .dashboard-table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    .dashboard-table tr:hover { background: #f1f1f1; }
    footer.dashboard-footer { background: #000; color: white; text-align: center; padding: 10px; position: fixed; bottom: 0; width: 100%; }
    footer.dashboard-footer p { font-size: 14px; }
    @media (max-width: 768px) { .dashboard-container { flex-direction: column; } aside.sidebar, main.dashboard-main { flex: 1 1 100%; } .dashboard-welcome h1 { font-size: 28px; } }
  </style>
</head>
<body>
  <header class="dashboard-header">
    <div class="container header-content">
      <div class="logo"><a href="/public/index.php">MyInternship</a></div>
      <nav class="nav-menu">
        <ul>
          <li><a href="/public/index.php?controller=dashboard&action=student">Tableau de bord</a></li>
          <li><a href="/public/index.php?controller=offre&action=list">Offres</a></li>
          <li><a href="/public/index.php?controller=candidature&action=list">Mes candidatures</a></li>
          <li><a href="/public/index.php?controller=profile&action=view">Profil</a></li>
          <li><a href="/public/index.php?controller=entreprise&action=eval">Entreprises</a></li>
          <li><a href="/public/index.php?controller=offre&action=list">Offres de stage</a></li>
          <li><a href="/public/index.php?controller=candidature&action=wishlist">Wish-list</a></li>
          <li><a href="/public/index.php?controller=auth&action=logout">Déconnexion</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="dashboard-container container">
    <aside class="sidebar">
      <ul>
        <li><a href="/public/index.php?controller=candidature&action=list">Mes candidatures</a></li>
        <li><a href="/public/index.php?controller=stage&action=current">Mes stages en cours</a></li>
        <li><a href="/public/index.php?controller=stage&action=history">Historique</a></li>
        <li><a href="/public/index.php?controller=message&action=list">Messages</a></li>
      </ul>
    </aside>
    <main class="dashboard-main">
      <div class="dashboard-welcome">
        <h1>Bonjour, <?= htmlspecialchars($_SESSION['user']['prenom']); ?></h1>
        <p>Trouvez le stage qui vous correspond et suivez vos candidatures en temps réel.</p>
      </div>
      <section class="dashboard-section">
        <h2>Résumé de vos candidatures</h2>
        <table class="dashboard-table">
          <thead>
            <tr>
              <th>Offre</th>
              <th>Entreprise</th>
              <th>Statut</th>
              <th>Date de candidature</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($candidatures) > 0): ?>
              <?php foreach ($candidatures as $cand): ?>
                <tr>
                  <td><?= htmlspecialchars($cand['titre']); ?></td>
                  <td><?= htmlspecialchars($cand['entreprise']); ?></td>
                  <td><?= 'En attente'; // Vous pouvez remplacer par le vrai statut ?></td>
                  <td><?= htmlspecialchars($cand['date_candidature']); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" style="text-align:center;">Aucune candidature trouvée.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
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
