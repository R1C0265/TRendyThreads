<footer id="footer" class="footer">
  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-5 col-md-12 footer-about">
        <a href="index.php" class="logo d-flex align-items-center">
          <span class="sitename">Trendy Threads</span>
        </a>
        <p>
          Cras fermentum odio eu feugiat lide par naso tierra. Justo eget
          nada terra videa magna derita valies darta donna mare fermentum
          iaculis eu non diam phasellus.
        </p>
        <div class="social-links d-flex mt-4">
          <a href=""><i class="bi bi-twitter-x"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#about">About us</a></li>
          <li><a href="store.php">Store</a></li>
        </ul>
      </div>

      <!--       <div class="col-lg-2 col-6 footer-links">
        <h4>Catch us on</h4>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Tik Tok</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div> -->

      <div
        class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>Sector 4, Behind Dzenza Secondary</p>
        <p>Area 25, Lilongwe</p>
        <p>Malawi</p>
        <p class="mt-4">
          <strong>Phone:</strong>
          <span>+1 5589 55488 55</span>
        </p>
        <p>
          <strong>Email:</strong>
          <span>info@example.com</span>
        </p>
      </div>
    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>
      ©
      <span>Copyright</span>
      <strong class="px-1 sitename"><a href="https://palmtech.ct.ws">Palm Technologies</a></strong>
      <span>All Rights Reserved</span>
    </p>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you've purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
      Designed by
      <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </div>
</footer>

<!-- Theme Settings Panel -->
<div class="fixed-plugin-customer">
  <a class="fixed-plugin-button-customer text-dark position-fixed px-3 py-2" title="Theme Settings">
    <i class="bi bi-gear" style="font-size: 20px;"></i>
  </a>
  <div class="card shadow-lg theme-panel-customer">
    <div class="card-header pb-0 pt-3">
      <div class="float-start">
        <h5 class="mt-3 mb-0">Theme Preferences</h5>
        <p class="text-sm">Customize your experience</p>
      </div>
      <div class="float-end mt-4">
        <button
          class="btn btn-link text-dark p-0 fixed-plugin-close-button-customer">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
    <hr class="my-1" />
    <div class="card-body pt-sm-3 pt-0">
      <!-- Theme Mode Selection -->
      <div class="mt-2">
        <h6 class="mb-3">Theme Mode</h6>
        <div class="d-flex flex-column gap-2">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="themeModeCustomer" id="lightModeCustomer" value="light">
            <label class="form-check-label" for="lightModeCustomer">
              <i class="bi bi-sun-fill me-2" style="color: #FDB813;"></i> Light Mode
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="themeModeCustomer" id="darkModeCustomer" value="dark">
            <label class="form-check-label" for="darkModeCustomer">
              <i class="bi bi-moon-fill me-2" style="color: #4B6584;"></i> Dark Mode
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="themeModeCustomer" id="autoModeCustomer" value="auto" checked>
            <label class="form-check-label" for="autoModeCustomer">
              <span class="badge bg-primary me-2" style="font-size: 12px; font-weight: bold;">A</span> Automatic (Device Default)
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scroll Top -->
<a
  href="#"
  id="scroll-top"
  class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script>
  // Fallback to CDN if local jQuery fails
  if (typeof jQuery === 'undefined') {
    document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
  }
</script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Customer Theme Management -->
<script>
  class CustomerThemeManager {
    constructor() {
      this.init();
    }

    init() {
      // Load saved theme or default to auto
      const savedTheme = localStorage.getItem('trendyThreadsTheme') || 'auto';
      this.setTheme(savedTheme);
      this.updateUI(savedTheme);

      // Listen for theme changes
      document.querySelectorAll('input[name="themeModeCustomer"]').forEach(input => {
        input.addEventListener('change', (e) => {
          this.setTheme(e.target.value);
        });
      });

      // Listen for system theme changes
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (localStorage.getItem('trendyThreadsTheme') === 'auto') {
          this.applyTheme(this.getSystemTheme());
        }
      });

      // Panel toggle functionality
      const settingsBtn = document.querySelector('.fixed-plugin-button-customer');
      const closeBtn = document.querySelector('.fixed-plugin-close-button-customer');
      const panel = document.querySelector('.theme-panel-customer');

      if (settingsBtn && closeBtn && panel) {
        settingsBtn.addEventListener('click', (e) => {
          e.preventDefault();
          panel.classList.toggle('show');
        });

        closeBtn.addEventListener('click', (e) => {
          e.preventDefault();
          panel.classList.remove('show');
        });

        // Close panel when clicking outside
        document.addEventListener('click', (e) => {
          if (!settingsBtn.contains(e.target) && !panel.contains(e.target)) {
            panel.classList.remove('show');
          }
        });
      }
    }

    setTheme(theme) {
      localStorage.setItem('trendyThreadsTheme', theme);
      const actualTheme = theme === 'auto' ? this.getSystemTheme() : theme;
      this.applyTheme(actualTheme);
      this.updateUI(theme);
    }

    getSystemTheme() {
      return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    updateUI(theme) {
      document.querySelectorAll('input[name="themeModeCustomer"]').forEach(input => {
        input.checked = input.value === theme;
      });
    }

    applyTheme(theme) {
      const body = document.body;

      if (theme === 'dark') {
        body.classList.add('dark-theme');
      } else {
        body.classList.remove('dark-theme');
      }
    }
  }

  // Initialize customer theme manager
  const customerThemeManager = new CustomerThemeManager();
