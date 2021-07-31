<?php 

require __DIR__ . '/vendor/autoload.php';

require "inc/config.inc.php";
require 'inc/pixo.class.php';

$pixo = new Pixo($CONFIG);


?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pixo - Tradeable Pixels NFT on NYZO!</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="favicon.png" rel="icon">
<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets2/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets2/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets2/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets2/vendor/venobox/venobox.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets2/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="/">Pixo</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- a href="index.html" class="logo mr-auto"><img src="assets2/img/logo.png" alt="" class="img-fluid"></a -->

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="#header">Home</a></li>
          
          <li><a href="/board.php" title="Paint!"><b>Board!</b></a></li>
          
          <li><a href="#about">About</a></li>
          <li><a href="#sponsors">Sponsors</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#contact">Contact</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container position-relative">
      <h1>Welcome to Pixo.Gallery</h1>
      <h2>Showcasing the power and speed of Nyzo with style</h2>

      <p>&nbsp;<br />Pixo brings colors, fun and value to Nyzo - a fast and very safe cryptocurrency.</p>
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">


    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">
        <div class="row">
           <div class="col-lg-12 pt-4 pt-lg-0">
            <div class="row">
              <div class="col-md-3">
                <i class="bx bxs-florist" style="color:#fa0"></i>
                <h4>Color the world!</h4>
                <p>Make the world a better place by participating in a collaborative venture.</p>
              </div>
              <div class="col-md-3">
                <i class="bx bxs-game" style="color:#05a"></i>
                <h4>Challenges</h4>
                <p>We hope to have sponsors and run fun challenges across the board!</p>
              </div>
              <div class="col-md-3">
                <i class="bx bxs-gift" style="color:#d50"></i>
                <h4>Airdrop</h4>
                <p>A significant part of the pixels will be airdropped... don't miss out!</p>
              </div>
              <div class="col-md-3">
                <i class="bx bxs-coin" style="color:#ec0"></i>
                <h4>Valuable Assets</h4>
                <p>Board pixels are trade-able items we hope to be liquid, so advertisers can buy pixels for display space.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
			  <div class="col-lg-12 col-12 text-center">
				<h3 style="margin-top:20px;">A newgen NFT powered experience</h3>
				<p><b>No pixel was distributed yet</b>: Please stay tuned not to miss out!
				</p>
				<center><a href="/board.php" class="btn">See the board</a></center>
			  </div>
      </div>
     </div><!-- /container-->
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts section-bg">
      <div class="container">

        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">64</span>
            <p>Lines and Cols</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">4096</span>
            <p>NFT Pixels</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">9,700</span>
            <p>Nyzo addresses</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">7,441,354</span>
            <p>Nyzo USD Marketcap</p>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

  
    <!-- ======= Cta Section ======= -->
    <section id="sponsors" class="sponsors">
      <div class="container">

        <div class="text-center">
          <h3>Be Visible on Pixo!</h3>
          <p>Pixo surely will become a known place to the Nyzo and NFT lovers community<br />Whether you want to help a fresh project, be visible to a nice and active crypto oriented community or just sponsor a cool project, we can help you!</p>
          <a class="cta-btn" href="#contact" class="scrollto">Contact us</a>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
      <div class="container">

        <div class="section-title">
          <h2>Testimonials</h2>
          <p>Visitors, Players or sponsors: You are welcome to <a class="" href="#contact">contact us</a> with your testimonial</p>
        </div>

        <!-- div class="owl-carousel testimonials-carousel">

          <div class="testimonial-item">
            <p>
              <i class="bx bxs-quote-alt-left quote-icon-left"></i>
              woot is this? i can no wait 6 days, plz tell now!!!!!!
              <i class="bx bxs-quote-alt-right quote-icon-right"></i>
            </p>
            <img src="assets/testimonials/tes_schweins.jpg" class="testimonial-img" alt="">
            <h3>Schweins#9136</h3>
            <h4>@Schweins9</h4>
          </div>

        </div -->

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
      <div class="container">

        <!-- div class="section-title">
          <h2>Snapshots</h2>
          <p>Art is both ephemeral and eternal. Although Idenary live painting is an always in motion display, we'll freeze it at given times as a record of its evolution.</p>
        </div -->

        <!-- div class="row">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>
          </div>
        </div -->

        <!-- div class="row portfolio-container">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <img src="assets2/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
            <div class="portfolio-info">
              <h4>App 1</h4>
              <p>App</p>
              <a href="assets2/img/portfolio/portfolio-1.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" data-gall="portfolioDetailsGallery" data-vbtype="iframe" class="venobox details-link" title="Portfolio Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <img src="assets2/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
            <div class="portfolio-info">
              <h4>Web 3</h4>
              <p>Web</p>
              <a href="assets2/img/portfolio/portfolio-2.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" data-gall="portfolioDetailsGallery" data-vbtype="iframe" class="venobox details-link" title="Portfolio Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <img src="assets2/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
            <div class="portfolio-info">
              <h4>App 2</h4>
              <p>App</p>
              <a href="assets2/img/portfolio/portfolio-3.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" data-gall="portfolioDetailsGallery" data-vbtype="iframe" class="venobox details-link" title="Portfolio Details"><i class="bx bx-link"></i></a>
            </div>
          </div>


        </div -->

      </div>
    </section><!-- End Portfolio Section -->
    
    
     <!-- ======= about nyzo Section ======= -->
    <section id="nyzo" class="nyzo section-bg">
      <div class="container">
    <div class="row">
          <center>
          <div class="col-md-8">
            <h3 style="margin-top:20px;">About Nyzo</h3>
                <p style="text-align: center">
                  Nyzo is a fast and secure blockchain. It comes with fast blocks - 7 seconds - and guaranteed finality. 
                  Nyzo chain relies on "proof of diversity", a novel consensus algorithm that makes use of a scarce ressource as well as time to ensure a single entity can't take over the cycle. 
                  Most of the Nyzo value lies in the cycle, a fully democratic fund that rewards valuable initiatives.
