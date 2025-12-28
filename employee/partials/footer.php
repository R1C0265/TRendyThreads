<?php
//Main Footer Page 
?>

<footer class="footer py-4">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div
                    class="copyright text-center text-sm text-muted text-lg-start">
                    © <a
                        href="https://www.palm.tech.ct.ws"
                        class="font-weight-bold"
                        target="_blank">
                        Palm Technologies
                    </a>
                    <script>
                        document.write(new Date().getFullYear());
                    </script>

                    <i class="fa fa-heart"></i>

                </div>
            </div>
            <div class="col-lg-6">
       
            </div>
        </div>
    </div>
</footer>
</div>
</main>
<
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Page Preferences</h5>
                <p>Customize your dashboard experience.</p>
            </div>
            <div class="float-end mt-4">
                <button
                    class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="material-symbols-rounded">clear</i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1" />
        <div class="card-body pt-sm-3 pt-0">

            <!-- Navbar Fixed -->
            <div class="mt-3 d-flex">
                <h6 class="mb-0">Fixed Navigation</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input
                        class="form-check-input mt-1 ms-auto"
                        type="checkbox"
                        id="navbarFixed"
                        onclick="navbarFixed(this)" />
                </div>
            </div>
            <hr class="horizontal dark my-3" />
            <!-- Theme Mode Selection -->
            <div class="mt-2">
                <h6 class="mb-2">Theme Mode</h6>
                <div class="d-flex flex-column gap-2">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="themeMode" id="lightMode" value="light">
                        <label class="form-check-label" for="lightMode">
                            <i class="material-symbols-rounded me-1">light_mode</i> Light Mode
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="themeMode" id="darkMode" value="dark">
                        <label class="form-check-label" for="darkMode">
                            <i class="material-symbols-rounded me-1">dark_mode</i> Dark Mode
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="themeMode" id="autoMode" value="auto" checked>
                        <label class="form-check-label" for="autoMode">
                            <i class="material-symbols-rounded me-1">brightness_auto</i> Follow Device
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Theme Management Script -->
<script>
// Theme Management System
class ThemeManager {
    constructor() {
        this.init();
    }
    
