<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Carpool India | Transforming Urban Mobility</title>
    <meta name="description" content="Learn about Carpool India by Elite Corporate Solutions - India's leading carpooling platform connecting corporate professionals for sustainable commuting.">
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
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
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
            /* background: var(--elite-gradient); */
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 8px;
            font-weight: 600;
        }

        /* Creative Hero Section */
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
            background: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            opacity: 0.1;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.4rem;
            font-weight: 400;
            line-height: 1.6;
            opacity: 0.9;
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
            animation: float 20s infinite ease-in-out;
        }

        .shape:nth-child(1) { width: 120px; height: 120px; top: 15%; left: 8%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 180px; height: 180px; top: 65%; right: 8%; animation-delay: 7s; }
        .shape:nth-child(3) { width: 90px; height: 90px; bottom: 15%; left: 25%; animation-delay: 3s; }
        .shape:nth-child(4) { width: 150px; height: 150px; top: 40%; right: 30%; animation-delay: 10s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        /* Creative Cards */
        .creative-card {
            background: white;
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .creative-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .creative-card:hover::before {
            transform: scaleX(1);
        }

        .creative-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .creative-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 2rem;
            transition: transform 0.4s ease;
        }

        .creative-card:hover img {
            transform: scale(1.05);
        }

        /* Mission Vision Cards */
        .mission-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 25px;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .mission-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(102, 126, 234, 0.1), transparent);
            animation: rotate 20s linear infinite;
            z-index: 0;
        }

        .mission-card .content {
            position: relative;
            z-index: 1;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .vision-card {
            background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);
            border: 2px solid rgba(17, 153, 142, 0.2);
            border-radius: 25px;
            padding: 3rem;
            position: relative;
        }

        /* Stats Section */
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
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .stats-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .stats-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            color: white;
            position: relative;
        }

        .stats-icon::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb);
            z-index: -1;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 1; }
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Team Section */
        .team-section {
            background: white;
            padding: 6rem 0;
        }

        .team-card {
            background: white;
            border-radius: 25px;
            padding: 2rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .team-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .team-card:hover::before {
            left: 100%;
        }

        .team-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 2.5rem;
            margin: 0 auto 2rem;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .team-avatar::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #667eea);
            z-index: -1;
            animation: rotate 10s linear infinite;
        }

        /* Values Section */
        .values-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            padding: 6rem 0;
        }

        .value-card {
            background: white;
            border-radius: 25px;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            text-align: center;
            position: relative;
            height: 100%;
        }

        .value-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .value-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2rem;
            color: white;
            position: relative;
        }

        /* CTA Section */
        .cta-section {
            background: var(--primary-gradient);
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
            background: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
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

        /* Feature Grid */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-item {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Achievement Section */
        .achievement-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }

        .achievement-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--success-gradient);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .creative-card {
                padding: 1.5rem;
            }
            
            .mission-card,
            .vision-card {
                padding: 2rem;
            }

            .elite-badge {
                display: block;
                margin-left: 0;
                margin-top: 4px;
                width: fit-content;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation - Same as Homepage -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
              <img src="../public/images/logo1.png" width="190"  alt="">
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
                        <a class="nav-link fw-semibold" href="/about">About</a>
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
                        <a href="/login" class="btn btn-outline-primary me-2">Login</a>
                        <a href="/signup" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Creative Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content text-white" data-aos="fade-up">
                        <h1 class="hero-title">
                            About<br>
                            <span style="background: linear-gradient(45deg, #f093fb, #f5576c, #4facfe); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Carpool India</span>
                        </h1>
                        <p class="hero-subtitle mb-4">
                            Pioneering India's transportation revolution through intelligent carpooling solutions that connect corporate professionals, reduce environmental impact, and create meaningful communities across the nation.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="#mission" class="btn btn-primary btn-lg">
                                <i class="fas fa-rocket me-2"></i>Our Mission
                            </a>
                            <a href="#achievements" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-trophy me-2"></i>Our Achievements
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Team collaboration" class="img-fluid rounded" style="border-radius: 25px !important; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section id="mission" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Mission & Vision</h2>
                <p class="lead text-muted">Driving sustainable change through innovative transportation solutions</p>
            </div>

            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="mission-card">
                        <div class="content">
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-4">
                                    <div style="width: 80px; height: 80px; background: var(--primary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-bullseye text-white fs-2"></i>
                                    </div>
                                </div>
                                <h3 class="h2 fw-bold text-dark mb-0">Our Mission</h3>
                            </div>
                            <p class="lead text-muted mb-4">
                                To revolutionize urban mobility in India by creating the most trusted, secure, and efficient carpooling ecosystem that connects verified corporate professionals.
                            </p>
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Reduce traffic congestion by 30%</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Cut individual commuting costs by 60%</li>
                                <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i>Decrease carbon emissions significantly</li>
                                <li class="mb-0"><i class="fas fa-check-circle text-success me-3"></i>Foster professional communities</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="vision-card">
                        <div class="d-flex align-items-center mb-4">
                            <div class="me-4">
                                <div style="width: 80px; height: 80px; background: var(--success-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-eye text-white fs-2"></i>
                                </div>
                            </div>
                            <h3 class="h2 fw-bold text-dark mb-0">Our Vision</h3>
                        </div>
                        <p class="lead text-muted mb-4">
                            To become India's leading sustainable transportation platform by 2030, serving over 10 million users across 50+ cities.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fas fa-star text-warning me-3"></i>Leading platform for sustainable mobility</li>
                            <li class="mb-3"><i class="fas fa-star text-warning me-3"></i>Connected corporate ecosystem</li>
                            <li class="mb-3"><i class="fas fa-star text-warning me-3"></i>Cleaner air for future generations</li>
                            <li class="mb-0"><i class="fas fa-star text-warning me-3"></i>Economic and environmental prosperity</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Elite Corporate Solutions Story -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Elite Corporate Solutions</h2>
                <p class="lead text-muted">The visionary company behind Carpool India's revolutionary platform</p>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Corporate Excellence">
                        <h3 class="h2 fw-bold text-dark mb-4">Excellence in Innovation</h3>
                        <p class="text-muted mb-4 lead">
                            Elite Corporate Solutions stands as a beacon of innovation in India's corporate landscape, specializing in developing cutting-edge technology solutions that address real-world challenges faced by modern businesses and professionals.
                        </p>
                        <p class="text-muted mb-4">
                            Founded with the vision of transforming how corporations operate and interact, Elite Corporate Solutions has consistently delivered groundbreaking platforms that enhance efficiency, promote sustainability, and foster community connections.
                        </p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="fw-bold text-primary mb-1">15+</h4>
                                    <small class="text-muted">Years Experience</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="fw-bold text-success mb-1">500+</h4>
                                    <small class="text-muted">Corporate Clients</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Technology Innovation">
                        <h3 class="h2 fw-bold text-dark mb-4">Technology Leadership</h3>
                        <p class="text-muted mb-4 lead">
                            With a team of world-class engineers, designers, and business strategists, Elite Corporate Solutions leverages advanced technologies including AI, machine learning, and blockchain to create solutions that are not just innovative but also scalable and sustainable.
                        </p>
                        <p class="text-muted mb-4">
                            The company's commitment to research and development has resulted in multiple patents and industry recognition, establishing it as a thought leader in corporate technology solutions across India and beyond.
                        </p>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="fw-bold text-info mb-1">25+</h4>
                                    <small class="text-muted">Patents Filed</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <h4 class="fw-bold text-warning mb-1">98%</h4>
                                    <small class="text-muted">Client Satisfaction</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Carpool India Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Why Carpool India Exists</h2>
                <p class="lead text-muted">Addressing India's most pressing transportation challenges through innovative solutions</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Traffic Congestion">
                        <h3 class="h2 fw-bold text-dark mb-4">The Problem We Solve</h3>
                        <p class="text-muted mb-4 lead">
                            India's urban centers face unprecedented transportation challenges. With over 300 million vehicles on roads and growing at 7% annually, traffic congestion costs the economy over ₹1.47 lakh crore yearly in lost productivity.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fas fa-exclamation-triangle text-warning me-3"></i>Average commute time increased by 40% in major cities</li>
                            <li class="mb-3"><i class="fas fa-smog text-danger me-3"></i>Air pollution reaching hazardous levels in 15+ cities</li>
                            <li class="mb-3"><i class="fas fa-rupee-sign text-info me-3"></i>₹8,000+ monthly transportation costs per professional</li>
                            <li class="mb-3"><i class="fas fa-gas-pump text-primary me-3"></i>85% fuel dependency on imports draining forex reserves</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Carpool Solution">
                        <h3 class="h2 fw-bold text-dark mb-4">Our Innovative Solution</h3>
                        <p class="text-muted mb-4 lead">
                            Carpool India transforms urban mobility by connecting verified corporate professionals through intelligent matching algorithms, creating a trusted ecosystem that benefits individuals, businesses, and the environment.
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fas fa-users text-success me-3"></i>AI-powered matching ensuring 95% compatibility rates</li>
                            <li class="mb-3"><i class="fas fa-shield-alt text-primary me-3"></i>Corporate verification providing enhanced safety</li>
                            <li class="mb-3"><i class="fas fa-leaf text-success me-3"></i>Environmental impact tracking and reporting</li>
                            <li class="mb-3"><i class="fas fa-network-wired text-info me-3"></i>Professional networking opportunities during commutes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Achievements & Milestones -->
    <section id="achievements" class="py-5" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Achievements & Milestones</h2>
                <p class="lead text-muted">Celebrating our journey of creating positive impact across India</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="achievement-card text-center">
                        <div style="width: 100px; height: 100px; background: var(--success-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                            <i class="fas fa-award text-white fs-1"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-3">National Startup Award 2024</h3>
                        <p class="text-muted mb-4">
                            Recognized by the Government of India for outstanding contribution to sustainable transportation and innovative use of technology in addressing urban mobility challenges.
                        </p>
                        <div class="text-center">
                            <span class="badge bg-success rounded-pill px-3 py-2">Government Recognition</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="achievement-card text-center">
                        <div style="width: 100px; height: 100px; background: var(--info-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                            <i class="fas fa-leaf text-white fs-1"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-3">Green Business Certification</h3>
                        <p class="text-muted mb-4">
                            Certified as a Green Business by the Indian Green Business Certification Program for measurable environmental impact and sustainable business practices across operations.
                        </p>
                        <div class="text-center">
                            <span class="badge bg-info rounded-pill px-3 py-2">Environmental Excellence</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="achievement-card text-center">
                        <div style="width: 100px; height: 100px; background: var(--warning-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                            <i class="fas fa-star text-white fs-1"></i>
                        </div>
                        <h3 class="h4 fw-bold text-dark mb-3">Best Innovation in Mobility</h3>
                        <p class="text-muted mb-4">
                            Winner of the Tech Innovation Awards 2024 for revolutionary AI-powered carpooling platform that sets new standards in safety, efficiency, and user experience in Indian transportation.
                        </p>
                        <div class="text-center">
                            <span class="badge bg-warning rounded-pill px-3 py-2">Technology Innovation</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Achievements -->
            <div class="row g-4 mt-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-item">
                        <div class="d-flex align-items-center mb-4">
                            <div style="width: 60px; height: 60px; background: var(--purple-gradient); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                <i class="fas fa-certificate text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-dark mb-1">ISO 27001 Certification</h4>
                                <p class="text-muted mb-0">Information Security Management Excellence</p>
                            </div>
                        </div>
                        <p class="text-muted">
                            Achieved ISO 27001:2013 certification for implementing and maintaining robust information security management systems, ensuring the highest levels of data protection for our users and corporate partners.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-item">
                        <div class="d-flex align-items-center mb-4">
                            <div style="width: 60px; height: 60px; background: var(--orange-gradient); border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                <i class="fas fa-globe text-white fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold text-dark mb-1">UN SDG Recognition</h4>
                                <p class="text-muted mb-0">Sustainable Development Goals Contributor</p>
                            </div>
                        </div>
                        <p class="text-muted">
                            Officially recognized by UN Global Compact India for significant contributions to SDG 11 (Sustainable Cities) and SDG 13 (Climate Action) through innovative carpooling solutions and environmental impact.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark">Impact Dashboard</h2>
                <p class="lead text-muted">Numbers that showcase our growing impact across India</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--primary-gradient);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stats-number">2024</div>
                        <h5 class="fw-bold text-dark mb-2">Founded</h5>
                        <p class="text-muted mb-0">Elite Corporate Solutions</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-city"></i>
                        </div>
                        <div class="stats-number">25+</div>
                        <h5 class="fw-bold text-dark mb-2">Cities Covered</h5>
                        <p class="text-muted mb-0">And Rapidly Growing</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stats-number">500+</div>
                        <h5 class="fw-bold text-dark mb-2">Corporate Partners</h5>
                        <p class="text-muted mb-0">Fortune 500 & Startups</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="stats-card">
                        <div class="stats-icon" style="background: var(--warning-gradient);">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stats-number">4.8</div>
                        <h5 class="fw-bold text-dark mb-2">User Rating</h5>
                        <p class="text-muted mb-0">Industry-Leading Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Team */
    <section class="team-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Leadership Team</h2>
                <p class="lead text-muted">Visionary leaders driving India's transportation revolution with decades of combined expertise</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="team-card">
                        <div class="team-avatar">RK</div>
                        <h4 class="fw-bold text-dark mb-2">Rajesh Kumar</h4>
                        <p class="text-primary fw-semibold mb-3">Founder & CEO</p>
                        <p class="text-muted mb-4">Former Director at Tata Motors with 15+ years in automotive and mobility solutions. MBA from IIM Bangalore. Led digital transformation initiatives affecting 10M+ customers across automotive sector.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-primary fs-5"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted fs-5"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="team-card">
                        <div class="team-avatar" style="background: var(--success-gradient);">PS</div>
                        <h4 class="fw-bold text-dark mb-2">Priya Sharma</h4>
                        <p class="text-success fw-semibold mb-3">Co-Founder & CTO</p>
                        <p class="text-muted mb-4">Former Senior Engineering Manager at Flipkart, scaling systems for 400M+ users. IIT Delhi graduate with 8 patents in mobile technology and AI. Expert in building resilient, scalable platforms.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-primary fs-5"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted fs-5"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="team-card">
                        <div class="team-avatar" style="background: var(--info-gradient);">AM</div>
                        <h4 class="fw-bold text-dark mb-2">Amit Mehta</h4>
                        <p class="text-info fw-semibold mb-3">Chief Operating Officer</p>
                        <p class="text-muted mb-4">Former VP Operations at Ola with 12+ years in scaling mobility operations across India. Successfully launched operations in 50+ cities and managed 100K+ daily rides during tenure.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="text-primary fs-5"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-muted fs-5"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </section>

    <!-- Core Values */
    <section class="values-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Our Core Values</h2>
                <p class="lead text-muted">Principles that guide every decision we make and shape our company culture</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-card">
                        <div class="value-icon" style="background: var(--primary-gradient);">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Trust & Integrity</h4>
                        <p class="text-muted">Building unshakeable trust through transparent communication, ethical business practices, verified user profiles, and consistent reliability in every interaction.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-card">
                        <div class="value-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Sustainability Focus</h4>
                        <p class="text-muted">Unwavering commitment to environmental protection through innovative shared mobility solutions that reduce carbon emissions and promote cleaner cities.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-card">
                        <div class="value-icon" style="background: var(--warning-gradient);">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Innovation Excellence</h4>
                        <p class="text-muted">Continuously pushing boundaries through cutting-edge technology, user-centric design, data-driven insights, and creative problem-solving approaches.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="value-card">
                        <div class="value-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Community Spirit</h4>
                        <p class="text-muted">Fostering meaningful connections, professional networking opportunities, and supportive ecosystem where every member feels valued and part of positive change.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology & Innovation */
    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Technology & Innovation</h2>
                <p class="lead text-muted">Powered by cutting-edge technology and innovative algorithms that set industry standards</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="AI Technology">
                        <div style="text-align: center;">
                            <div style="width: 80px; height: 80px; background: var(--primary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                <i class="fas fa-brain text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark mb-3 text-center">AI-Powered Matching</h4>
                        <p class="text-muted text-center mb-4">Our proprietary machine learning algorithms analyze over 50 data points including route patterns, timing preferences, professional backgrounds, and personality traits to create perfect carpool matches with 95% compatibility success rate.</p>
                        <ul class="list-unstyled text-center">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Route optimization algorithms</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Behavioral pattern analysis</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Predictive scheduling systems</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Dynamic pricing models</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Security">
                        <div style="text-align: center;">
                            <div style="width: 80px; height: 80px; background: var(--success-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                <i class="fas fa-shield-alt text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark mb-3 text-center">Advanced Security</h4>
                        <p class="text-muted text-center mb-4">Multi-layered security infrastructure including blockchain-based verification, real-time tracking, emergency response systems, and comprehensive background checks ensure every journey is completely safe and secure.</p>
                        <ul class="list-unstyled text-center">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>256-bit encryption protocol</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Real-time GPS tracking</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Emergency alert system</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Biometric verification</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="creative-card">
                        <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Mobile Experience">
                        <div style="text-align: center;">
                            <div style="width: 80px; height: 80px; background: var(--info-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                <i class="fas fa-mobile-alt text-white fs-2"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold text-dark mb-3 text-center">Mobile-First Design</h4>
                        <p class="text-muted text-center mb-4">Intuitive mobile applications with offline capabilities, voice commands, smart notifications, and seamless payment integration designed specifically for India's diverse user base and varying connectivity conditions.</p>
                        <ul class="list-unstyled text-center">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Offline mode support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Voice-based commands</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Multi-language support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Low-bandwidth optimization</li>
                        </ul>
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
                    <h2 class="display-4 fw-bold mb-4">Ready to Transform Your Commute?</h2>
                    <p class="lead mb-5">Join thousands of professionals who trust Carpool India for their daily transportation needs and become part of India's largest sustainable mobility community</p>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="h3 fw-bold">₹2,000+</div>
                            <p class="opacity-90">Average Monthly Savings</p>
                        </div>
                        <div class="col-md-4">
                            <div class="h3 fw-bold">70%</div>
                            <p class="opacity-90">Reduced Commute Stress</p>
                        </div>
                        <div class="col-md-4">
                            <div class="h3 fw-bold">100+</div>
                            <p class="opacity-90">New Connections Monthly</p>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="/signup" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket me-2"></i>Get Started Today
                        </a>
                        <a href="/contact" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>Contact Us
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
                    <p class="text-muted">India's most trusted carpool network connecting verified professionals for smarter, greener commuting.</p>
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
            duration: 800,
            easing: 'ease-in-out',
            once: true
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

        // Stats number animation
        const statsNumbers = document.querySelectorAll('.stats-number');
        let hasAnimated = false;

        const animateStats = () => {
            if (hasAnimated) return;
            hasAnimated = true;

            statsNumbers.forEach((stat, index) => {
                setTimeout(() => {
                    stat.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        stat.style.transform = 'scale(1)';
                    }, 200);
                }, index * 100);
            });
        };

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStats();
                        observer.unobserve(entry.target);
                    }
                });
            });
            observer.observe(statsSection);
        }

        // Add interactive hover effects to cards
        document.querySelectorAll('.creative-card, .team-card, .value-card, .achievement-card, .feature-item').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
