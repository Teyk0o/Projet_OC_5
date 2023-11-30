<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Les articles - Théo Vilain</title>
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
        <!-- <img src="assets/img/logo.png" alt=""> -->
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
        if (isset($userInfos) && !empty($userInfos)) {
          if ($userInfos->getRole() === "admin") {
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

    <section id="search-result" class="search-result">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
            <h3 class="category-title">Articles</h3>
            <?php 
            foreach($articles as $article) {
              $articleDate = new DateTime($article->getLastModified());
              $formattedArticleDate = $articleDate->format('d M Y');

              echo '<div class="d-md-flex post-entry-2 small-img">
                <a href="/article/'.htmlspecialchars($article->getSlug(), ENT_QUOTES, 'UTF-8').'" class="me-4 thumbnail">
                  <img src="assets/img/illu-post.jpg" alt="" class="img-fluid">
                </a>
                <div>
                  <div class="post-meta"><span class="mx-1">&bullet;</span> <span>'.htmlspecialchars($formattedArticleDate, ENT_QUOTES, 'UTF-8').'</span></div>
                  <h3><a href="/article/'.htmlspecialchars($article->getSlug(), ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($article->getTitle(), ENT_QUOTES, 'UTF-8').'</a></h3>
                  <p>'.htmlspecialchars($article->getChapo(), ENT_QUOTES, 'UTF-8').'</p>
                </div>
              </div>';
            }
            ?>
          </div>

          <div class="col-md-3">
            <!-- ======= Sidebar ======= -->
            <div class="aside-block">

              <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill" data-bs-target="#pills-popular" type="button" role="tab" aria-controls="pills-popular" aria-selected="true">+ commentés</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">+ récents</button>
                </li>
              </ul>

              <div class="tab-content" id="pills-tabContent">

                <!-- Popular -->
                <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
                    <?php 
                        foreach($mostCommentedArticles as $article) {
                            $articleDate = new DateTime($article->getLastModified());
                            $formattedArticleDate = $articleDate->format('d M Y');

                            echo '<div class="post-entry-1 border-bottom">
                                <div class="post-meta"><span class="mx-1">&bullet;</span> <span>'.htmlspecialchars($formattedArticleDate, ENT_QUOTES, 'UTF-8').'</span></div>
                                <h2 class="mb-2"><a href="/article/'.htmlspecialchars($article->getSlug(), ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($article->getTitle(), ENT_QUOTES, 'UTF-8').'</a></h2>
                            </div>';
                        }
                    ?>
                </div> <!-- End Popular -->

                <!-- Trending -->
                <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">

                  <?php 
                  foreach($lastArticles as $article) {
                    $articleDate = new DateTime($article->getLastModified());
                    $formattedArticleDate = $articleDate->format('d M Y');

                    echo '<div class="post-entry-1 border-bottom">
                        <div class="post-meta"><span class="mx-1">&bullet;</span> <span>'.htmlspecialchars($formattedArticleDate, ENT_QUOTES, 'UTF-8').'</span></div>
                        <h2 class="mb-2"><a href="/article/'.htmlspecialchars($article->getSlug(), ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($article->getTitle(), ENT_QUOTES, 'UTF-8').'</a></h2>
                    </div>';
                  }
                  
                  ?>
                </div> <!-- End Trending -->

              </div>
            </div>
          </div>

        </div>
      </div>
    </section> <!-- End Search Result -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
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
                  foreach ($articleFooter as $article) {
                    $footerArticleDate = new DateTime($article->getLastModified());
                    $formattedfooterArticleDate = $footerArticleDate->format('d M Y');

                    echo '<li>
                      <a href="/article/'.htmlspecialchars($article->getSlug(), ENT_QUOTES, 'UTF-8').'" class="d-flex align-items-center">
                        <img src="assets/img/illu-post.jpg" alt="" class="img-fluid me-3">
                        <div>
                          <div class="post-meta d-block"> <span class="mx-1">&bullet;</span> <span>'.htmlspecialchars($formattedfooterArticleDate, ENT_QUOTES, 'UTF-8').'</span></div>
                          <span>'.htmlspecialchars($article->getTitle(), ENT_QUOTES, 'UTF-8').'</span>
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
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>