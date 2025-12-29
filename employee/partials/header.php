<?php

require_once "../config/main.php";
//Global Header for TrendyThreads CMS

// AUTHENTICATION CHECK - Protect employee section
// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    // User not logged in - redirect to signin
    header('Location: ../../signin.php');
    exit();
}

// Check if user is an employee (userType should be 1 or 2 for employees, adjust based on your user types)
// Assuming: 1 = Admin, 2 = Employee, 3 = Customer
if (!isset($_SESSION['userType']) || ($_SESSION['userType'] != 1 && $_SESSION['userType'] != 2)) {
    // User is not an employee - redirect to home
    header('Location: ../../index.php');
    exit();
}

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
    <!-- Font Awesome 2025Icons -->
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2"
        id="sidenav-main">
        <div class="sidenav-header">
            <button
                class="btn btn-link p-3 cursor-pointer text-dark position-absolute end-0 top-0"
                id="iconSidenav"
                onclick="toggleSidebar()"
                aria-label="Close navigation">
                <i class="fas fa-times" style="font-size: 18px;"></i>
            </button>
            <a
                class="navbar-brand px-4 py-3 m-0"
                href="index.php"
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
                        class="nav-link <?php echo isActive('index.php'); ?>"
                        href="index.php">
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
                        class="nav-link <?php echo isActive('users.php'); ?>"
                        href="users.php">
                        <i class="material-symbols-rounded opacity-5">group</i>
                        <span class="nav-link-text ms-1">Users</span>
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
                        href="profile.php">
                        <i class="material-symbols-rounded opacity-5">person</i>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
                <hr class="horizontal dark mt-0 mb-2" />
                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('home_about.php'); ?>"
                        href="home_about.php">
                        <i class="material-symbols-rounded opacity-5">home</i>
                        <span class="nav-link-text ms-1">Home & About</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a
                        class="nav-link <?php echo isActive('sign-in.php'); ?>"
                        href="../../logout.php">
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
                    href="../../index.php"
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
                    <ul class="navbar-nav d-flex align-items-center justify-content-end">
                        <li class="nav-item ps-3 d-flex align-items-center">
                            <button class="btn btn-link text-body p-2 m-0" id="iconNavbarSidenav" onclick="toggleSidebar()" aria-label="Toggle navigation">
                                <span class="hamburger-menu">
                                    <span class="hamburger-line"></span>
                                    <span class="hamburger-line"></span>
                                    <span class="hamburger-line"></span>
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Sidebar Backdrop -->
        <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

        <script>
            function toggleSidebar(e) {
                if (e) e.stopPropagation();
                const sidebar = document.getElementById('sidenav-main');
                const backdrop = document.getElementById('sidebarBackdrop');
                const body = document.body;

                if (sidebar.classList.contains('sidebar-open')) {
                    closeSidebar();
                } else {
                    sidebar.classList.add('sidebar-open');
                    backdrop.classList.add('show');
                    body.style.overflow = 'hidden';
                }
            }

            function closeSidebar(e) {
                if (e) e.stopPropagation();
                const sidebar = document.getElementById('sidenav-main');
                const backdrop = document.getElementById('sidebarBackdrop');
                const body = document.body;

                sidebar.classList.remove('sidebar-open');
                backdrop.classList.remove('show');
                body.style.overflow = '';
            }

            // Close sidebar on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            // Prevent sidebar content clicks from closing sidebar
            document.getElementById('sidenav-main')?.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        </script>

        <style>
            /* Professional Hamburger Menu */
            .hamburger-menu {
                display: flex;
                flex-direction: column;
                width: 24px;
                height: 18px;
                justify-content: space-between;
                cursor: pointer;
            }

            .hamburger-line {
                width: 100%;
                height: 3px;
                background-color: #344767;
                border-radius: 2px;
                transition: all 0.3s ease;
            }

            /* Dark theme hamburger */
            .dark-version .hamburger-line {
                background-color: #ffffff;
            }

            /* Dark mode sidebar background */
            .dark-version .sidenav {
                background-color: #2d2d2d !important;
            }

            .dark-version .sidenav.bg-white {
                background-color: #2d2d2d !important;
            }

            .dark-version .sidenav .text-dark {
                color: #ffffff !important;
            }

            .dark-version .sidenav hr {
                border-top-color: #404040 !important;
            }

            #iconNavbarSidenav {
                min-width: 44px;
                min-height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                transition: background-color 0.2s ease;
            }

            #iconNavbarSidenav:hover {
                background-color: rgba(52, 71, 103, 0.1);
            }

            /* Dark theme hover */
            .dark-version #iconNavbarSidenav:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            #iconNavbarSidenav:focus {
                outline: 2px solid #344767;
                outline-offset: 2px;
            }

            /* Professional Sidebar */
            .sidenav {
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1050;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .sidenav.sidebar-open {
                transform: translateX(0);
            }

            /* Backdrop */
            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .sidebar-backdrop.show {
                opacity: 1;
                visibility: visible;
            }

            /* Close button styling */
            #iconSidenav {
                min-width: 40px;
                min-height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 6px;
                transition: background-color 0.2s ease;
            }

            #iconSidenav:hover {
                background-color: rgba(52, 71, 103, 0.1);
            }

            #iconSidenav:focus {
                outline: 2px solid #344767;
                outline-offset: 2px;
            }

            /* Responsive adjustments */
            @media (min-width: 1200px) {
                .sidenav {
                    transform: translateX(0);
                    position: relative;
                }

                .sidebar-backdrop {
                    display: none;
                }

                .main-content {
                    margin-left: 17.125rem;
                }
            }

            @media (max-width: 1199.98px) {
                .main-content {
                    margin-left: 0 !important;
                    width: 100% !important;
                }
            }

            @media (max-width: 1199.98px) {
                .sidenav {
                    transform: translateX(-100%);
                    transition: transform 0.3s ease;
                }

                .sidenav.show {
                    transform: translateX(0);
                }

                .main-content {
                    margin-left: 0 !important;
                }
            }

            .sidenav-toggler-inner {
                width: 20px;
                position: relative;
                transform: rotate(0deg);
                transition: 0.5s ease-in-out;
            }

            .sidenav-toggler-line {
                display: block;
                position: absolute;
                height: 2px;
                width: 100%;
                background: #344767;
                border-radius: 9px;
                opacity: 1;
                left: 0;
                transform: rotate(0deg);
                transition: 0.25s ease-in-out;
            }

            .sidenav-toggler-line:nth-child(1) {
                top: 0px;
            }

            .sidenav-toggler-line:nth-child(2) {
                top: 7px;
            }

            .sidenav-toggler-line:nth-child(3) {
                top: 14px;
            }
        </style>