<?php
require 'assets/php/Articles.php';

session_start();
$nonce = bin2hex(random_bytes(16));
$_SESSION['nonce'] = $nonce;

$articlesInstance = new Articles();
$randomArticle = $articlesInstance->getRandomArticle();
$allArticles = $articlesInstance->getRecentArticles(6);

$footerArticles = $articlesInstance->getRecentArticles(4);

$randomArticleDate = new DateTime($randomArticle['last_modified']);
$formattedRandomArticleDate = $randomArticleDate->format('d M Y');
$trimmedRandomArticleContent = substr($randomArticle['content'], 0, 360);
if (strlen($randomArticle['content']) > 250) {
    $trimmedRandomArticleContent .= "...";
}

$articlesCount = 0;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Mon blog PHP - Théo Vilain</title>
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

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>Théo Vilain</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.html">Les articles</a></li>
          <li><a href="about.html">À propos</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <a href="#" class="mx-2"><span class="bi-person-fill"></span></a>
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

    <!-- ======= Hero Slider Section ======= -->
    <section id="hero-slider" class="hero-slider">
      <div class="container-md" data-aos="fade-in">
        <div class="row">
          <div class="col-12">
            <div class="swiper sliderFeaturedPosts">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <a class="img-bg d-flex align-items-end" style="background-image: url('assets/img/post-slide-1.jpg');">
                    <div class="img-bg-inner">
                      <h2>Théo Vilain c'est...</h2>
                      <p>...un développeur back-end avec une décennie d'expérience, prêt à propulser l'aérospatial vers de nouveaux sommets.</p>
                    </div>
                  </a>
                </div>

                <div class="swiper-slide">
                  <a class="img-bg d-flex align-items-end" style="background-image: url('assets/img/post-slide-2.jpg');">
                    <div class="img-bg-inner">
                      <h2>Théo Vilain c'est...</h2>
                      <p>...un passionné d'informatique et d'aéronautique qui fusionne technologie et ciel pour des solutions innovantes.</p>
                    </div>
                  </a>
                </div>

                <div class="swiper-slide">
                  <a class="img-bg d-flex align-items-end" style="background-image: url('assets/img/post-slide-3.jpg');">
                    <div class="img-bg-inner">
                      <h2>Théo Vilain c'est...</h2>
                      <p>...dix ans dans le développement back-end, avec un œil tourné vers les étoiles et l'aérospatial.</p>
                    </div>
                  </a>
                </div>

                <div class="swiper-slide">
                  <a class="img-bg d-flex align-items-end" style="background-image: url('assets/img/post-slide-4.jpg');">
                    <div class="img-bg-inner">
                      <h2>Théo Vilain c'est...</h2>
                      <p>...naviguant entre codes et nuages, le développeur back-end qui rêve d'innover dans l'aérospatial.</p>
                    </div>
                  </a>
                </div>
              </div>
              <div class="custom-swiper-button-next">
                <span class="bi-chevron-right"></span>
              </div>
              <div class="custom-swiper-button-prev">
                <span class="bi-chevron-left"></span>
              </div>

              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Hero Slider Section -->

    <!-- ======= Post Grid Section ======= -->
    <section id="posts" class="posts">
      <div class="container" data-aos="fade-up">
        <div class="row g-5">
          <div class="col-lg-4">
            <div class="post-entry-1 lg">
              <a href="single-post.html"><img src="assets/img/illu-post.jpg" alt="" class="img-fluid"></a>
              <div class="post-meta"><span class="mx-1">&bullet;</span> <span><?= htmlspecialchars($formattedRandomArticleDate, ENT_QUOTES, 'UTF-8') ?></span></div>
              <h2><a href="single-post.html"><?= htmlspecialchars($randomArticle['title'], ENT_QUOTES, 'UTF-8') ?></a></h2>
              <p class="mb-4 d-block"><?= htmlspecialchars($trimmedRandomArticleContent, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="row g-5">


              <?php
                foreach ($allArticles as $article) {
                    $date = new DateTime($article['last_modified']);
                    $formattedDate = $date->format('d M Y');

                    if ($articlesCount === 0) {
                      echo '<div class="col-lg-4 border-start custom-border">'; // Ouvrez une nouvelle div.
                    }

                    // Commencez une nouvelle div après avoir affiché trois articles dans la première div.
                    if ($articlesCount === 3) {
                        echo '</div>'; // Fermez la première div.
                        echo '<div class="col-lg-4 border-start custom-border">'; // Ouvrez une nouvelle div.
                    }

                    echo '<div class="post-entry-1">
                      <a href="single-post.html"><img src="assets/img/illu-post.jpg" alt="" class="img-fluid"></a>
                      <div class="post-meta"><span class="mx-1">&bullet;</span> <span>'.htmlspecialchars($formattedDate, ENT_QUOTES, 'UTF-8').'</span></div>
                      <h2><a href="single-post.html">'.htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8').'</a></h2>
                    </div>';
              
                    $articlesCount++;
              
                    // Arrêtez la boucle après avoir affiché six articles.
                    if ($articlesCount === 6) {
                        break;
                    }
                } // end foreach
              
                // Fermez la dernière div si nécessaire.
                if ($articlesCount > 0) {
                    echo '</div>';
                }
              ?>

              <!-- Trending Section -->
              <div class="col-lg-4">

                <div class="trending">
                  <h3>CV</h3>
                  <ul class="trending-post">
                    <li>
                      <a href="assets/files/CV_Theo_Vilain.pdf" target="_blank">
                        <h3>Cliquez-ici pour accéder au CV de Théo Vilain.</h3>
                        <span class="author">Mis à jour le 16/09/2023</span>
                      </a>
                    </li>
                  </ul>
                </div>

              </div> <!-- End Trending Section -->
            </div>
          </div>

        </div> <!-- End .row -->
      </div>
    </section> <!-- End Post Grid Section -->

    <!-- Contact Form Section Begin -->
    <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2 class="mb-5">Contactez-moi</h2>
        </div>

        <div class="row">

          <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="assets/forms/contact_form_processor.php" method="post" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Prénom</label>
                  <input type="text" name="first_name" class="form-control" id="first_name" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Nom</label>
                  <input type="text" name="last_name" class="form-control" id="last_name" required>
                </div>
                <div class="form-group col-md-12">
                  <label for="email">Adresse e-mail</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="form-group col-md-12">
                  <label for="subject">Sujet</label>
                  <input type="text" class="form-control" name="subject" id="subject" required>
                </div>
                <div class="form-group col-md-12">
                  <label for="message">Message</label>
                  <textarea class="form-control" name="message" rows="10" required></textarea>
                </div>
                <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
              </div>
              <div class="text-center"><button type="submit" name="submit_contact_form">Envoyer le message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">

        <div class="row g-5">
          <div class="col-lg-4">
            <h3 class="footer-heading">À propos de Théo Vilain</h3>
            <p>Jeune développeur back-end développant depuis déjà plus de 10 ans passionné par l'informatique, l'aérospatial et l'aéronautique et souhaitant entrer dans le secteur de l'aérospatial.</p>
            <p><a href="about.html" class="footer-link-more">En savoir plus</a></p>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">
              <li><a href="index.html"><i class="bi bi-chevron-right"></i> Accueil</a></li>
              <li><a href="index.html"><i class="bi bi-chevron-right"></i> Les articles</a></li>
              <li><a href="category.html"><i class="bi bi-chevron-right"></i> Connexion / Inscription</a></li>
              <li><a href="single-post.html"><i class="bi bi-chevron-right"></i> À propos</a></li>
              <li><a href="about.html"><i class="bi bi-chevron-right"></i> Espace administration</a></li>
            </ul>
          </div>
          <div class="col-lg-4">
            <h3 class="footer-heading">Recent Posts</h3>

            <ul class="footer-links footer-blog-entry list-unstyled">

                <?php 
                  foreach ($footerArticles as $articleFooter) {
                    $footerArticleDate = new DateTime($articleFooter['last_modified']);
                    $formattedfooterArticleDate = $footerArticleDate->format('d M Y');

                    echo '<li>
                      <a href="single-post.html" class="d-flex align-items-center">
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
  <script src="assets/js/forms.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>