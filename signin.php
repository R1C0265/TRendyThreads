<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Trendy Threads|Signin</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link
    href="assets/vendor/bootstrap/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
    rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link
    href="assets/vendor/glightbox/css/glightbox.min.css"
    rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />
</head>

<body class="index-page">
  <header
    id="header"
    class="header d-flex align-items-center position-relative">
    <div
      class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="sitename">Trendy Threads</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="signin.php" class="active">Sign In</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <!-- Sign In Section -->
    <section class="section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8">
            <div class="auth-form-transparent text-left p-4">
              <h2 class="text-center mb-4">Welcome back!</h2>
              <p class="text-center mb-4">Happy to see you again!</p>
              <form class="pt-3" id="login">
                <div class="form-group mb-3">
                  <label for="exampleInputEmail">Email</label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-envelope"></i>
                    </span>
                    <input
                      type="email"
                      name="email"
                      required
                      class="form-control form-control-lg"
                      id="exampleInputEmail"
                      placeholder="Your Email" />
                  </div>
                </div>
                <div class="form-group mb-3">
                  <label for="exampleInputPassword">Password</label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="bi bi-lock"></i>
                    </span>
                    <input
                      type="password"
                      name="password"
                      required
                      class="form-control form-control-lg"
                      id="exampleInputPassword"
                      placeholder="Your Password" />
                  </div>
                </div>
                <div
                  class="my-3 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <input
                      type="checkbox"
                      class="form-check-input"
                      id="keepSignedIn" />
                    <label class="form-check-label" for="keepSignedIn">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="text-primary">Forgot password?</a>
                </div>
                <div class="my-3">
                  <button
                    id="btnSub"
                    type="submit"
                    class="btn btn-primary w-100 btn-lg">
                    LOGIN
                  </button>
                </div>
                <div class="text-center mt-4">
                  Don't have an account?
                  <a href="register.php" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- ======= Footer Section ======= -->
  <footer id="footer" class="footer dark-background mt-5">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-4 col-md-6 footer-about">
            <a href="index.php" class="logo d-flex align-items-center">
              <span class="sitename">Tarama Farms</span>
            </a>
            <div class="footer-contact pt-3">
              <p>A108 Adam Street</p>
              <p>New York, NY 535022</p>
              <p class="mt-3">
                <strong>Phone:</strong>
                <span>+1 5589 55488 55</span>
              </p>
              <p>
                <strong>Email:</strong>
                <span>info@example.com</span>
              </p>
            </div>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Terms of service</a></li>
              <li><a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><a href="#">Web Design</a></li>
              <li><a href="#">Web Development</a></li>
              <li><a href="#">Product Management</a></li>
              <li><a href="#">Marketing</a></li>
              <li><a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="index.php">Home</a></li>
              <li><a href="signin.php">Sign In</a></li>
              <li><a href="register.php">Register</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="copyright text-center">
      <div
        class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
        <div
          class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
            © Copyright
            <strong><span>Tarama Farms</span></strong>
            . All Rights Reserved
          </div>
        </div>

        <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
          <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a
    href="#"
    id="scroll-top"
    class="scroll-top d-flex align-items-center justify-content-center"
    title="Scroll to Top">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/jquery-3.7.1.min.js"></script>

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
          //Admin Login
          if (data == 1) {
            window.location.href = "admin/index.php";
          } else if (data == 2) {
            //employee login
            window.location.href = "employee/index.php";
          } else if (data == 3) {
            //customer login
            window.location.href = "index.php";
          } else {
            // show server response for debugging
            alert("Login failed. Server returned: " + data);
          }
          $("#btnSub").removeClass("disabled");
          $("#btnSub").html("LOGIN");
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error(
            "AJAX error:",
            textStatus,
            errorThrown,
            "response:",
            jqXHR.responseText
          );
          alert(
            "Request failed: " + textStatus + " — see console for details."
          );
          $("#btnSub").prop("disabled", false).text("LOGIN");
        },
      });
    });
  </script>
</body>

</html>