</script>

<!-- Customer Dark Theme CSS -->
<style>
  .dark-theme {
    background-color: #1a1a1a !important;
    color: #ffffff !important;
  }

  .dark-theme .header {
    background-color: #2d2d2d !important;
    box-shadow: 0 2px 10px rgba(255, 255, 255, 0.1) !important;
  }

  .dark-theme .navmenu a {
    color: #ffffff !important;
  }

  .dark-theme .navmenu a:hover,
  .dark-theme .navmenu a.active {
    color: #007bff !important;
  }

  .dark-theme .section {
    background-color: #1a1a1a !important;
  }

  .dark-theme .light-background {
    background-color: #2d2d2d !important;
  }

  .dark-theme .card {
    background-color: #2d2d2d !important;
    border-color: #404040 !important;
    color: #ffffff !important;
  }

  .dark-theme .form-control {
    background-color: #404040 !important;
    border-color: #555555 !important;
    color: #ffffff !important;
  }

  .dark-theme .form-control:focus {
    background-color: #404040 !important;
    border-color: #007bff !important;
    color: #ffffff !important;
  }

  .dark-theme .input-group-text {
    background-color: #404040 !important;
    border-color: #555555 !important;
    color: #ffffff !important;
  }

  .dark-theme .btn-primary {
    background-color: #007bff !important;
    border-color: #007bff !important;
  }

  .dark-theme .footer {
    background-color: #2d2d2d !important;
    color: #ffffff !important;
  }

  .dark-theme .footer a {
    color: #adb5bd !important;
  }

  .dark-theme .footer a:hover {
    color: #007bff !important;
  }

  .dark-theme .text-muted {
    color: #adb5bd !important;
  }

  .dark-theme h1,
  .dark-theme h2,
  .dark-theme h3,
  .dark-theme h4,
  .dark-theme h5,
  .dark-theme h6 {
    color: #ffffff !important;
  }

  /* Paragraph and text styling */
  .dark-theme p {
    color: #e0e0e0 !important;
  }

  .dark-theme p,
  .dark-theme li,
  .dark-theme span,
  .dark-theme div:not(.dark-theme .card):not(.dark-theme .form-control) {
    color: #e0e0e0 !important;
  }

  .dark-theme .section-title p {
    color: #adb5bd !important;
  }

  .dark-theme .stats-item p {
    color: #e0e0e0 !important;
  }

  .dark-theme .info-item p {
    color: #e0e0e0 !important;
  }

  .dark-theme .cta-btn {
    color: #ffffff !important;
    background-color: #007bff !important;
    border-color: #007bff !important;
  }

  .dark-theme .cta-btn:hover {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
  }

  .dark-theme ul li {
    color: #e0e0e0 !important;
  }

  .dark-theme ul li h5 {
    color: #ffffff !important;
  }

  .dark-theme ul li p {
    color: #adb5bd !important;
  }

  /* Contact form styling */
  .dark-theme .php-email-form .loading {
    color: #007bff !important;
  }

  .dark-theme .php-email-form .error-message {
    color: #ff6b6b !important;
  }

  .dark-theme .php-email-form .sent-message {
    color: #28a745 !important;
  }

  .dark-theme .php-email-form button {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: #ffffff !important;
  }

  .dark-theme .php-email-form button:hover {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
  }

  /* Link styling */
  .dark-theme a {
    color: #007bff !important;
  }

  .dark-theme a:hover {
    color: #0056b3 !important;
  }

  /* Hero section */
  .dark-theme .hero {
    background-color: #1a1a1a !important;
  }

  .dark-theme .hero h2 {
    color: #ffffff !important;
  }

  .dark-theme .hero p {
    color: #adb5bd !important;
  }

  /* About section */
  .dark-theme .about h3 {
    color: #ffffff !important;
  }

  .dark-theme .about h4 {
    color: #adb5bd !important;
  }

  .dark-theme .about p {
    color: #e0e0e0 !important;
  }

  /* Stats section */
  .dark-theme .stats {
    background-color: #1a1a1a !important;
  }

  .dark-theme .stats-item span {
    color: #007bff !important;
  }

  /* Contact section */
  .dark-theme .contact {
    background-color: #1a1a1a !important;
  }

  .dark-theme .contact h2 {
    color: #ffffff !important;
  }

  .dark-theme .info-item h3 {
    color: #ffffff !important;
  }

  .dark-theme .info-item i {
    color: #007bff !important;
  }

  /* Dropdown menu styling for customer header */
  .dark-theme .navmenu .dropdown ul {
    background: #2d2d2d !important;
    box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.5) !important;
    border: 1px solid #404040 !important;
  }

  .dark-theme .navmenu li.dropdown ul {
    background: #2d2d2d !important;
  }

  .dark-theme .navmenu li.dropdown ul li {
    background-color: transparent !important;
  }

  .dark-theme .navmenu li.dropdown ul li a {
    color: #e0e0e0 !important;
    background: #2d2d2d !important;
  }

  .dark-theme .navmenu li.dropdown ul li a:hover {
    color: #007bff !important;
    background: #383838 !important;
  }

  .dark-theme .navmenu li.dropdown ul li:hover>a {
    color: #007bff !important;
    background: #383838 !important;
  }

  .dark-theme .navmenu .dropdown a {
    color: #e0e0e0 !important;
  }

  .dark-theme .navmenu .dropdown a:hover {
    color: #007bff !important;
  }

  .dark-theme .navmenu .dropdown i {
    color: #e0e0e0 !important;
  }

  .dark-theme .navmenu .dropdown:hover i {
    color: #007bff !important;
  }

  /* Theme Settings Panel Styling */
  .fixed-plugin-customer {
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1000;
  }

  .fixed-plugin-button-customer {
    background-color: #ffffff;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    cursor: pointer;
    top: 20px;
    right: 20px;
  }

  .fixed-plugin-button-customer:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  .dark-theme .fixed-plugin-button-customer {
    background-color: #2d2d2d !important;
    color: #ffffff !important;
    box-shadow: 0 2px 10px rgba(255, 255, 255, 0.1);
  }

  .dark-theme .fixed-plugin-button-customer:hover {
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
  }

  .theme-panel-customer {
    position: fixed;
    right: -350px;
    top: 20px;
    width: 320px;
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 999;
    max-height: 90vh;
    overflow-y: auto;
  }

  .theme-panel-customer.show {
    right: 20px;
  }

  .dark-theme .theme-panel-customer {
    background-color: #2d2d2d !important;
    border-color: #404040 !important;
    color: #ffffff !important;
  }

  .dark-theme .theme-panel-customer .card-header {
    background-color: #2d2d2d !important;
    border-color: #404040 !important;
  }

  .dark-theme .theme-panel-customer .form-check-label {
    color: #ffffff !important;
  }

  .dark-theme .theme-panel-customer hr {
    border-top-color: #404040 !important;
  }

  .theme-panel-customer .card-header {
    background-color: #f8f9fa !important;
  }

  .theme-panel-customer h5 {
    color: #333333;
    font-weight: 600;
  }

  .dark-theme .theme-panel-customer h5,
  .dark-theme .theme-panel-customer h6 {
    color: #ffffff !important;
  }

  .form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
  }

  .form-check-input {
    cursor: pointer;
  }

  .form-check-label {
    cursor: pointer;
    user-select: none;
  }

  @media (max-width: 576px) {
    .theme-panel-customer {
      width: 100%;
      right: -100% !important;
    }

    .theme-panel-customer.show {
      right: 0 !important;
    }

    .fixed-plugin-button-customer {
      right: 10px !important;
      top: 10px !important;
    }
  }
