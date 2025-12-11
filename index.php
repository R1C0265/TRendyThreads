<?php
require_once 'partials/header.php';
$isLoggedIn = isset($_SESSION['userId']);
$userType = $_SESSION['userType'] ?? null;


// Fetch dynamic content from database
$hero = $db->query("SELECT * FROM hero_content WHERE is_active = 1 LIMIT 1")->fetchArray();
$about = $db->query("SELECT * FROM about_content WHERE is_active = 1 LIMIT 1")->fetchArray();
$about_features = $db->query("SELECT * FROM about_features WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$services = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$stats = $db->query("SELECT * FROM stats WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$clients = $db->query("SELECT * FROM clients WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$contact_info = $db->query("SELECT * FROM contact_info WHERE is_active = 1 ORDER BY sort_order")->fetchAll();
$backgrounds = $db->query("SELECT * FROM background_images WHERE is_active = 1")->fetchAll();

// Convert backgrounds to associative array for easy access
$bg = [];
foreach ($backgrounds as $background) {
  $bg[$background['section_name']] = $background['image_path'];
}
?>
<main class="main">
  <?php if ($isLoggedIn && $userType == '3'): ?>
    <!-- Customer Dashboard -->
    <section class="customer-dashboard section">
      <div class="container">
        <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['userName'] ?? 'Customer'); ?>!</h2>
        <!-- Add customer-specific content here -->
      </div>
    </section>
  <?php else: ?>
  <!-- Hero Section -->
  <section id="hero" class="hero section light-background">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-md-start" data-aos="fade-up">
          <h2><?php echo htmlspecialchars($hero['title'] ?? 'The latest Threads & Fashion'); ?></h2>
          <p><?php echo htmlspecialchars($hero['subtitle'] ?? 'Only dress with the best.'); ?></p>
          <div class="d-flex mt-4 justify-content-center justify-content-md-start">
            <a href="<?php echo $hero['cta_link'] ?? '#about'; ?>" class="cta-btn">
              <?php echo htmlspecialchars($hero['cta_text'] ?? 'Shop Now'); ?> <i class="bi-cart-dash"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
          <img src="<?php echo $hero['hero_image'] ?? 'assets/ig/hero-img.png'; ?>" class="img-fluid animated" alt="" />
        </div>
      </div>
    </div>
  </section>
  <!-- /Hero Section -->

  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 position-relative" data-aos="fade-up" data-aos-delay="100">
          <img src="<?php echo $about['image_path'] ?? 'assets/img/about.jpg'; ?>" class="img-fluid" alt="" />
          <?php if (!empty($about['video_url'])): ?>
            <a href="<?php echo htmlspecialchars($about['video_url']); ?>" class="glightbox pulsating-play-btn"></a>
          <?php endif; ?>
        </div>

        <div class="col-lg-6 ps-lg-4 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <h3><?php echo htmlspecialchars($about['title'] ?? 'About Us'); ?></h3>
          <?php if (!empty($about['subtitle'])): ?>
            <h4><?php echo htmlspecialchars($about['subtitle']); ?></h4>
          <?php endif; ?>
          <p><?php echo htmlspecialchars($about['description'] ?? 'Learn more about our company and mission.'); ?></p>

          <?php if (!empty($about_features)): ?>
            <ul>
              <?php foreach ($about_features as $feature): ?>
                <li>
                  <i class="<?php echo htmlspecialchars($feature['icon_class']); ?>"></i>
                  <div>
                    <h5><?php echo htmlspecialchars($feature['title']); ?></h5>
                    <p><?php echo htmlspecialchars($feature['description']); ?></p>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <!-- /About Section -->

  <!-- Services Section -->
  <section id="services" class="services section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Services</h2>
      <p>Discover our comprehensive range of professional services</p>
    </div>

    <div class="container">
      <div class="row gy-4">
        <?php
        $delay = 100;
        foreach ($services as $service):
        ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="<?php echo htmlspecialchars($service['icon_class']); ?>" style="color: <?php echo htmlspecialchars($service['icon_color']); ?>"></i>
              </div>
              <?php if (!empty($service['link_url'])): ?>
                <a href="<?php echo htmlspecialchars($service['link_url']); ?>" class="stretched-link">
                  <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                </a>
              <?php else: ?>
                <h3><?php echo htmlspecialchars($service['title']); ?></h3>
              <?php endif; ?>
              <p><?php echo htmlspecialchars($service['description']); ?></p>
            </div>
          </div>
        <?php
          $delay += 100;
        endforeach;
        ?>
      </div>
    </div>
  </section>
  <!-- /Services Section -->

  <!-- Stats Section -->
  <section id="stats" class="stats section light-background">
    <img src="<?php echo $bg['stats'] ?? 'assets/img/stats-bg.jpg'; ?>" alt="" data-aos="fade-in" />

    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <?php foreach ($stats as $stat): ?>
          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="<?php echo $stat['value']; ?>" data-purecounter-duration="1" class="purecounter"></span>
              <p><?php echo htmlspecialchars($stat['label']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <!-- /Stats Section -->

  <!-- Clients Section -->
  <?php if (!empty($clients)): ?>
    <section id="clients" class="clients section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-0 clients-wrap">
          <?php foreach ($clients as $client): ?>
            <div class="col-xl-3 col-md-4 client-logo">
              <?php if (!empty($client['website_url'])): ?>
                <a href="<?php echo htmlspecialchars($client['website_url']); ?>" target="_blank">
                  <img src="<?php echo htmlspecialchars($client['logo_path']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($client['name']); ?>" />
                </a>
              <?php else: ?>
                <img src="<?php echo htmlspecialchars($client['logo_path']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($client['name']); ?>" />
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <!-- /Clients Section -->

  <!-- Contact Section -->
  <section id="contact" class="contact section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Contact</h2>
      <p>Get in touch with us for any inquiries or support</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <?php
      $map_url = '';
      foreach ($contact_info as $info) {
        if ($info['type'] == 'map') {
          $map_url = $info['value'];
          break;
        }
      }
      if ($map_url):
      ?>
        <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
          <iframe style="border: 0; width: 100%; height: 270px" src="<?php echo htmlspecialchars($map_url); ?>" frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      <?php endif; ?>

      <div class="row gy-4">
        <div class="col-lg-4">
          <?php
          $delay = 300;
          foreach ($contact_info as $info):
            if ($info['type'] != 'map'):
          ?>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <i class="<?php echo htmlspecialchars($info['icon_class']); ?> flex-shrink-0"></i>
                <div>
                  <h3><?php echo htmlspecialchars($info['label']); ?></h3>
                  <p><?php echo htmlspecialchars($info['value']); ?></p>
                </div>
              </div>
          <?php
              $delay += 100;
            endif;
          endforeach;
          ?>
        </div>

        <div class="col-lg-8">
          <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-md-6">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required="" />
              </div>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" placeholder="Your Email" required="" />
              </div>
              <div class="col-md-12">
                <input type="text" class="form-control" name="subject" placeholder="Subject" required="" />
              </div>
              <div class="col-md-12">
                <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
              </div>
              <div class="col-md-12 text-center">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
                <button type="submit">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- /Contact Section -->
  <?php endif; ?>
</main>

<?php
require_once 'partials/footer.php';
?>