

    <footer id="footer" class="footer">
      <div class="container footer-top">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <span class="sitename">Butterfly</span>
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
              <li><a href="#">Home</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Terms of service</a></li>
              <li><a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><a href="#">Web Design</a></li>
              <li><a href="#">Web Development</a></li>
              <li><a href="#">Product Management</a></li>
              <li><a href="#">Marketing</a></li>
              <li><a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div
            class="col-lg-3 col-md-12 footer-contact text-center text-md-start"
          >
            <h4>Contact Us</h4>
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p>United States</p>
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
          <strong class="px-1 sitename">Butterfly</strong>
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

    <!-- Scroll Top -->
    <a
      href="#"
      id="scroll-top"
      class="scroll-top d-flex align-items-center justify-content-center"
    >
      <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

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
              target.scrollIntoView({ behavior: 'smooth' });
            }
          }, 100);
        }
      }
    });
    </script>
  </body>
</html>
