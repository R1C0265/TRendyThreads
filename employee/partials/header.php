<?php
//Global Header for TrendyTHreads CMS

// Get current page filename
$currentPage = basename($_SERVER['PHP_SELF']);

// Function to check if nav item is active
function isActive($pageName)
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    return ($currentPage === $pageName) ? 'active bg-gradient-dark text-white' : 'text-dark';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link
        rel="apple-touch-icon"
        sizes="76x76"
        href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <title>Trendy Threads</title>
    <!--     Fonts and icons     -->
    <link
        rel="stylesheet"
        type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script
        src="https://kit.fontawesome.com/42d5adcbca.js"
        crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link
        id="pagestyle"
        href="assets/css/material-dashboard.css?v=3.2.0"
        rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <i
                class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true"
                id="iconSidenav"></i>
            <a
                class="navbar-brand px-4 py-3 m-0"
                href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
                target="_blank">
                <img
                    src="assets/img/logo-ct-dark.png"
                    class="navbar-brand-img"
                    width="26"
                    height="26"
                    alt="main_logo" />
                <span class="ms-1 text-sm text-dark">Trendy Threads</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0 mb-2" />
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('dashboard.php'); ?>"
                        href="dashboard.php">
                        <i class="material-symbols-rounded opacity-5">dashboard</i>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('sales.php'); ?>"
                        href="sales.php">
                        <i class="material-symbols-rounded opacity-5">shopping_cart</i>
                        <span class="nav-link-text ms-1">Sales</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('bails.php'); ?>"
                        href="bails.php">
                        <i class="material-symbols-rounded opacity-5">inventory_2</i>
                        <span class="nav-link-text ms-1">Bails</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('notifications.php'); ?>"
                        href="notifications.php">
                        <i class="material-symbols-rounded opacity-5">notifications</i>
                        <span class="nav-link-text ms-1">Notifications</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('profile.php'); ?>"
                        href="../pages/profile.html">
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('sign-in.php'); ?>"
                        href="../pages/sign-in.html">
                        <i class="material-symbols-rounded opacity-5">login</i>
                        <span class="nav-link-text ms-1">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidenav-footer position-absolute w-100 bottom-0">
            <div class="mx-3">
                <a
                    class="btn btn-outline-dark mt-4 w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree"
                    type="button">
                    Help
                </a>
                <a
                    class="btn bg-gradient-dark w-100"
                    href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree"
                    type="button">
                    Go To Main Site
                </a>
            </div>
        </div>
    </aside>
    <main
        class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav
            class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl"
            id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol
                        class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm">
                            <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                        </li>
                        <li
                            class="breadcrumb-item text-sm text-dark active"
                            aria-current="page">
                            <?php
                            $pageTitle = explode(".", $currentPage);
                            echo $pageTitle[0], PHP_EOL;
                            ?>
                        </li>
                    </ol>
                </nav>
                <div
                    class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4"
                    id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group input-group-outline"></div>
                    </div>
                    <ul
                        class="navbar-nav d-flex align-items-center justify-content-end"></ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->