<?php
require '../vendor/autoload.php';
require '../assets/php/Articles.php';

session_start();

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$articlesInstance = new Articles($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

$footerArticles = $articlesInstance->getRecentArticles(4);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Authentification - Théo Vilain</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="assets/css/variables.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="../assets/img/logo.png" alt=""> -->
        <h1>Théo Vilain</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="/">Accueil</a></li>
          <li><a href="/articles">Les articles</a></li>
          <li><a href="/a-propos">À propos</a></li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <?php 
        if (isset($_SESSION) && isset($_SESSION['id'])) {
          $userInfos = $articlesInstance->getAuthorById($_SESSION['id']);

          if ($userInfos['role'] === "admin") {
            echo '<a href="/admin" class="mx-2"><span class="bi-pencil-fill"></span></a>';
            echo '<a href="/auth" class="mx-2"><span class="bi-person-fill"></span></a>';
          } else {
            echo '<a href="/auth" class="mx-2"><span class="bi-person-fill"></span></a>';
          }
        } else {
          echo '<a href="/auth" class="mx-2"><span class="bi-person-fill"></span></a>';
        }
        ?>
        <a href="https://github.com/Teyk0o" target="_blank" class="mx-2"><span class="bi-github"></span></a>
        <a href="https://www.linkedin.com/in/th%C3%A9o-vilain/" target="_blank" class="mx-2"><span class="bi-linkedin"></span></a>

        <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
        <i class="bi bi-list mobile-nav-toggle"></i>

      </div>

    </div>

  </header><!-- End Header -->
  <main id="main">
    <div class="container form-container">
        <div class="row">
            <!-- Formulaire de Connexion -->
            <div class="col-md-6 mb-5 mt-5">
                <h3>Connexion</h3>
                <form action="" method="post" id="loginForm">
                    <div class="form-group">
                        <label for="loginEmail">Email:</label>
                        <input type="email" class="form-control" id="loginEmail" placeholder="Entrez votre email" name="email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="loginPwd">Mot de passe:</label>
                        <input type="password" class="form-control" id="loginPwd" placeholder="Entrez votre mot de passe" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
                </form>
                <?php 
                if (isset($_SESSION) && isset($_SESSION['id'])) {
                    echo '<button class="btn btn-danger mt-3" id="logout">Se déconnecter</button>';
                }
                ?>
            </div>

            <!-- Formulaire d'Inscription -->
            <div class="col-md-6 mb-5 mt-5">
                <h3>Inscription</h3>
                <form action="" method="post" id="registerForm">
                <div class="form-group">
                        <label for="registerUsername">Nom d'utilisateur:</label>
                        <input type="text" class="form-control" id="registerUsername" placeholder="Entrez votre nom d'utilisateur" name="username" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="registerEmail">Email:</label>
                        <input type="email" class="form-control" id="registerEmail" placeholder="Entrez votre email" name="email" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="registerPwd">Mot de passe:</label>
                        <input type="password" class="form-control" id="registerPwd" placeholder="Entrez votre mot de passe" name="password" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="registerPwdConfirm">Confirmez le mot de passe:</label>
                        <input type="password" class="form-control" id="registerPwdConfirm" placeholder="Confirmez votre mot de passe" name="password_confirm" required>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
  </main>
  <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">

        <div class="row g-5">
          <div class="col-lg-4">
            <h3 class="footer-heading">À propos de Théo Vilain</h3>
            <p>Jeune développeur back-end développant depuis déjà plus de 10 ans passionné par l'informatique, l'aérospatial et l'aéronautique et souhaitant entrer dans le secteur de l'aérospatial.</p>
            <p><a href="/a-propos" class="footer-link-more">En savoir plus</a></p>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">
              <li><a href="/"><i class="bi bi-chevron-right"></i> Accueil</a></li>
              <li><a href="/articles"><i class="bi bi-chevron-right"></i> Les articles</a></li>
              <li><a href="/auth"><i class="bi bi-chevron-right"></i> Connexion / Inscription</a></li>
              <li><a href="/a-propos"><i class="bi bi-chevron-right"></i> À propos</a></li>
              <li><a href="/admin"><i class="bi bi-chevron-right"></i> Espace administration</a></li>
            </ul>
          </div>
          <div class="col-lg-4">
            <h3 class="footer-heading">Articles récents</h3>

            <ul class="footer-links footer-blog-entry list-unstyled">

                <?php 
                  foreach ($footerArticles as $articleFooter) {
                    $footerArticleDate = new DateTime($articleFooter['last_modified']);
                    $formattedfooterArticleDate = $footerArticleDate->format('d M Y');

                    echo '<li>
                      <a href="/article/'.htmlspecialchars($articleFooter['slug'], ENT_QUOTES, 'UTF-8').'" class="d-flex align-items-center">
                        <img src="assets/img/illu-post.jpg" alt="" class="img-fluid me-3">
                        <div>
                          <div class="post-meta d-block"> <span class="mx-1">&bullet;</span> <span>'.htmlspecialchars($formattedfooterArticleDate, ENT_QUOTES, 'UTF-8').'</span></div>
                          <span>'.htmlspecialchars($articleFooter['title'], ENT_QUOTES, 'UTF-8').'</span>
                        </div>
                      </a>
                    </li>';
                  }
                ?>

            </ul>

          </div>
        </div>
      </div>
    </div>

    <div class="footer-legal">
      <div class="container">

        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span>Théo Vilain</span></strong>. All Rights Reserved
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>

          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="https://github.com/Teyk0o" target="_blank" class="github"><i class="bi bi-github"></i></a>
              <a href="https://www.linkedin.com/in/th%C3%A9o-vilain/" target="_blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>

      </div>
    </div>

  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/auth.js"></script>

</body>

</html>