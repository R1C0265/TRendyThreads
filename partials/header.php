<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['userId']);
$userType = $_SESSION['userType'] ?? null;

// Only require database connection if needed

require_once "config/main.php";

// Get current page filename
$currentPage = basename($_SERVER['PHP_SELF']);

// Function to check if nav item is active
function isActive($pageName)
{
  $currentPage = basename($_SERVER['PHP_SELF']);
  return ($currentPage === $pageName) ? 'active bg-gradient-dark text-white' : 'text-dark';
}
// Set page name for title
$pageName = ucfirst(str_replace('.php', '', $currentPage));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Trendy Threads</title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet" />
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <h1>Trendy Threads</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="store.php">Store</a></li>

          <li><a href="#contact">Contact</a></li>


          <?php if ($isLoggedIn && $userType == '3'): ?>
            <li class="dropdown">
              <a href="#">
                <span><i class="icon bi bi-person-down toggle-dropdown"></i></span>
                <i class="bi bi-chevron-down toggle-dropdown"></i>
              </a>
              <ul>
                <li><a href="#">Help</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="#">Sign Out</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li><a href="signin.php">Login</a></li>
          <?php endif; ?>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>