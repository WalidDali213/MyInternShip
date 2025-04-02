<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>MyIntership - Trouvez votre stage</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/public/assets/globals.css" />
    <link rel="stylesheet" href="/public/assets/styleguide.css" />
    <link rel="stylesheet" href="/public/assets/style.css" />
</head>
<body>
    <header class="site-header">
      <div class="container header-content">
        <div class="logo">
          <a href="/public/index.php?controller=home&action=index">MyIntership</a>
        </div>
        <nav class="nav-menu">
          <ul>
            <li><a href="/public/index.php?controller=home&action=index">Accueil</a></li>
            <li><a href="/public/index.php?controller=offre&action=list">Offres</a></li>
            <li><a href="/public/index.php?controller=entreprise&action=index">Entreprises</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <section class="hero">
      <div class="container hero-content">
        <h1>Plus de 100 000 offres de stage partout à travers le monde</h1>
        <p>Une nouvelle façon de trouver votre voie.</p>
        <button class="btn btn-primary">Trouver un stage</button>
      </div>
    </section>

    <section class="features">
      <div class="container features-grid">
        <div class="feature-card">
          <img src="/public/assets/img/entreprise.jpg" alt="Entreprise" />
          <h2>Entreprise ?</h2>
          <p>Déposez facilement vos offres et trouvez rapidement les talents de demain.</p>
          <a href="#" class="btn btn-secondary">En savoir plus</a>
        </div>
        <div class="feature-card">
          <img src="/public/assets/img/pilote.jpg" alt="Pilote de promotion" />
          <h2>Pilote de promotion ?</h2>
          <p>Suivez en temps réel les candidatures de vos étudiants et facilitez leur insertion.</p>
          <a href="#" class="btn btn-secondary">En savoir plus</a>
        </div>
        <div class="feature-card">
          <img src="/public/assets/img/etudiant.jpg" alt="Étudiant" />
          <h2>Étudiant ?</h2>
          <p>Explorez les opportunités et trouvez l’offre la plus adaptée à vos compétences.</p>
          <a href="#" class="btn btn-secondary">En savoir plus</a>
        </div>
      </div>
    </section>

    <section class="call-to-action">
      <div class="container cta-content">
        <h2>Prêt à démarrer votre carrière ?</h2>
        <button class="btn btn-primary">Voir toutes les offres</button>
      </div>
    </section>

    <footer class="site-footer">
      <div class="container footer-content">
        <div class="footer-links">
          <h3>MyIntership</h3>
          <ul>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Mentions légales</a></li>
            <li><a href="#">Politique de confidentialité</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h3>Ressources</h3>
          <ul>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Aide</a></li>
            <li><a href="#">Support</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h3>Contact</h3>
          <ul>
            <li><a href="#">Nous contacter</a></li>
            <li><a href="#">Rejoindre l’équipe</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 MyIntership. Tous droits réservés.</p>
      </div>
    </footer>
</body>
</html>