<br /><b>You need a Nyzo address to play on Pixo</b>. 
                </p>
           
            <div class="row mt-2">
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="icofont-computer icofont-2x"></i></div>
            <h4 class="title"><a href="https://nyzo.io/" target="_blank">NYZO.IO</a></h4>
            <p class="description">Community Nyzo Website</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="icofont-binary icofont-2x"></i></div>
            <h4 class="title"><a href="https://Nyzo.co/" target="_blank">Nyzo.co</a></h4>
            <p class="description">Official explorer and historical website</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="icofont-chart-bar-graph icofont-2x"></i></div>
            <h4 class="title"><a href="https://nyzo.today/" target="_blank">Nyzo.Today</a></h4>
            <p class="description">Modern Nyzo, tokens and NFTs explorer</p>
          </div>
        </div> 

      </div>
           
          </div>
          </center>
         
        </div>
         </div>
         </section><!-- End about nyzo Section -->
    

    <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
          <p>Pixo is just born, and is willing to bring some freshness and disruption. This section will be fed with your most itching concerns.</p>
        </div>
        
        <b>NOTE: You can only change the color of a Pixel YOU OWN</b> - Since we did not drop any pixel yet, no one can play - yet! Be patient and stay tuned for the drop!

        <!-- div class="faq-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" class="collapse" href="#faq-list-1">Website seems a bit crude, why are you launching in an early state?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-parent=".faq-list">
                <p>
                  Idenary is a live project, that is born to evolve rather than be perfectly polished.<br/>The Idena hackathon was the sparkle that triggered it all. Although the state of the current website is not as good as what we'd like to show, we had to launch and release now to be in time for the hackathon deadline.<br />
                  This was an epic rush to assemble everything in due time, so we count it as a success anyway!.<br />
                  We have way more in store for you, this is just the beginning!
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-toggle="collapse" href="#faq-list-2" class="collapsed">How to sign-in? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-2" class="collapse" data-parent=".faq-list">
                <p>
                  You need an Idena id to sign in. No personal information is required. No email, no login: just the idena app that will give you an address and access to the "sign in with Idena" feature.<br />
                  Please head over to the <a href="https://idena.io">Official idena website</a> and install the client.
                </p>
              </div>
            </li>

          </ul>
        </div -->

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Best way to get in touch is probably the Nyzo Discord. You're welcome to use other channels as well:</p>
        </div>

        <div class="row">

              <div class="col-md-4">
                <div class="info-box bgg">
                  <i class="bx bxl-discord"></i>
                  <h3>Discord</h3>
                  <p><a href="https://discord.gg/FV2wUyg" target="_blank" rel="nofollow">https://discord.gg/GAbu57d</a></p>
                </div>
              </div>
              <div class="col-md-4">
                <!--div class="info-box bgg">
                  <i class="bx bxl-twitter"></i>
                  <h3>Twitter</h3>
                  <p><a href="https://twitter.com/idenary_com" target="_blank">https://twitter.com/idenary_com</a></p>
                </div -->
              </div>
              <div class="col-md-4">
                <div class="info-box bgg">
                  <i class="bx bx-mail-send"></i>
                  <h3>Email</h3>
                  <p><a href="mailto:contact@idenary.com" target="_blank">contact@idenary.com</a></p>
                </div>
              </div>
       
   
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-12 col-md-12 foo-ter-contact text-center">
             <h3>We have many items on our roadmap and are open to suggests!</h3>
          </div>  
        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">
      <div class="mr-md-auto text-center text-md-left">
        <div class="copyright">
          &copy; Copyright <strong><span>PIXO.Gallery</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/baker-free-onepage-bootstrap-theme/ -->
          Base design by <a href="https://bootstrapmade.com/" target="_blank" rel="nofollow" style="color:#fff">BootstrapMade</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="https://twitter.com/idenary_com" target="_blank" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="https://discord.gg/FV2wUyg" rel="nofollow" target="_blank" class=""><i class="bx bxl-discord"></i></a>
        <a href="https://github.com/Idenary/"  target="_blank" class=""><i class="bx bxl-github"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets2/vendor/jquery/jquery.min.js"></script>
  <script src="assets2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets2/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets2/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets2/vendor/counterup/counterup.min.js"></script>
  <script src="assets2/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets2/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets2/vendor/venobox/venobox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets2/js/main.js"></script>

</body>

</html>
