<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="description" content="India's most trusted carpool platform by Elite Corporate Solutions. Save money, reduce carbon footprint, and connect with verified professionals.">
    <meta name="csrf-token" content="<?= $csrf_token ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --orange-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --purple-gradient: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            --elite-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1050;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .elite-badge {
            font-size: 0.7rem;
            /* background: var(--elite-gradient); */
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 8px;
            font-weight: 600;
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 400;
            line-height: 1.6;
            opacity: 0.9;
            text-shadow: 0 1px 5px rgba(0,0,0,0.3);
        }

        .hero-image {
            position: relative;
            z-index: 2;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .shape:nth-child(1) { width: 100px; height: 100px; top: 20%; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 150px; height: 150px; top: 60%; right: 10%; animation-delay: 5s; }
        .shape:nth-child(3) { width: 80px; height: 80px; bottom: 20%; left: 20%; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Search Section */
        .search-section {
            margin-top: -100px;
            position: relative;
            z-index: 100;
        }

        .search-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
        }

        .search-input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1rem;
            z-index: 5;
        }

        .search-label {
            position: absolute;
            top: -8px;
            left: 15px;
            background: white;
            padding: 0 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #667eea;
        }

        .btn-search {
            background: var(--primary-gradient);
            border: none;
            padding: 1rem 2rem;
            border-radius: 15px;
            font-weight: 600;
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Enhanced Persistent Autocomplete */
        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e9ecef;
            border-top: none;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            z-index: 2000;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .autocomplete-dropdown.show {
            display: block;
        }

        .autocomplete-item {
            padding: 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .autocomplete-item:hover,
        .autocomplete-item.active {
            background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
            border-left: 3px solid #667eea;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
            border-radius: 0 0 15px 15px;
        }

        .autocomplete-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 12px;
            font-size: 0.9rem;
        }

        .autocomplete-text {
            flex: 1;
        }

        .autocomplete-main {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .autocomplete-sub {
            font-size: 0.85rem;
            color: #718096;
        }

        /* Loading Spinner */
        .loading-item {
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Section Styling */
        .section-gradient {
            background: var(--primary-gradient);
            color: white;
        }

        .section-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .section-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.8);
            height: 100%;
            overflow: hidden;
        }

        .section-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .section-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 5rem 0;
            position: relative;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.05;
        }

        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            z-index: 2;
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Map Section */
        .map-section {
            padding: 5rem 0;
            background: white;
        }

        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            height: 500px;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        /* Featured Rides */
        .featured-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 5rem 0;
        }

        .ride-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.8);
            height: 100%;
        }

        .ride-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .driver-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .route-indicator {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            margin: 1rem 0;
        }

        .route-point {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .route-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .route-dot.from { background: #28a745; }
        .route-dot.to { background: #dc3545; }

        /* Image Enhancements */
        .image-with-overlay {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }

        .image-with-overlay img {
            transition: transform 0.3s ease;
        }

        .image-with-overlay:hover img {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .image-with-overlay:hover .image-overlay {
            opacity: 1;
        }

        /* Testimonials */
        .testimonial-section {
            padding: 5rem 0;
            background: white;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-align: center;
            height: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--success-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .stars {
            color: #ffc107;
            margin-bottom: 1rem;
        }

        /* CTA Section */
        .cta-section {
            background: var(--primary-gradient);
            padding: 5rem 0;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.1;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer h5 {
            color: #ecf0f1;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #667eea;
        }

        .footer-bottom {
            border-top: 1px solid #34495e;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #95a5a6;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid white;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        /* Number counters */
        .counter {
            font-weight: 800;
            font-size: 2.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section{
                margin-top: 90px;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .search-card {
                padding: 1.5rem;
                margin: 0 1rem;
            }
            
            .stats-section,
            .featured-section,
            .testimonial-section {
                padding: 3rem 0;
            }

            .autocomplete-dropdown {
                max-height: 250px;
            }

            .elite-badge {
                display: block;
                margin-left: 0;
                margin-top: 4px;
                width: fit-content;
            }
        }

        /* Prevent scrollbar issues */
        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
               <img src="../public/images/logo1.png" width="120"  alt="">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/esg">ESG Impact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <?php if (Security::isLoggedIn()): ?>
                        <a href="/dashboard" class="btn btn-primary me-2">Dashboard</a>
                        <a href="/logout" class="btn btn-outline-primary">Logout</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-outline-primary me-2" style="
    border: 2px solid #616c94;
    color: #21187f;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    background: transparent;
">Login</a>
                        <a href="/signup" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content text-white" data-aos="fade-up">
                        <h1 class="hero-title">
                            Ride Smarter,<br>
                            <span style="background: linear-gradient(45deg, #f093fb, #f5576c, #4facfe); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Connect Better</span>
                        </h1>
                        <p class="hero-subtitle mb-4">
                            Join India's most trusted carpool network by Elite Corporate Solutions. Save up to 70% on commute costs while reducing your carbon footprint with verified professionals.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="/signup" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Get Started Free
                            </a>
                            <a href="#search" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Find a Ride
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image text-center">
                        <img src="../public/images/carpool.jpg" alt="People carpooling together" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section" id="search">
        <div class="container">
            <div class="search-card" data-aos="fade-up">
                <div class="text-center mb-4">
                    <h2 class="h3 fw-bold text-dark mb-2">Find Your Perfect Ride</h2>
                    <p class="text-muted">Search from thousands of verified rides across India</p>
                </div>
                
                <form id="quickSearchForm" class="row g-3">
                    <div class="col-md-4">
                        <div class="search-input-group">
                            <label class="search-label">From</label>
                            <i class="fas fa-circle text-success search-icon"></i>
                            <input type="text" id="homeSource" name="source" 
                                   class="search-input" placeholder="Enter pickup location"
                                   autocomplete="off" required>
                            <div id="homeSourceResults" class="autocomplete-dropdown"></div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="search-input-group">
                            <label class="search-label">To</label>
                            <i class="fas fa-circle text-danger search-icon"></i>
                            <input type="text" id="homeDestination" name="destination" 
                                   class="search-input" placeholder="Enter destination"
                                   autocomplete="off" required>
                            <div id="homeDestinationResults" class="autocomplete-dropdown"></div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="search-input-group">
                            <label class="search-label">Date</label>
                            <i class="fas fa-calendar text-primary search-icon"></i>
                            <input type="date" id="homeDate" name="date" 
                                   class="search-input" min="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Why Carpool Revolution Section -->
    <section class="py-5 section-gradient">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-lg-8 text-center">
                    <h2 class="h1 fw-bold text-white mb-4">Why Carpool Revolution Required for India?</h2>
                    <p class="lead text-white opacity-75 mb-5">India faces unique transportation challenges that carpooling can solve effectively</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="d-flex align-items-start mb-4">
                        <div class="feature-icon me-4" style="background: var(--warning-gradient);height: 50px;">
                           <i class="fas fa-gas-pump"></i>

                        </div>
                        <div class="text-white">
                            <h4 class="fw-bold mb-3">Fuel Import Crisis</h4>
                            <p class="opacity-75">More than 85% of crude oil is imported. Whatever we pay for fuel, significant amount goes out of India. Just by removing 5 lakh cars, people of India can save ₹6,000 crore annually, which if spent on Made in India products can boost Indian economy by approximately ₹60,000 crore.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="d-flex align-items-start mb-4">
                        <div class="feature-icon me-4" style="background: var(--success-gradient);height: 50px;">
                            <i class="fas fa-lungs"></i>
                        </div>
                        <div class="text-white">
                            <h4 class="fw-bold mb-3">Air Pollution Emergency</h4>
                            <p class="opacity-75">Millions of people are suffering because of air pollution. If we can reduce it, it will make people healthier and wealthier. Delhi became Asthma Capital in 2020. Carpooling can significantly reduce vehicular emissions.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="d-flex align-items-start">
                        <div class="feature-icon me-4" style="background: var(--info-gradient);height: 50px;">
                            <i class="fas fa-traffic-light"></i>
                        </div>
                        <div class="text-white">
                            <h4 class="fw-bold mb-3">Traffic Congestion</h4>
                            <p class="opacity-75">Less number of cars can lead to lesser traffic congestion, better productivity hours and better people health. Bengaluru lost 50 crore litres of fuel in 2017 due to traffic jams.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="d-flex align-items-start">
                        <div class="feature-icon me-4" style="background: var(--purple-gradient);height: 50px;  ">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <div class="text-white">
                            <h4 class="fw-bold mb-3">Social Impact</h4>
                            <p class="opacity-75">Carpooling creates communities, reduces stress, and builds professional networks. It's not just about transportation—it's about transforming how India commutes together.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <!-- <section class="stats-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark">Our Impact</h2>
                <p class="lead text-muted">Making a difference, one ride at a time</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--primary-gradient);">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="counter" data-target="125000">0</div>
                        <p class="text-muted mb-0">Total Rides</p>
                    </div>
                </div>
                
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="counter" data-target="87500">0</div>
                        <p class="text-muted mb-0">kg CO₂ Saved</p>
                    </div>
                </div>
                
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--warning-gradient);">
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <div class="counter" data-target="2250000">0</div>
                        <p class="text-muted mb-0">Money Saved</p>
                    </div>
                </div>
                
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="counter" data-target="45000">0</div>
                        <p class="text-muted mb-0">Active Users</p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Live Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark">Live Rides Near You</h2>
                <p class="lead text-muted">Real-time ride availability across major cities</p>
            </div>
            
            <div class="map-container" data-aos="fade-up" data-aos-delay="200">
                <div id="map"></div>
            </div>
        </div>
    </section>

    <!-- Benefits of Carpool Section -->
    <section class="py-5 section-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark">Benefits of Carpool India</h2>
                <p class="lead text-muted">Discover why millions choose carpooling for their daily commute</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="section-card text-center">
                        <img src="https://www.thebalancemoney.com/thmb/l0KQr3CBNz85XPg3YXxRF2UIaiw=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/cropped-image-of-hand-putting-coins-in-jars-with-plants-755740897-5ab88ee1875db9003759d390.jpg" alt="Save Money">
                        <div class="feature-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Save Money Daily</h4>
                        <p class="text-muted">Save up to 70% on your daily commute costs. Split fuel, tolls, and parking expenses with fellow travelers. Make your monthly budget stretch further.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="section-card text-center">
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Professional Network">
                        <div class="feature-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Build Professional Network</h4>
                        <p class="text-muted">Connect with verified professionals from your industry. Build lasting friendships and expand your professional network during your daily commute.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="section-card text-center">
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Environmental Impact">
                        <div class="feature-icon" style="background: var(--warning-gradient);">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Environmental Impact</h4>
                        <p class="text-muted">Reduce your carbon footprint significantly. Each shared ride removes one car from the road, contributing to cleaner air and a greener planet.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="section-card text-center">
                        <img src="https://tse4.mm.bing.net/th/id/OIP.Ltb21-EFytdRN4AtDhvFJQHaFj?r=0&w=626&h=470&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Safe and Verified">
                        <div class="feature-icon" style="background: var(--primary-gradient);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Safe & Verified</h4>
                        <p class="text-muted">All users are OTP verified with government ID verification. Real-time tracking, emergency contacts, and 24/7 support ensure your safety.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="section-card text-center">
                        <img src="https://th.bing.com/th/id/OIG2.RJB9L2PwETbFJSSDiMZX?r=0&w=1024&h=1024&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Time Efficiency">
                        <div class="feature-icon" style="background: var(--orange-gradient);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Time Efficiency</h4>
                        <p class="text-muted">Use HOV lanes, reduce stress from driving, and use commute time productively. Arrive at work refreshed and ready for the day.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="section-card text-center">
                        <img src="https://th.bing.com/th/id/OIG1.qYKG4Gf1Vu4DYDcrGbn2?r=0&w=1024&h=1024&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Easy to Use">
                        <div class="feature-icon" style="background: var(--purple-gradient);">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Easy to Use</h4>
                        <p class="text-muted">Intuitive app design, instant bookings, flexible payment options, and seamless ride management. Technology that just works for you.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Rides Section -->
    <section class="featured-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark">Popular Routes</h2>
                <p class="lead text-muted">Join these frequently traveled routes</p>
            </div>
            
            <div class="row g-4">
                <!-- Sample ride cards with static data -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="ride-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="driver-avatar me-3">
                                RA
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Rahul Agarwal</h6>
                                <small class="text-muted">⭐ 4.8 • 150+ rides</small>
                            </div>
                        </div>
                        
                        <div class="route-indicator">
                            <div class="route-point">
                                <div class="route-dot from"></div>
                                <small class="text-muted">Gurgaon Sector 32</small>
                            </div>
                            <div class="route-point">
                                <div class="route-dot to"></div>
                                <small class="text-muted">Connaught Place</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h5 mb-0 text-success fw-bold">₹120</div>
                                <small class="text-muted">2 seats left</small>
                            </div>
                            <button class="btn btn-primary btn-sm" onclick="bookRide(1, 'Rahul Agarwal')">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="ride-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="driver-avatar me-3">
                                PS
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Priya Sharma</h6>
                                <small class="text-muted">⭐ 4.9 • 200+ rides</small>
                            </div>
                        </div>
                        
                        <div class="route-indicator">
                            <div class="route-point">
                                <div class="route-dot from"></div>
                                <small class="text-muted">Whitefield</small>
                            </div>
                            <div class="route-point">
                                <div class="route-dot to"></div>
                                <small class="text-muted">Koramangala</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h5 mb-0 text-success fw-bold">₹85</div>
                                <small class="text-muted">3 seats left</small>
                            </div>
                            <button class="btn btn-primary btn-sm" onclick="bookRide(2, 'Priya Sharma')">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="ride-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="driver-avatar me-3">
                                AS
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Amit Singh</h6>
                                <small class="text-muted">⭐ 4.7 • 120+ rides</small>
                            </div>
                        </div>
                        
                        <div class="route-indicator">
                            <div class="route-point">
                                <div class="route-dot from"></div>
                                <small class="text-muted">Andheri West</small>
                            </div>
                            <div class="route-point">
                                <div class="route-dot to"></div>
                                <small class="text-muted">Bandra Kurla Complex</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h5 mb-0 text-success fw-bold">₹95</div>
                                <small class="text-muted">1 seat left</small>
                            </div>
                            <button class="btn btn-primary btn-sm" onclick="bookRide(3, 'Amit Singh')">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="ride-card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="driver-avatar me-3">
                                NK
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Neha Kapoor</h6>
                                <small class="text-muted">⭐ 4.9 • 180+ rides</small>
                            </div>
                        </div>
                        
                        <div class="route-indicator">
                            <div class="route-point">
                                <div class="route-dot from"></div>
                                <small class="text-muted">Electronic City</small>
                            </div>
                            <div class="route-point">
                                <div class="route-dot to"></div>
                                <small class="text-muted">MG Road</small>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h5 mb-0 text-success fw-bold">₹110</div>
                                <small class="text-muted">2 seats left</small>
                            </div>
                            <button class="btn btn-primary btn-sm" onclick="bookRide(4, 'Neha Kapoor')">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Airport and Railway Station Section -->
    <section class="py-5 section-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="h1 fw-bold text-white mb-4">Airport and Railway Station Carpooling</h2>
                    <p class="text-white opacity-75 mb-4">
                        Traveling to airports or railway stations can be expensive and inconvenient. With Carpool India, you can now share rides with fellow travelers and split the cost. Enjoy a comfortable and affordable journey while reducing traffic congestion and promoting sustainable transportation.
                    </p>
                    
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center text-white">
                                <i class="fas fa-plane me-3 fs-4"></i>
                                <div>
                                    <h6 class="mb-0">Airport Rides</h6>
                                    <small class="opacity-75">IGI, BLR, BOM & more</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center text-white">
                                <i class="fas fa-train me-3 fs-4"></i>
                                <div>
                                    <h6 class="mb-0">Station Rides</h6>
                                    <small class="opacity-75">All major railway stations</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/signup" class="btn btn-primary btn-lg">
                        <i class="fas fa-luggage-cart me-2"></i>Book Airport Ride
                    </a>
                </div>
                
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <div class="image-with-overlay">
                        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Airport Transportation" class="img-fluid rounded">
                        <div class="image-overlay">
                            <i class="fas fa-plane fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section section-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark">What Our Users Say</h2>
                <p class="lead text-muted">Real experiences from our community</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            RK
                        </div>
                        
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        
                        <p class="text-muted mb-3 fst-italic">"Carpool India has transformed my daily commute. I've saved over ₹15,000 in the last 6 months and made some great professional connections!"</p>
                        
                        <h6 class="fw-bold mb-0">Rajesh Kumar</h6>
                        <small class="text-muted">Software Engineer, TCS</small>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            SA
                        </div>
                        
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        
                        <p class="text-muted mb-3 fst-italic">"As a woman commuter, I feel completely safe using Carpool India. The verification process and safety features are excellent."</p>
                        
                        <h6 class="fw-bold mb-0">Sneha Agarwal</h6>
                        <small class="text-muted">Marketing Manager, Wipro</small>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="testimonial-avatar">
                            AM
                        </div>
                        
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        
                        <p class="text-muted mb-3 fst-italic">"Great platform! Easy to use, reliable people, and it's helping me contribute to a cleaner environment. Highly recommended!"</p>
                        
                        <h6 class="fw-bold mb-0">Arjun Mehta</h6>
                        <small class="text-muted">Consultant, Deloitte</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="h1 fw-bold mb-4">Ready to Start Your Journey?</h2>
                    <p class="lead mb-4">Join thousands of professionals who save money and time with Carpool India</p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="/signup" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket me-2"></i>Get Started Today
                        </a>
                        <a href="/about" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-car-side me-2"></i>Carpool India
                        <span class="elite-badge">by Elite Corporate Solutions</span>
                    </h5>
                    <p class="">India's most trusted carpool network connecting verified professionals for smarter, greener commuting.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted fs-5"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/esg">ESG Impact</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/careers">Careers</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="/dashboard">Find Rides</a></li>
                        <li><a href="/dashboard">Offer Rides</a></li>
                        <li><a href="/corporate">Corporate</a></li>
                        <li><a href="/help">Help Center</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="/privacy">Privacy Policy</a></li>
                        <li><a href="/terms">Terms of Service</a></li>
                        <li><a href="/safety">Safety</a></li>
                        <li><a href="/community">Community Guidelines</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="/help">Help Center</a></li>
                        <li><a href="/safety">Safety Tips</a></li>
                        <li><a href="/contact">Contact Support</a></li>
                        <li><a href="/feedback">Feedback</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Carpool India by Elite Corporate Solutions. All rights reserved. Made with ❤️ for a sustainable future.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="public/js/app.js"></script>
    
    <script>
        // Global variables for persistent autocomplete
        let autocompleteCache = new Map();
        let currentRequests = new Map();
        let activeIndices = new Map();
        let isInitialized = false;

        // Initialize everything on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeAutocomplete();
            initializeAOS();
            initializeNavbar();
            initializeCounters();
            initializeMap();
            initializeForms();
            initializeSmoothScrolling();
            
            isInitialized = true;
            console.log('Homepage initialized successfully');
        });

        // Initialize AOS
        function initializeAOS() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        }

        // Initialize Navbar
        function initializeNavbar() {
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        // Initialize Counter Animation
        function initializeCounters() {
            const counters = document.querySelectorAll('.counter');
            let hasAnimated = false;

            const animateCounters = () => {
                if (hasAnimated) return;
                hasAnimated = true;

                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const duration = 2000;
                    const increment = target / (duration / 50);
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            counter.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            counter.textContent = Math.ceil(current).toLocaleString();
                        }
                    }, 50);
                });
            };

            const statsSection = document.querySelector('.stats-section');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                });
                observer.observe(statsSection);
            }
        }

        // Initialize Map
        function initializeMap() {
            if (typeof L !== 'undefined') {
                try {
                    const map = L.map('map').setView([28.6139, 77.2090], 6);
                    
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    // Add sample markers
                    const sampleRides = [
                        {lat: 28.4595, lng: 77.0266, name: 'Gurgaon Hub', driver: 'Multiple drivers'},
                        {lat: 12.9716, lng: 77.5946, name: 'Bangalore Tech', driver: 'IT Professionals'},
                        {lat: 19.0760, lng: 72.8777, name: 'Mumbai Business', driver: 'Corporate riders'},
                        {lat: 17.3850, lng: 78.4867, name: 'Hyderabad IT', driver: 'Tech community'}
                    ];

                    sampleRides.forEach(ride => {
                        const marker = L.marker([ride.lat, ride.lng]).addTo(map);
                        marker.bindPopup(`
                            <div class="p-3">
                                <h6 class="fw-bold mb-2">${ride.name}</h6>
                                <p class="mb-1 small">${ride.driver}</p>
                                <p class="mb-2 small">Multiple rides available daily</p>
                                <button class="btn btn-primary btn-sm w-100" onclick="searchRidesInArea('${ride.name}')">
                                    <i class="fas fa-search me-1"></i>Search Rides
                                </button>
                            </div>
                        `);
                    });
                } catch (error) {
                    console.error('Map initialization error:', error);
                }
            }
        }

        // Initialize Forms
        function initializeForms() {
            // Set minimum date
            const dateInput = document.getElementById('homeDate');
            if (dateInput) {
                dateInput.min = new Date().toISOString().split('T')[0];
            }

            // Search form submission
            const searchForm = document.getElementById('quickSearchForm');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const source = document.getElementById('homeSource').value.trim();
                    const destination = document.getElementById('homeDestination').value.trim();
                    const date = document.getElementById('homeDate').value;
                    
                    if (source && destination && date) {
                        sessionStorage.setItem('searchParams', JSON.stringify({
                            source: source,
                            destination: destination,
                            date: date
                        }));
                        
                        window.location.href = '/dashboard?search=true';
                    } else {
                        Swal.fire({
                            title: 'Incomplete Information',
                            text: 'Please fill all search fields',
                            icon: 'warning',
                            confirmButtonColor: '#667eea'
                        });
                    }
                });
            }
        }

        // Initialize Smooth Scrolling
        function initializeSmoothScrolling() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }

        // Enhanced Persistent Autocomplete System
        function initializeAutocomplete() {
            const inputConfigs = [
                { 
                    input: document.getElementById('homeSource'), 
                    results: document.getElementById('homeSourceResults'),
                    key: 'source'
                },
                { 
                    input: document.getElementById('homeDestination'), 
                    results: document.getElementById('homeDestinationResults'),
                    key: 'destination'
                }
            ];

            inputConfigs.forEach(config => {
                if (!config.input || !config.results) return;

                // Initialize variables for this input
                activeIndices.set(config.key, -1);
                
                // Input event - triggers on every keystroke
                config.input.addEventListener('input', function() {
                    handleInputChange(this, config.results, config.key);
                });

                // Focus event - triggers when user clicks/focuses on input
                config.input.addEventListener('focus', function() {
                    const query = this.value.trim();
                    if (query.length >= 2) {
                        // Show cached results immediately if available
                        if (autocompleteCache.has(query)) {
                            displayCachedResults(autocompleteCache.get(query), config.results, this, query, config.key);
                        } else {
                            searchLocations(query, config.results, this, config.key);
                        }
                    }
                });

                // Blur event - hide results after delay to allow for clicks
                config.input.addEventListener('blur', function() {
                    setTimeout(() => {
                        hideResults(config.results, config.key);
                    }, 200);
                });

                // Keyboard navigation
                config.input.addEventListener('keydown', function(e) {
                    handleKeyboardNavigation(e, config.results, this, config.key);
                });
            });

            // Global click handler to close dropdowns
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-input-group')) {
                    inputConfigs.forEach(config => {
                        hideResults(config.results, config.key);
                    });
                }
            });

            console.log('Autocomplete system initialized');
        }

        function handleInputChange(input, resultsDiv, key) {
            const query = input.value.trim();
            activeIndices.set(key, -1);
            
            if (query.length < 2) {
                hideResults(resultsDiv, key);
                return;
            }
            
            // Check cache first
            if (autocompleteCache.has(query)) {
                displayCachedResults(autocompleteCache.get(query), resultsDiv, input, query, key);
                return;
            }
            
            // Debounce the search
            clearTimeout(currentRequests.get(key));
            const timeoutId = setTimeout(() => {
                searchLocations(query, resultsDiv, input, key);
            }, 300);
            currentRequests.set(key, timeoutId);
        }

        function handleKeyboardNavigation(e, resultsDiv, input, key) {
            const items = resultsDiv.querySelectorAll('.autocomplete-item:not(.loading-item)');
            
            if (items.length === 0) return;
            
            let currentIndex = activeIndices.get(key);
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    currentIndex = Math.min(currentIndex + 1, items.length - 1);
                    activeIndices.set(key, currentIndex);
                    updateActiveItem(items, currentIndex);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    currentIndex = Math.max(currentIndex - 1, -1);
                    activeIndices.set(key, currentIndex);
                    updateActiveItem(items, currentIndex);
                    break;
                case 'Enter':
                    e.preventDefault();
                    if (currentIndex >= 0 && items[currentIndex]) {
                        selectLocationFromElement(items[currentIndex], input, resultsDiv, key);
                    }
                    break;
                case 'Escape':
                    hideResults(resultsDiv, key);
                    activeIndices.set(key, -1);
                    break;
            }
        }

        async function searchLocations(query, resultsDiv, inputElement, key) {
            // Cancel previous request
            const existingController = currentRequests.get(`${key}_controller`);
            if (existingController) {
                existingController.abort();
            }

            // Show loading
            showLoading(resultsDiv, key);

            try {
                const controller = new AbortController();
                currentRequests.set(`${key}_controller`, controller);

                const url = `https://nominatim.openstreetmap.org/search?format=json&limit=8&countrycodes=in&q=${encodeURIComponent(query)}&addressdetails=1`;
                
                const response = await fetch(url, {
                    signal: controller.signal,
                    headers: {
                        'User-Agent': 'CarpoolIndia/1.0'
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                
                // Cache the results
                autocompleteCache.set(query, data);
                
                if (data && data.length > 0) {
                    displayResults(data, resultsDiv, inputElement, query, key);
                } else {
                    showNoResults(resultsDiv, query, key);
                }

            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Autocomplete error:', error);
                    showError(resultsDiv, key);
                }
            } finally {
                currentRequests.delete(`${key}_controller`);
            }
        }

        function displayResults(locations, resultsDiv, inputElement, query, key) {
            const html = locations.map((location, index) => {
                const displayName = location.display_name;
                const mainName = displayName.split(',')[0];
                const address = displayName.split(',').slice(1, 3).join(',');
                const icon = getLocationIcon(location.type || location.class);
                
                return `
                    <div class="autocomplete-item" data-index="${index}" onclick="selectLocationFromClick('${location.display_name.replace(/'/g, "\\'")}', '${inputElement.id}', '${resultsDiv.id}', '${key}')">
                        <div class="autocomplete-icon">
                            <i class="${icon}"></i>
                        </div>
                        <div class="autocomplete-text">
                            <div class="autocomplete-main">${highlightMatch(mainName, query)}</div>
                            <div class="autocomplete-sub">${address}</div>
                        </div>
                    </div>
                `;
            }).join('');

            resultsDiv.innerHTML = html;
            showResults(resultsDiv, key);
        }

        function displayCachedResults(locations, resultsDiv, inputElement, query, key) {
            displayResults(locations, resultsDiv, inputElement, query, key);
        }

        function showLoading(resultsDiv, key) {
            resultsDiv.innerHTML = `
                <div class="loading-item">
                    <div class="spinner"></div>
                    <span>Searching locations...</span>
                </div>
            `;
            showResults(resultsDiv, key);
        }

        function showNoResults(resultsDiv, query, key) {
            resultsDiv.innerHTML = `
                <div class="autocomplete-item">
                    <div class="autocomplete-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="autocomplete-text">
                        <div class="autocomplete-main">No locations found for "${query}"</div>
                        <div class="autocomplete-sub">Try searching for a city or landmark</div>
                    </div>
                </div>
            `;
            showResults(resultsDiv, key);
        }

        function showError(resultsDiv, key) {
            resultsDiv.innerHTML = `
                <div class="autocomplete-item">
                    <div class="autocomplete-icon">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                    </div>
                    <div class="autocomplete-text">
                        <div class="autocomplete-main">Unable to search locations</div>
                        <div class="autocomplete-sub">Please check your internet connection</div>
                    </div>
                </div>
            `;
            showResults(resultsDiv, key);
        }

        function showResults(resultsDiv, key) {
            resultsDiv.classList.remove('d-none');
            resultsDiv.classList.add('show');
            resultsDiv.style.display = 'block';
        }

        function hideResults(resultsDiv, key) {
            resultsDiv.classList.add('d-none');
            resultsDiv.classList.remove('show');
            resultsDiv.style.display = 'none';
            activeIndices.set(key, -1);
        }

        function getLocationIcon(type) {
            switch(type?.toLowerCase()) {
                case 'city':
                case 'town':
                case 'village':
                    return 'fas fa-city';
                case 'airport':
                case 'aerodrome':
                    return 'fas fa-plane';
                case 'railway':
                case 'station':
                    return 'fas fa-train';
                case 'bus_stop':
                    return 'fas fa-bus';
                case 'amenity':
                    return 'fas fa-map-pin';
                default:
                    return 'fas fa-map-marker-alt';
            }
        }

        function highlightMatch(text, query) {
            if (!query) return text;
            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            return text.replace(regex, '<strong>$1</strong>');
        }

        function updateActiveItem(items, activeIndex) {
            items.forEach((item, index) => {
                if (index === activeIndex) {
                    item.classList.add('active');
                    item.scrollIntoView({ block: 'nearest' });
                } else {
                    item.classList.remove('active');
                }
            });
        }

        function selectLocationFromElement(item, input, results, key) {
            const locationName = item.querySelector('.autocomplete-main').textContent;
            input.value = locationName;
            hideResults(results, key);
        }

        // Global function for onclick events
        function selectLocationFromClick(locationName, inputId, resultsId, key) {
            const input = document.getElementById(inputId);
            const results = document.getElementById(resultsId);
            
            if (input && results) {
                input.value = locationName;
                hideResults(results, key);
            }
        }

        // Book ride function with enhanced error handling
        async function bookRide(rideId, driverName) {
            <?php if (Security::isLoggedIn()): ?>
                try {
                    const { value: message } = await Swal.fire({
                        title: `Book ride with ${driverName}?`,
                        text: 'Send a booking request with optional message',
                        input: 'textarea',
                        inputPlaceholder: 'Optional message for the driver...',
                        showCancelButton: true,
                        confirmButtonText: 'Send Request',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#667eea',
                        cancelButtonColor: '#6c757d',
                        customClass: {
                            popup: 'rounded-3',
                            confirmButton: 'rounded-pill',
                            cancelButton: 'rounded-pill'
                        }
                    });

                    if (message !== undefined) {
                        Swal.fire({
                            title: 'Sending Request...',
                            text: 'Please wait while we process your booking request',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Simulate API call
                        setTimeout(() => {
                            Swal.fire({
                                title: 'Request Sent Successfully!',
                                text: `Your booking request has been sent to ${driverName}. You'll receive a notification once they respond.`,
                                icon: 'success',
                                confirmButtonColor: '#10b981',
                                customClass: {
                                    popup: 'rounded-3',
                                    confirmButton: 'rounded-pill'
                                }
                            });
                        }, 2000);
                    }
                } catch (error) {
                    console.error('Booking error:', error);
                    Swal.fire({
                        title: 'Booking Failed',
                        text: 'Failed to send booking request. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            <?php else: ?>
                Swal.fire({
                    title: 'Login Required',
                    text: 'Please login to book a ride and start saving money!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Login Now',
                    cancelButtonText: 'Maybe Later',
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/login';
                    }
                });
            <?php endif; ?>
        }

        // Helper function for map area search
        function searchRidesInArea(areaName) {
            document.getElementById('homeSource').value = areaName;
            document.getElementById('homeSource').focus();
            
            // Smooth scroll to search section
            document.getElementById('search').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        // Page visibility handling for persistent functionality
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && isInitialized) {
                // Re-initialize if needed when page becomes visible
                console.log('Page visible - autocomplete ready');
            }
        });

        // Window focus handling
        window.addEventListener('focus', function() {
            if (isInitialized) {
                console.log('Window focused - all systems ready');
            }
        });

        // Debug function
        function debugAutocomplete() {
            console.log('Autocomplete Debug Info:');
            console.log('Cache size:', autocompleteCache.size);
            console.log('Active indices:', Object.fromEntries(activeIndices));
            console.log('Current requests:', Object.fromEntries(currentRequests));
            console.log('Initialized:', isInitialized);
        }

        // Make debug function available globally
        window.debugAutocomplete = debugAutocomplete;
    </script>
</body>
</html>
