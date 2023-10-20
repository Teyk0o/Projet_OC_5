<?php
require '../assets/php/Articles.php';

session_start();

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$articlesInstance = new Articles($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

$footerArticles = $articlesInstance->getRecentArticles(4);

$comments = $articlesInstance->getAllCommentsPendingApproval();


if (isset($_SESSION) && isset($_SESSION['id'])) {
  $userInfos = $articlesInstance->getAuthorById($_SESSION['id']);

  if ($userInfos['role'] === "admin") {
    $articles = $articlesInstance->getAllArticles();
  } else {
    header('Location: /auth');
  }
} else {
  header('Location: /auth');
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Administration - Théo Vilain</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
  <link rel="manifest" href="site.webmanifest">
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

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

        <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
          <form action="" class="search-form">
            <span class="icon bi-search"></span>
            <input type="text" placeholder="Rechercher un article" class="form-control">
            <button class="btn js-search-close"><span class="bi-x"></span></button>
          </form>
        </div><!-- End Search Form -->

      </div>

    </div>

  </header><!-- End Header -->
  <main id="main">

    <div class="container mt-5">
      <div class="row justify-content-center">
          <div class="col-md-10">
              <h1 class="text-center mb-4 mt-4">Gestion des articles</h1>
              <div class="d-flex justify-content-end mb-3">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addArticleModal">Ajouter un article</a>
              </div>
              <table class="table table-bordered table-hover mb-5">
                  <thead class="thead-dark">
                      <tr>
                          <th>Titre</th>
                          <th>Dernières modifications</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($articles as $article): ?>
                          <tr>
                              <td><?= $article['title'] ?></td>
                              <td><?= $article['last_modified'] ?></td>
                              <td>
                                  <a href="#" class="btn btn-warning btn-sm" data-article-id="<?= $article['id'] ?>" data-toggle="modal" data-target="#modifyArticleModal">Modifier</a>
                                  <a href="#" class="btn btn-danger btn-sm" data-article-id="<?= $article['id'] ?>" data-toggle="modal" data-target="#deleteArticleModal">Supprimer</a>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
    <div class="container mt-5">
      <div class="row justify-content-center">
          <div class="col-md-10">
              <h1 class="text-center mb-4 mt-4">Gestion des commentaires en attente</h1>
              <table class="table table-bordered table-hover mb-5">
                  <thead class="thead-dark">
                      <tr>
                          <th>Contenu</th>
                          <th>Auteur</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($comments as $comment): 
                        $author = $articlesInstance->getAuthorById($comment['author_id']);
                        ?>
                          <tr>
                              <td><?= $comment['content'] ?></td>
                              <td><?= $author['username'] ?></td>
                              <td>
                                  <a href="#" class="btn btn-success btn-sm" data-comment-id="<?= $comment['id'] ?>" id="approveComment">Approuver</a>
                                  <a href="#" class="btn btn-danger btn-sm" data-comment-id="<?= $comment['id'] ?>" id="disapproveComment">Désapprouver</a>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </main>
  <div class="modal fade" id="addArticleModal" tabindex="-1" role="dialog" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Ajouter un article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="addArticleForm" method="post">
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="chapo">Chapô</label>
                        <input type="text" class="form-control" id="chapo" name="chapo" required>
                    </div>
                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Créer l'article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  <!-- Modal pour la modification d'un article -->
  <div class="modal fade" id="modifyArticleModal" tabindex="-1" aria-labelledby="modifyArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modifyArticleModalLabel">Modifier l'article</h5>
        </div>
        <div class="modal-body">
          <form id="modifyArticleForm">
            <input type="hidden" id="modify-article-id" name="article_id">
            <div class="mb-3">
              <label for="modify-title" class="form-label">Titre</label>
              <input type="text" class="form-control" id="modify-title" name="title" required>
            </div>
            <div class="mb-3">
              <label for="modify-chapo" class="form-label">Chapô</label>
              <input type="text" class="form-control" id="modify-chapo" name="chapo" required>
            </div>
            <div class="mb-3">
              <label for="modify-content" class="form-label">Contenu</label>
              <textarea class="form-control" id="modify-content" name="content" rows="4" required></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary">Modifier l'article</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteArticleModalLabel">Supprimer l'article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Êtes-vous sûr de vouloir supprimer cet article ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Confirmer</button>
        </div>
      </div>
    </div>
  </div>

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    $('.modal').on('hidden.bs.modal', function (e) {
      $('.modal-backdrop').remove();
    });
  </script>
               
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/admin.js"></script>

</body>

</html>