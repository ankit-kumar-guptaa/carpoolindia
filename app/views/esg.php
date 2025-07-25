<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESG Impact - Carpool India | Environmental, Social & Governance Excellence</title>
    <meta name="description" content="Discover Carpool India's comprehensive ESG initiatives by Elite Corporate Solutions. Leading sustainable transportation with environmental stewardship, social responsibility, and governance excellence.">
    <meta name="csrf-token" content="<?= $csrf_token ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
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
            --green-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --teal-gradient: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
            line-height: 1.6;
        }

        /* Navigation - Same as Homepage */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
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
            background: var(--elite-gradient);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 8px;
            font-weight: 600;
        }

        /* Enhanced Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 30%, #667eea 70%, #764ba2 100%);
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
            background: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.4rem;
            font-weight: 400;
            line-height: 1.6;
            opacity: 0.95;
            text-shadow: 0 1px 5px rgba(0,0,0,0.3);
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
            animation: float 25s infinite ease-in-out;
        }

        .shape:nth-child(1) { width: 150px; height: 150px; top: 10%; left: 5%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 200px; height: 200px; top: 70%; right: 5%; animation-delay: 8s; }
        .shape:nth-child(3) { width: 100px; height: 100px; bottom: 10%; left: 20%; animation-delay: 4s; }
        .shape:nth-child(4) { width: 180px; height: 180px; top: 35%; right: 25%; animation-delay: 12s; }
        .shape:nth-child(5) { width: 120px; height: 120px; top: 60%; left: 40%; animation-delay: 6s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
            25% { transform: translateY(-20px) rotate(90deg); opacity: 0.2; }
            50% { transform: translateY(-40px) rotate(180deg); opacity: 0.15; }
            75% { transform: translateY(-20px) rotate(270deg); opacity: 0.2; }
        }

        /* Enhanced Card System */
        .esg-card {
            background: white;
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.8);
            height: 100%;
        }

        .esg-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--success-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .esg-card:hover::before {
            transform: scaleX(1);
        }

        .esg-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        }

        .esg-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 2rem;
            transition: transform 0.4s ease;
        }

        .esg-card:hover img {
            transform: scale(1.08);
        }

        /* Enhanced Icons */
        .feature-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
            position: relative;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2, #11998e, #38ef7d);
            z-index: -1;
            animation: pulse-ring 3s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        /* Stats Section Enhancement */
        .stats-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 6rem 0;
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
            border-radius: 25px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .stats-card:hover {
            transform: translateY(-20px) scale(1.05);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
        }

        .stats-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
            position: relative;
        }

        .stats-icon::after {
            content: '';
            position: absolute;
            top: -8px;
            left: -8px;
            right: -8px;
            bottom: -8px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, #667eea, #764ba2, #11998e, #38ef7d, #667eea);
            z-index: -1;
            animation: rotate-border 10s linear infinite;
        }

        @keyframes rotate-border {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stats-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Governance Cards */
        .governance-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 25px;
            padding: 3rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .governance-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            animation: rotate 25s linear infinite;
            z-index: 0;
        }

        .governance-card .content {
            position: relative;
            z-index: 1;
        }

        .governance-card:hover {
            transform: translateY(-10px);
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }

        /* Progress Bars */
        .progress-enhanced {
            height: 8px;
            border-radius: 20px;
            background: #e9ecef;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-enhanced {
            height: 100%;
            border-radius: 20px;
            background: var(--success-gradient);
            position: relative;
            overflow: hidden;
            transition: width 2s ease-in-out;
        }

        .progress-bar-enhanced::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Timeline Enhancement */
        .commitment-timeline {
            position: relative;
            padding: 3rem 0;
        }

        .commitment-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 4px;
            height: 100%;
            background: var(--success-gradient);
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 4rem;
            display: flex;
            align-items: center;
        }

        .timeline-content {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            width: 45%;
            position: relative;
        }

        .timeline-item:nth-child(odd) .timeline-content {
            margin-left: auto;
        }

        .timeline-item:nth-child(even) .timeline-content {
            margin-right: auto;
        }

        .timeline-dot {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--success-gradient);
            transform: translate(-50%, -50%);
            box-shadow: 0 0 0 8px white, 0 0 0 12px rgba(17, 153, 142, 0.3);
            z-index: 10;
        }

        /* CTA Section */
        .cta-section {
            background: var(--success-gradient);
            padding: 6rem 0;
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
            background: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.1;
        }

        /* Footer - Same as Homepage */
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
            /* border: 2px solid white; */
            /* color: white; */
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

        /* Enhanced Sections */
        .impact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .impact-item {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .impact-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Responsive */
        @media (max-width: 768px) {
          
            .hero-section{
                padding-top: 90px;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .esg-card {
                padding: 2rem;
            }

            .elite-badge {
                display: block;
                margin-left: 0;
                margin-top: 4px;
                width: fit-content;
            }

            .commitment-timeline::before {
                left: 2rem;
            }

            .timeline-content {
                width: calc(100% - 4rem);
                margin-left: 4rem !important;
                margin-right: 0 !important;
            }

            .timeline-dot {
                left: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation - Same as Homepage -->
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
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="/esg">ESG Impact</a>
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
                        <a href="/login" class="btn btn-outline-primary me-2">Login</a>
                        <a href="/signup" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-content text-white" data-aos="fade-up">
                        <h1 class="hero-title">
                            ESG Excellence &<br>
                            <span style="background: linear-gradient(45deg, #f093fb, #f5576c, #4facfe, #00f2fe); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Sustainable Future</span>
                        </h1>
                        <p class="hero-subtitle mb-5">
                            Leading India's transformation towards sustainable transportation through comprehensive Environmental, Social, and Governance initiatives. Every shared ride creates a ripple effect of positive change across communities, economies, and ecosystems.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-4 justify-content-center">
                            <a href="#environmental" class="btn btn-primary btn-lg">
                                <i class="fas fa-leaf me-2"></i>Environmental Impact
                            </a>
                            <a href="#social" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-users me-2"></i>Social Responsibility
                            </a>
                            <a href="#governance" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-balance-scale me-2"></i>Governance Excellence
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ESG Vision & Philosophy -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-lg-10 text-center">
                    <h2 class="display-4 fw-bold text-dark mb-5">Our ESG Philosophy</h2>
                    <div class="row g-4">
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="esg-card">
                                <div class="feature-icon" style="background: var(--success-gradient);">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-3">Regenerative Impact</h4>
                                <p class="text-muted leading-relaxed">
                                    We don't just aim to be carbon neutral—we strive to create regenerative value that actively improves environmental and social conditions. Our platform contributes to ecosystem restoration, air quality improvement, and community building across India's urban landscapes.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="esg-card">
                                <div class="feature-icon" style="background: var(--info-gradient);">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-3">Data-Driven Decisions</h4>
                                <p class="text-muted leading-relaxed">
                                    Every ESG initiative is backed by rigorous data collection, real-time monitoring, and transparent reporting. We use advanced analytics to measure our environmental footprint, social impact, and governance effectiveness, ensuring accountability and continuous improvement.
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="esg-card">
                                <div class="feature-icon" style="background: var(--purple-gradient);">
                                    <i class="fas fa-infinity"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-3">Long-term Vision</h4>
                                <p class="text-muted leading-relaxed">
                                    Our ESG commitments are designed with a 2050 carbon-neutral vision, ensuring today's actions contribute to generational sustainability. We integrate circular economy principles, stakeholder capitalism, and systems thinking into every business decision.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Impact Stats -->
    

    <!-- Environmental Stewardship Section */
    <section id="environmental" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold text-dark mb-4">Environmental Stewardship</h2>
                <p class="lead text-muted mb-5">Leading India's transition to sustainable mobility through innovative solutions</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="esg-card">
                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Clean Air Initiative">
                        <div class="feature-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-wind"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Air Quality Transformation</h4>
                        <p class="text-muted mb-4">
                            Each carpooled journey eliminates an average of 1.8 vehicles from congested urban roads, directly contributing to reduced particulate matter (PM2.5), nitrogen oxides (NOx), and carbon monoxide emissions. Our platform specifically targets high-pollution corridors in Delhi, Mumbai, Bangalore, and other metro cities.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>PM2.5 reduction by 15% in target corridors</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>NOx emissions cut by 22% per route</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Air quality monitoring partnerships</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="esg-card">
                        <img src="https://images.unsplash.com/photo-1473773508845-188df298d2d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Climate Action">
                        <div class="feature-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-thermometer-half"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Climate Action Leadership</h4>
                        <p class="text-muted mb-4">
                            By optimizing vehicle occupancy rates from 1.2 to 3.5 passengers per trip, we contribute significantly to India's Nationally Determined Contributions (NDCs) under the Paris Agreement. Every shared ride prevents approximately 5.2 kg of CO₂ emissions while reducing urban heat island effects.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i>Carbon intensity reduction by 75%</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i>Climate risk assessment integration</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-info me-2"></i>Paris Agreement alignment certified</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Environmental Initiatives Grid -->
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="impact-item">
                        <i class="fas fa-tree fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold">Urban Reforestation</h5>
                        <p class="text-muted">Partnership with municipal corporations to convert parking spaces into green corridors and urban forests</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="impact-item">
                        <i class="fas fa-bolt fs-1 text-warning mb-3"></i>
                        <h5 class="fw-bold">EV Integration</h5>
                        <p class="text-muted">Priority matching for electric vehicles and partnerships with EV manufacturers for fleet electrification</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="impact-item">
                        <i class="fas fa-recycle fs-1 text-info mb-3"></i>
                        <h5 class="fw-bold">Circular Economy</h5>
                        <p class="text-muted">Waste reduction initiatives and sustainable resource utilization across all platform operations</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="impact-item">
                        <i class="fas fa-solar-panel fs-1 text-orange mb-3"></i>
                        <h5 class="fw-bold">Renewable Energy</h5>
                        <p class="text-muted">100% renewable energy for all office operations and data centers by 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Responsibility Section */
    <section id="social" class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold text-dark mb-4">Social Impact & Responsibility</h2>
                <p class="lead text-muted mb-5">Building inclusive communities and empowering lives through accessible mobility</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="esg-card">
                        <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Professional Networking">
                        <div class="feature-icon" style="background: var(--orange-gradient);">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Professional Ecosystem Building</h4>
                        <p class="text-muted mb-4">
                            Connecting professionals across industries, seniority levels, and company sizes to create a robust knowledge-sharing ecosystem. Our platform has facilitated over 180,000 professional connections, leading to mentorship opportunities, job referrals, and collaborative projects.
                        </p>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h5 text-primary fw-bold">85%</div>
                                <small class="text-muted">Cross-industry connections</small>
                            </div>
                            <div class="col-6">
                                <div class="h5 text-success fw-bold">92%</div>
                                <small class="text-muted">Long-term professional relationships</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="esg-card">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Women Safety">
                        <div class="feature-icon" style="background: var(--purple-gradient);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Women's Safety & Empowerment</h4>
                        <p class="text-muted mb-4">
                            Comprehensive safety ecosystem including female-only carpools, real-time tracking, emergency response protocols, and 24/7 support. Our women's safety program has enabled 15,000+ women to commute confidently while building professional networks.
                        </p>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h5 text-purple fw-bold">40%</div>
                                <small class="text-muted">Female user base</small>
                            </div>
                            <div class="col-6">
                                <div class="h5 text-info fw-bold">&lt;0.1%</div>
                                <small class="text-muted">Safety incidents</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="esg-card">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Economic Empowerment">
                        <div class="feature-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Economic Empowerment</h4>
                        <p class="text-muted mb-4">
                            Reducing transportation costs by up to 65% for users while creating additional income streams for drivers. Our platform has generated ₹50+ crores in economic value, with savings typically reinvested in education, healthcare, and skill development.
                        </p>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h5 text-success fw-bold">₹8,500</div>
                                <small class="text-muted">Average monthly income supplement</small>
                            </div>
                            <div class="col-6">
                                <div class="h5 text-warning fw-bold">65%</div>
                                <small class="text-muted">Cost savings for users</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Programs -->
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="esg-card">
                        <h4 class="fw-bold text-dark mb-4">
                            <i class="fas fa-hands-helping text-primary me-3"></i>
                            Community Outreach Programs
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="fw-bold text-primary">Emergency Response Network</h6>
                                    <p class="text-muted small mb-0">Free carpooling during disasters and medical emergencies</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="fw-bold text-success">Education Outreach</h6>
                                    <p class="text-muted small mb-0">Sustainability workshops in 200+ schools annually</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="fw-bold text-warning">Skill Development</h6>
                                    <p class="text-muted small mb-0">Professional training for drivers and platform users</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded">
                                    <h6 class="fw-bold text-info">Healthcare Access</h6>
                                    <p class="text-muted small mb-0">Medical ride assistance for senior citizens</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="esg-card">
                        <h4 class="fw-bold text-dark mb-4">
                            <i class="fas fa-globe text-success me-3"></i>
                            Inclusion & Diversity Initiatives
                        </h4>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-wheelchair text-info me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Accessibility Program</h6>
                                    <p class="text-muted small mb-0">Wheelchair-accessible vehicles and special assistance for differently-abled users</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-language text-warning me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Multilingual Platform</h6>
                                    <p class="text-muted small mb-0">Support for 15+ Indian languages ensuring accessibility across diverse communities</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-graduation-cap text-purple me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Student Support</h6>
                                    <p class="text-muted small mb-0">Subsidized rates for students and interns, connecting them with working professionals</p>
                                </div>
                            </li>
                            <li class="mb-0 d-flex align-items-start">
                                <i class="fas fa-seedling text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Rural Connectivity</h6>
                                    <p class="text-muted small mb-0">Extending services to tier-2 and tier-3 cities for inclusive growth</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Governance Excellence Section */
    <section id="governance" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold text-dark mb-4">Governance & Ethics Excellence</h2>
                <p class="lead text-muted mb-5">Upholding the highest standards of transparency, accountability, and ethical business practices</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="governance-card">
                        <div class="content">
                            <div class="feature-icon mb-4" style="background: var(--primary-gradient);">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-4">Board Structure & Leadership</h4>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h4 text-primary fw-bold">60%</div>
                                        <small class="text-muted">Independent Directors</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h4 text-success fw-bold">40%</div>
                                        <small class="text-muted">Women Board Members</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h6 text-info fw-bold">Active</div>
                                        <small class="text-muted">ESG Committee</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-3 border rounded">
                                        <div class="h6 text-warning fw-bold">Quarterly</div>
                                        <small class="text-muted">Board Reviews</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="governance-card">
                        <div class="content">
                            <div class="feature-icon mb-4" style="background: var(--success-gradient);">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-4">Data Protection & Privacy</h4>
                            <ul class="list-unstyled">
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>ISO 27001</strong> Certified Information Security
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>GDPR & CCPA</strong> Compliant Data Processing
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>End-to-end</strong> Encryption for All Communications
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>Regular</strong> Third-party Security Audits
                                </li>
                                <li class="py-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>Zero</strong> Data Breach Record Since Inception
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="governance-card">
                        <div class="content">
                            <div class="feature-icon mb-4" style="background: var(--purple-gradient);">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-4">Regulatory Compliance</h4>
                            <ul class="list-unstyled">
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-purple me-2"></i>
                                    <strong>RBI Guidelines</strong> Adherent Payment Systems
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-purple me-2"></i>
                                    <strong>IT Act 2000</strong> Compliant Digital Operations
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-purple me-2"></i>
                                    <strong>Competition Law</strong> Compliant Business Practices
                                </li>
                                <li class="py-2 border-bottom">
                                    <i class="fas fa-check-circle text-purple me-2"></i>
                                    <strong>Labor Laws</strong> Fully Adherent HR Policies
                                </li>
                                <li class="py-2">
                                    <i class="fas fa-check-circle text-purple me-2"></i>
                                    <strong>Environmental</strong> Norms Exceeded Consistently
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ethics & Transparency -->
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="esg-card">
                        <h4 class="fw-bold text-dark mb-4">
                            <i class="fas fa-handshake text-primary me-3"></i>
                            Ethical Business Framework
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 border rounded">
                                    <h6 class="fw-bold text-primary mb-2">Fair Pricing Policy</h6>
                                    <p class="text-muted small mb-0">Transparent algorithm-based pricing with no surge or hidden fees</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded">
                                    <h6 class="fw-bold text-success mb-2">Stakeholder Engagement</h6>
                                    <p class="text-muted small mb-0">Regular consultation with users, partners, and communities</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded">
                                    <h6 class="fw-bold text-warning mb-2">Transparency Reporting</h6>
                                    <p class="text-muted small mb-0">Quarterly reports on platform usage and impact metrics</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded">
                                    <h6 class="fw-bold text-info mb-2">Whistleblower Protection</h6>
                                    <p class="text-muted small mb-0">Anonymous reporting system with full legal protection</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="esg-card">
                        <h4 class="fw-bold text-dark mb-4">
                            <i class="fas fa-chart-bar text-success me-3"></i>
                            Performance Metrics
                        </h4>
                        <div class="space-y-4">
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <span class="fw-medium text-dark">Board Meeting Attendance</span>
                                <span class="h5 text-primary fw-bold mb-0">98%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <span class="fw-medium text-dark">Ethics Training Completion</span>
                                <span class="h5 text-success fw-bold mb-0">100%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <span class="fw-medium text-dark">Audit Recommendations Implemented</span>
                                <span class="h5 text-info fw-bold mb-0">100%</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <span class="fw-medium text-dark">Regulatory Violations</span>
                                <span class="h5 text-success fw-bold mb-0">0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                <span class="fw-medium text-dark">Customer Complaints Resolved</span>
                                <span class="h5 text-primary fw-bold mb-0">99.7%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Future Commitments & Goals */
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold text-dark mb-4">2030 Sustainability Roadmap</h2>
                <p class="lead text-muted mb-5">Our ambitious goals for creating lasting positive impact across India</p>
            </div>

            <div class="commitment-timeline">
                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold text-primary mb-0">2025: Carbon Neutral Operations</h4>
                            <span class="badge bg-success fs-6">Progress: 45%</span>
                        </div>
                        <p class="text-muted mb-3">
                            Achieve net-zero carbon emissions across all direct operations through renewable energy adoption, carbon offset programs, and green infrastructure development.
                        </p>
                        <div class="progress-enhanced mb-3">
                            <div class="progress-bar-enhanced" style="width: 45%"></div>
                        </div>
                        <ul class="list-unstyled small text-muted">
                            <li>• 100% renewable energy for all facilities</li>
                            <li>• Carbon offset partnerships with verified projects</li>
                            <li>• Green building certifications for all offices</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>

                <div class="timeline-item" data-aos="fade-left">
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold text-info mb-0">2027: 10 Million Lives Impacted</h4>
                            <span class="badge bg-info fs-6">Progress: 25%</span>
                        </div>
                        <p class="text-muted mb-3">
                            Positively impact 10 million lives through our platform, creating sustainable livelihoods, reducing transportation costs, and building stronger communities nationwide.
                        </p>
                        <div class="progress-enhanced mb-3">
                            <div class="progress-bar-enhanced" style="width: 25%; background: var(--info-gradient);"></div>
                        </div>
                        <ul class="list-unstyled small text-muted">
                            <li>• Direct employment for 50,000+ drivers</li>
                            <li>• Transportation savings of ₹500 crores annually</li>
                            <li>• Professional networks spanning 100+ cities</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>

                <div class="timeline-item" data-aos="fade-right">
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold text-warning mb-0">2030: Smart Cities Integration</h4>
                            <span class="badge bg-warning fs-6">Progress: 12%</span>
                        </div>
                        <p class="text-muted mb-3">
                            Complete integration with all 100 Smart Cities in India, partnering with local governments to create comprehensive sustainable mobility ecosystems.
                        </p>
                        <div class="progress-enhanced mb-3">
                            <div class="progress-bar-enhanced" style="width: 12%; background: var(--warning-gradient);"></div>
                        </div>
                        <ul class="list-unstyled small text-muted">
                            <li>• Government partnerships in 100 cities</li>
                            <li>• Integrated public transport systems</li>
                            <li>• Smart traffic management contributions</li>
                        </ul>
                    </div>
                    <div class="timeline-dot"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovation & Technology Pipeline -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold text-dark mb-4">Innovation Pipeline for Sustainable Impact</h2>
                <p class="lead text-muted mb-5">Cutting-edge technologies driving our ESG objectives forward</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="esg-card text-center">
                        <div class="feature-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-charging-station"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">EV Ecosystem Integration</h5>
                        <p class="text-muted mb-4">
                            Priority matching for electric vehicles, charging infrastructure partnerships, and financial incentives for EV adoption among our driver community.
                        </p>
                        <ul class="list-unstyled small text-muted">
                            <li>• EV-only route options</li>
                            <li>• Charging station network partnerships</li>
                            <li>• EV purchase assistance programs</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="esg-card text-center">
                        <div class="feature-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">AI for Sustainability</h5>
                        <p class="text-muted mb-4">
                            Advanced AI algorithms for route optimization, demand prediction, emissions tracking, and carbon footprint minimization across all operations.
                        </p>
                        <ul class="list-unstyled small text-muted">
                            <li>• Predictive emissions modeling</li>
                            <li>• Dynamic route optimization</li>
                            <li>• Carbon credit automation</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="esg-card text-center">
                        <div class="feature-icon" style="background: var(--purple-gradient);">
                            <i class="fas fa-satellite"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">IoT & Smart Monitoring</h5>
                        <p class="text-muted mb-4">
                            Internet of Things integration for real-time vehicle monitoring, emissions tracking, air quality sensing, and predictive maintenance systems.
                        </p>
                        <ul class="list-unstyled small text-muted">
                            <li>• Real-time emissions monitoring</li>
                            <li>• Predictive maintenance alerts</li>
                            <li>• Air quality impact tracking</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="esg-card text-center">
                        <div class="feature-icon" style="background: var(--warning-gradient);">
                            <i class="fas fa-coins"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Blockchain ESG Rewards</h5>
                        <p class="text-muted mb-4">
                            Tokenized carbon credits, blockchain-based ESG scoring, and cryptocurrency rewards for users contributing to sustainability goals and community building.
                        </p>
                        <ul class="list-unstyled small text-muted">
                            <li>• Carbon credit tokenization</li>
                            <li>• ESG performance tokens</li>
                            <li>• Community governance voting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ESG Reporting & Accountability */
    <section class="py-5" style="background: linear-gradient(135deg, rgba(17, 153, 142, 0.05) 0%, rgba(56, 239, 125, 0.05) 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-4 fw-bold text-dark mb-4">ESG Reporting & Accountability Framework</h2>
                <p class="lead text-muted mb-5">Transparent reporting and third-party validation ensuring credibility and continuous improvement</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="esg-card">
                        <h4 class="fw-bold text-dark mb-4">
                            <i class="fas fa-certificate text-success me-3"></i>
                            International Reporting Standards
                        </h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded text-center">
                                    <i class="fas fa-globe text-success fs-3 mb-2"></i>
                                    <h6 class="fw-bold">GRI Standards</h6>
                                    <p class="text-muted small mb-0">Global Reporting Initiative comprehensive sustainability reporting</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded text-center">
                                    <i class="fas fa-chart-bar text-info fs-3 mb-2"></i>
                                    <h6 class="fw-bold">SASB Framework</h6>
                                    <p class="text-muted small mb-0">Sustainability Accounting Standards Board industry-specific metrics</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded text-center">
                                    <i class="fas fa-thermometer-half text-warning fs-3 mb-2"></i>
                                    <h6 class="fw-bold">TCFD Alignment</h6>
                                    <p class="text-muted small mb-0">Task Force on Climate-related Financial Disclosures</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded text-center">
                                    <i class="fas fa-target text-purple fs-3 mb-2"></i>
                                    <h6 class="fw-bold">UN SDGs Mapping</h6>
                                    <p class="text-muted small mb-0">Sustainable Development Goals contribution tracking</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="esg-card">
                        <h4 class="fw-bold text-dark mb-4">
                            <i class="fas fa-award text-warning me-3"></i>
                            Third-Party Validation & Audits
                        </h4>
                        <ul class="list-unstyled">
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Annual ESG Audits by KPMG</h6>
                                    <p class="text-muted small mb-0">Comprehensive assessment of all ESG metrics and initiatives</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-check-circle text-info me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Carbon Footprint Verification by Bureau Veritas</h6>
                                    <p class="text-muted small mb-0">Independent verification of emissions data and reduction claims</p>
                                </div>
                            </li>
                            <li class="mb-3 d-flex align-items-start">
                                <i class="fas fa-check-circle text-warning me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Social Impact Assessment by Accenture</h6>
                                    <p class="text-muted small mb-0">Detailed analysis of community and social impact programs</p>
                                </div>
                            </li>
                            <li class="mb-0 d-flex align-items-start">
                                <i class="fas fa-check-circle text-purple me-3 mt-1"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Governance Rating by IIAS</h6>
                                    <p class="text-muted small mb-0">Institutional Investor Advisory Services governance assessment</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- ESG Publications -->
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="impact-item">
                        <i class="fas fa-file-alt fs-1 text-primary mb-3"></i>
                        <h5 class="fw-bold">Annual ESG Report 2024</h5>
                        <p class="text-muted mb-3">Comprehensive 120-page report covering all ESG initiatives, impact metrics, and future commitments</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="impact-item">
                        <i class="fas fa-chart-line fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold">Real-time ESG Dashboard</h5>
                        <p class="text-muted mb-3">Live tracking of environmental impact, social metrics, and governance performance indicators</p>
                        <a href="#" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-external-link-alt me-2"></i>View Dashboard
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="impact-item">
                        <i class="fas fa-book fs-1 text-warning mb-3"></i>
                        <h5 class="fw-bold">Sustainability Playbook</h5>
                        <p class="text-muted mb-3">Best practices guide for corporate partners and industry stakeholders on implementing ESG initiatives</p>
                        <a href="#" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-book-open me-2"></i>Access Guide
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center" data-aos="fade-up">
                    <h2 class="display-3 fw-bold mb-4">Join the ESG Revolution</h2>
                    <p class="lead mb-5">
                        Every ride you share is a step towards a more sustainable, equitable, and well-governed future. Be part of India's largest community-driven ESG initiative and help create lasting positive change.
                    </p>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-md-3">
                            <div class="h2 fw-bold">5M+</div>
                            <p class="opacity-90">Tons CO₂ Prevented</p>
                        </div>
                        <div class="col-md-3">
                            <div class="h2 fw-bold">250K+</div>
                            <p class="opacity-90">Lives Positively Impacted</p>
                        </div>
                        <div class="col-md-3">
                            <div class="h2 fw-bold">500+</div>
                            <p class="opacity-90">Corporate Partners</p>
                        </div>
                        <div class="col-md-3">
                            <div class="h2 fw-bold">100%</div>
                            <p class="opacity-90">Ethical Operations</p>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-4">
                        <a href="/signup" class="btn btn-primary btn-lg">
                            <i class="fas fa-leaf me-2"></i>Start Your ESG Journey
                        </a>
                        <a href="/about" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-info-circle me-2"></i>Learn More About Us
                        </a>
                        <a href="/contact" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-handshake me-2"></i>Partner With Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer - Same as Homepage -->
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
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="public/js/app.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Navbar scroll effect - Same as Homepage
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Enhanced Counter Animation
        const statsNumbers = document.querySelectorAll('.stats-number');
        let hasAnimated = false;

        const animateCounters = () => {
            if (hasAnimated) return;
            hasAnimated = true;

            statsNumbers.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/,/g, ''));
                const duration = 2500;
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

        // Smooth scrolling
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

        // Progress bar animation
        const progressBars = document.querySelectorAll('.progress-bar-enhanced');
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 300);
                    progressObserver.unobserve(bar);
                }
            });
        });

        progressBars.forEach(bar => {
            progressObserver.observe(bar);
        });

        // Timeline dot animation
        const timelineItems = document.querySelectorAll('.timeline-item');
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const dot = entry.target.querySelector('.timeline-dot');
                    if (dot) {
                        dot.style.animation = 'pulse-dot 1.5s ease-in-out';
                    }
                }
            });
        }, { threshold: 0.5 });

        timelineItems.forEach(item => {
            timelineObserver.observe(item);
        });

        // Enhanced card interactions
        document.querySelectorAll('.esg-card, .governance-card, .impact-item').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            });
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse-dot {
                0% { transform: translate(-50%, -50%) scale(1); }
                50% { transform: translate(-50%, -50%) scale(1.3); }
                100% { transform: translate(-50%, -50%) scale(1); }
            }
            
            .rotate { animation: rotate 25s linear infinite; }
            
            @media (prefers-reduced-motion: reduce) {
                *, *::before, *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