</style>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>
<script src="assets/js/contact-form.js"></script>

<script>
  // Handle active navigation for sections on index page
  document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop();

    // Only run on index page
    if (currentPage === 'index.php' || currentPage === '') {
      const navLinks = document.querySelectorAll('.navmenu a[href*="#"]');
      const sections = document.querySelectorAll('section[id]');

      // Function to update active nav item
      function updateActiveNav() {
        let current = '';

        sections.forEach(section => {
          const sectionTop = section.offsetTop - 100;
          const sectionHeight = section.offsetHeight;

          if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
            current = section.getAttribute('id');
          }
        });

        // Default to hero/home if at top
        if (window.scrollY < 200) {
          current = 'hero';
        }

        navLinks.forEach(link => {
          link.classList.remove('active');
          const href = link.getAttribute('href');

          if ((current === 'hero' && href.includes('index.php') && !href.includes('#')) ||
            (current && href.includes('#' + current))) {
            link.classList.add('active');
          }
        });
      }

      // Update on scroll
      window.addEventListener('scroll', updateActiveNav);

      // Update on load
      updateActiveNav();

      // Handle hash in URL
      if (window.location.hash) {
        setTimeout(() => {
          const target = document.querySelector(window.location.hash);
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth'
            });
          }
        }, 100);
      }
    }
  });
</script>


<script>
  $("#login").submit(function(e) {
    e.preventDefault();

    $.ajax({
      url: "model/login.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $("#btnSub").addClass("disabled");
        $("#btnSub").html("Processing");
      },
      success: function(data) {
        console.log(data);
        if (data == 1) {
          window.location.href = "admin/index.php";
        } else if (data == 2) {
          window.location.href = "employee/index.php";
        } else if (data == 3) {
          window.location.href = "index.php";
        } else {
          alert("Login failed. Server returned: " + data);
        }
        $("#btnSub").removeClass("disabled");
        $("#btnSub").html("LOGIN");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX error:", textStatus, errorThrown);
        alert("Request failed: " + textStatus);
        $("#btnSub").prop("disabled", false).text("LOGIN");
      },
    });
  });
</script>
</body>

</html>
</body>

</html>