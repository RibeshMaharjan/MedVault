<?php
require './config/function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedVault - Pharmacy Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #6c757d;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand img {
            height: 50px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('./proj-front/image/intro_bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 3rem;
        }

        .hero p {
            font-size: 1.2rem;
            font-weight: 300;
        }

        .feature-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .cta-section {
            background-color: #f8f9fa;
            padding: 80px 0;
        }

        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0;
        }

        footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        /* Additional styles for toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 350px;
        }
        .toast {
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease-in-out;
            background-color: white;
            border-left: 4px solid var(--primary-color);
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
    <link rel="stylesheet" href="proj-front/assets/css/toast.css">
    <script src="proj-front/assets/js/toast.js" defer></script>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container">
        <?php alertmessage(); ?>
    </div>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="./proj-front/image/med-removebg.png" alt="MedVault">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-primary" href="./proj-front/login.php">Log In</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary" href="./proj-front/login.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h1 class="mb-4">Manage Your Pharmacy with Ease</h1>
                    <p class="mb-5">MedVault is a comprehensive pharmacy management system that helps you streamline inventory, track sales, manage orders, and analyze business performance all in one place.</p>
                    <a href="./proj-front/login.php" class="btn btn-primary btn-lg px-4 me-3">Get Started</a>
                    <a href="#features" class="btn btn-outline-light btn-lg px-4">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose MedVault?</h2>
                <p class="text-muted">Our system comes with powerful features designed for pharmacies</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h4>Inventory Management</h4>
                            <p class="text-muted">Keep track of your medicines with expiration dates, stock levels, and automatic alerts for low stock items.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4>Sales Analytics</h4>
                            <p class="text-muted">Visualize your pharmacy's performance with detailed analytics and customizable reports.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <h4>Order Management</h4>
                            <p class="text-muted">Create, track, and manage orders efficiently with automated inventory updates.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h4>Category Organization</h4>
                            <p class="text-muted">Organize your medicines into categories for easier management and reporting.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <h4>Sales Management</h4>
                            <p class="text-muted">Record and monitor all sales transactions with detailed customer information.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h4>Secure System</h4>
                            <p class="text-muted">Your data is secure with us. We use the latest security measures to protect your information.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="bg-light py-5" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="./proj-front/image/med.png" alt="About MedVault" class="img-fluid rounded-3 shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">About MedVault</h2>
                    <p class="mb-4">MedVault was created with a simple mission: to make pharmacy management easier, more efficient, and more profitable. Our team of experts in both pharmacy operations and software development has created a system that addresses the real needs of modern pharmacies.</p>
                    <p>Whether you run a small independent pharmacy or manage multiple locations, MedVault provides the tools you need to streamline operations, reduce costs, and improve customer service.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contact">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-4">Ready to Transform Your Pharmacy?</h2>
                    <p class="mb-5">Join thousands of pharmacies already using MedVault to streamline their operations and grow their business.</p>
                    <a href="./proj-front/login.php" class="btn btn-primary btn-lg px-5 py-3">Get Started Today</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <img src="image/logo.png" alt="MedVault" class="mb-4" style="height: 50px;">
                    <p class="mb-0">MedVault - Your complete pharmacy management solution. Simplify inventory, boost sales, and grow your business.</p>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php">Home</a></li>
                        <li class="mb-2"><a href="#features">Features</a></li>
                        <li class="mb-2"><a href="#about">About</a></li>
                        <li class="mb-2"><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-6 mb-4 mb-md-0">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Help Center</a></li>
                        <li class="mb-2"><a href="#">Documentation</a></li>
                        <li class="mb-2"><a href="#">Privacy Policy</a></li>
                        <li class="mb-2"><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@medvault.com</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1 (123) 456-7890</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Pharmacy Street, City</li>
                    </ul>
                    <div class="mt-4">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> MedVault. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide toasts after 5 seconds
            const toasts = document.querySelectorAll('.toast.show');
            toasts.forEach(toast => {
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 5000);
            });
            
            // Make toasts dismissible
            document.querySelectorAll('.toast .btn-close').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.toast').classList.remove('show');
                });
            });
        });
    </script>
</body>
</html> 