    init() {
        // Load saved theme or default to auto
        const savedTheme = localStorage.getItem('trendyThreadsTheme') || 'auto';
        this.setTheme(savedTheme);
        this.updateUI(savedTheme);
        
        // Load navbar fixed state
        const navbarFixed = localStorage.getItem('navbarFixed') === 'true';
        document.getElementById('navbarFixed').checked = navbarFixed;
        if (navbarFixed) {
            document.querySelector('.navbar-main').classList.add('position-sticky', 'blur', 'shadow-blur');
        }
        
        // Listen for theme changes
        document.querySelectorAll('input[name="themeMode"]').forEach(input => {
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
    
    applyTheme(theme) {
        const body = document.body;
        const sidenav = document.querySelector('.sidenav');
        const navbar = document.querySelector('.navbar-main');
        const settingsBtn = document.querySelector('.fixed-plugin-button');
        
        if (theme === 'dark') {
            body.classList.add('dark-version');
            if (sidenav) {
                sidenav.classList.remove('bg-white');
                sidenav.classList.add('bg-gradient-dark');
                // Update active nav items for dark theme
                sidenav.querySelectorAll('.nav-link.active').forEach(link => {
                    link.style.backgroundColor = '#e91e63';
                    link.style.color = 'white';
                });
            }
            if (navbar) {
                navbar.classList.add('navbar-dark');
                navbar.classList.remove('navbar-light');
            }
            if (settingsBtn) {
                settingsBtn.classList.remove('text-dark');
                settingsBtn.classList.add('text-white');
                settingsBtn.style.backgroundColor = '#2d2d2d';
            }
        } else {
            body.classList.remove('dark-version');
            if (sidenav) {
                sidenav.classList.add('bg-white');
                sidenav.classList.remove('bg-gradient-dark');
                // Update active nav items for light theme
                sidenav.querySelectorAll('.nav-link.active').forEach(link => {
                    link.style.backgroundColor = '#344767';
                    link.style.color = 'white';
                });
            }
            if (navbar) {
                navbar.classList.remove('navbar-dark');
                navbar.classList.add('navbar-light');
            }
            if (settingsBtn) {
                settingsBtn.classList.remove('text-white');
                settingsBtn.classList.add('text-dark');
                settingsBtn.style.backgroundColor = '#ffffff';
            }
        }
    }
    
    updateUI(theme) {
        document.querySelectorAll('input[name="themeMode"]').forEach(input => {
            input.checked = input.value === theme;
        });
    }
}

// Initialize theme manager
new ThemeManager();

// Enhanced navbar fixed function with persistence
function navbarFixed(el) {
    const navbar = document.querySelector('.navbar-main');
    const isFixed = el.checked;
    
    localStorage.setItem('navbarFixed', isFixed);
    
    if (isFixed) {
        navbar.classList.add('position-sticky', 'blur', 'shadow-blur');
    } else {
        navbar.classList.remove('position-sticky', 'blur', 'shadow-blur');
    }
}
</script>

<!-- Dark Mode CSS -->
<style>
.dark-version {
    background-color: #1a1a1a !important;
    color: #ffffff !important;
}

.dark-version .card {
    background-color: #2d2d2d !important;
    border-color: #404040 !important;
    color: #ffffff !important;
}

.dark-version .card-header {
    background-color: #2d2d2d !important;
    border-color: #404040 !important;
}

.dark-version .table {
    color: #ffffff !important;
}

.dark-version .table td, .dark-version .table th {
    border-color: #404040 !important;
}

.dark-version .text-dark {
    color: #ffffff !important;
}

.dark-version .text-muted {
    color: #adb5bd !important;
}

.dark-version .bg-white {
    background-color: #2d2d2d !important;
}

.dark-version .border {
    border-color: #404040 !important;
}

.dark-version .navbar {
    background-color: #2d2d2d !important;
}

.dark-version .footer {
    background-color: #1a1a1a !important;
}

.dark-version .sidenav {
    background-color: #2d2d2d !important;
}

/* Fixed Plugin Button Styling */
.fixed-plugin-button {
    background-color: #ffffff;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.fixed-plugin-button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.dark-version .fixed-plugin-button {
    background-color: #2d2d2d !important;
    color: #ffffff !important;
    box-shadow: 0 2px 10px rgba(255, 255, 255, 0.1);
}

.dark-version .fixed-plugin-button:hover {
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
}
</style>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="assets/js/plugins/chartjs.min.js"></script>
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<!-- Dynamic Charts -->
<script>
    if (typeof window.chartData !== 'undefined') {
        // Weekly Sales Bar Chart
        const ctx1 = document.getElementById('chart-bars').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: window.chartData.weeklyLabels,
                datasets: [{
                    label: 'Daily Sales (MWK)',
                    data: window.chartData.weeklyData,
                    backgroundColor: '#43A047',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e5e5e5',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: '#737373'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#737373'
                        }
                    }
                }
            }
        });

        // Monthly Sales Line Chart
        const ctx2 = document.getElementById('chart-line').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: window.chartData.monthlyLabels,
                datasets: [{
                    label: 'Monthly Sales (MWK)',
                    data: window.chartData.monthlyData,
                    borderColor: '#43A047',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#43A047'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e5e5e5',
                            borderDash: [4, 4]
                        },
                        ticks: {
                            color: '#737373'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#737373'
                        }
                    }
                }
            }
        });

        // Online Purchases Line Chart
        const ctx3 = document.getElementById('chart-line-tasks').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: window.chartData.monthlyLabels,
                datasets: [{
                    label: 'Online Purchases (MWK)',
                    data: window.chartData.onlineData,
                    borderColor: '#43A047',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#43A047'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e5e5e5',
                            borderDash: [4, 4]
                        },
                        ticks: {
                            color: '#737373'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#737373'
                        }
                    }
                }
            }
        });
    }
</script>
<script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
        var options = {
            damping: "0.5",
        };
        Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>