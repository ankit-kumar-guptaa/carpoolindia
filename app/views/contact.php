<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Carpool India | Get in Touch</title>
    <meta name="description" content="Contact Carpool India by Elite Corporate Solutions for support, partnerships, or inquiries. We're here to help with your carpooling needs.">
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

        /* Hero Section */
        .hero-section {
            min-height: 80vh;
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
            background: url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
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

        /* Contact Cards */
        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.8);
            height: 100%;
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .contact-icon {
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

        /* Form Styling */
        .form-card {
            background: white;
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .form-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
            z-index: 5;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
            padding-top: 1rem;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1.1rem;
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

        /* Office Hours */
        .office-hours {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 20px;
            padding: 2rem;
        }

        /* FAQ Section */
        .faq-item {
            background: white;
            border-radius: 15px;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .faq-answer {
            padding: 0 1.5rem 1.5rem;
            color: #6b7280;
            line-height: 1.6;
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
            
            .form-card {
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
                        <a class="nav-link" href="/esg">ESG Impact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold" href="/contact">Contact</a>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-content text-white" data-aos="fade-up">
                        <h1 class="hero-title">
                            Contact<br>
                            <span style="background: linear-gradient(45deg, #f093fb, #f5576c, #4facfe); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Carpool India</span>
                        </h1>
                        <p class="hero-subtitle mb-4">
                            We're here to help! Reach out to us for support, partnerships, or any questions about India's most trusted carpooling platform.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="#contact-form" class="btn btn-primary btn-lg">
                                <i class="fas fa-envelope me-2"></i>Send Message
                            </a>
                            <a href="#contact-info" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-phone me-2"></i>Call Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section id="contact-info" class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Get in Touch</h2>
                <p class="lead text-muted">Multiple ways to connect with our team</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card text-center">
                        <div class="contact-icon" style="background: var(--primary-gradient);">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Phone Support</h4>
                        <p class="text-muted mb-4">Speak with our support team directly for immediate assistance</p>
                        <div class="mb-3">
                            <strong class="text-dark">+91 98-CARPOOL</strong><br>
                            <span class="text-muted">(+91 9870364340)</span>
                        </div>
                        <small class="text-success">Available 24/7</small>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card text-center">
                        <div class="contact-icon" style="background: var(--success-gradient);">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Email Support</h4>
                        <p class="text-muted mb-4">Send us an email and we'll respond within 2 hours</p>
                        <div class="mb-3">
                            <strong class="text-dark">support@carpoolindia.com</strong><br>
                            <span class="text-muted">partnerships@carpoolindia.com</span>
                        </div>
                        <small class="text-info">Response within 2 hours</small>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card text-center">
                        <div class="contact-icon" style="background: var(--info-gradient);">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Office Location</h4>
                        <p class="text-muted mb-4">Visit our headquarters in the heart of India's tech capital</p>
                        <div class="mb-3">
                            <strong class="text-dark">Elite Corporate Solutions</strong><br>
                            <span class="text-muted">A-83, Okhla Phase II, <br> New Delhi – 110020, India</span>
                        </div>
                        <small class="text-warning">Mon-Fri: 9 AM - 7 PM IST</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section id="contact-form" class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-card" data-aos="fade-up">
                        <div class="text-center mb-5">
                            <h2 class="h1 fw-bold text-dark mb-4">Send us a Message</h2>
                            <p class="lead text-muted">Fill out the form below and we'll get back to you shortly</p>
                        </div>
                        
                        <form id="contactForm" action="/contact/submit" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group" data-aos="fade-right">
                                        <label class="form-label">Full Name *</label>
                                        <div class="position-relative">
                                            <i class="fas fa-user form-icon"></i>
                                            <input type="text" 
                                                   name="name" 
                                                   class="form-control" 
                                                   placeholder="Enter your full name"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" data-aos="fade-left">
                                        <label class="form-label">Email Address *</label>
                                        <div class="position-relative">
                                            <i class="fas fa-envelope form-icon"></i>
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control" 
                                                   placeholder="Enter your email"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group" data-aos="fade-right">
                                        <label class="form-label">Phone Number</label>
                                        <div class="position-relative">
                                            <i class="fas fa-phone form-icon"></i>
                                            <input type="tel" 
                                                   name="phone" 
                                                   class="form-control" 
                                                   placeholder="+91 12345 67890">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" data-aos="fade-left">
                                        <label class="form-label">Subject *</label>
                                        <div class="position-relative">
                                            <i class="fas fa-tag form-icon"></i>
                                            <select name="subject" class="form-control" required>
                                                <option value="">Select a subject</option>
                                                <option value="General Inquiry">General Inquiry</option>
                                                <option value="Technical Support">Technical Support</option>
                                                <option value="Partnership">Partnership Opportunity</option>
                                                <option value="Corporate Program">Corporate Program</option>
                                                <option value="Feedback">Feedback & Suggestions</option>
                                                <option value="Bug Report">Bug Report</option>
                                                <option value="Media Inquiry">Media Inquiry</option>
                                                <option value="Safety Concern">Safety Concern</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" data-aos="fade-up">
                                <label class="form-label">Message *</label>
                                <div class="position-relative">
                                    <i class="fas fa-comment form-icon" style="top: 1.5rem;"></i>
                                    <textarea name="message" 
                                              class="form-control" 
                                              rows="5"
                                              placeholder="Tell us how we can help you..."
                                              required></textarea>
                                </div>
                            </div>
                            
                            <div class="text-center" data-aos="fade-up">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Hours & Quick Info -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="office-hours">
                        <h3 class="fw-bold text-dark mb-4">
                            <i class="fas fa-clock text-primary me-3"></i>
                            Office Hours
                        </h3>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">Monday - Friday</span>
                                    <span class="text-success">9:00 AM - 7:00 PM</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">Saturday</span>
                                    <span class="text-warning">10:00 AM - 4:00 PM</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">Sunday</span>
                                    <span class="text-muted">Closed</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">Emergency Support</span>
                                    <span class="text-success">24/7 Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <h3 class="fw-bold text-dark mb-4">Quick Response Promise</h3>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-bolt text-warning fs-2 mb-2"></i>
                                <h5 class="fw-bold text-dark mb-1">Emergency</h5>
                                <small class="text-muted">Immediate Response</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-headset text-primary fs-2 mb-2"></i>
                                <h5 class="fw-bold text-dark mb-1">Support</h5>
                                <small class="text-muted">Within 2 Hours</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-handshake text-success fs-2 mb-2"></i>
                                <h5 class="fw-bold text-dark mb-1">Partnership</h5>
                                <small class="text-muted">Within 24 Hours</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-comments text-info fs-2 mb-2"></i>
                                <h5 class="fw-bold text-dark mb-1">General</h5>
                                <small class="text-muted">Within 4 Hours</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h1 fw-bold text-dark mb-4">Frequently Asked Questions</h2>
                <p class="lead text-muted">Quick answers to common questions</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>How do I sign up for Carpool India?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer" style="display: none;">
                            Simply click the "Sign Up" button, verify your corporate email address, complete your profile with necessary documents, and start finding or offering rides immediately.
                        </div>
                    </div>

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>Is Carpool India safe for daily commuting?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer" style="display: none;">
                            Yes! We have comprehensive safety measures including corporate email verification, background checks, real-time GPS tracking, emergency support, and insurance coverage for all rides.
                        </div>
                    </div>

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>How much can I save with carpooling?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer" style="display: none;">
                            Users typically save 60-70% on their commute costs by sharing fuel, tolls, and parking expenses. The average monthly savings range from ₹2,000 to ₹8,000 depending on your route.
                        </div>
                    </div>

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>What if I need to cancel a ride?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer" style="display: none;">
                            You can cancel rides through the app up to 2 hours before departure time without any charges. For emergency cancellations, contact our 24/7 support team.
                        </div>
                    </div>

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="faq-question" onclick="toggleFaq(this)">
                            <span>How does the matching algorithm work?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer" style="display: none;">
                            Our AI-powered algorithm considers route compatibility, timing preferences, professional backgrounds, ratings, and personal preferences to ensure 95%+ compatibility rates.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Media & Connect -->
    <!-- <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="h2 fw-bold text-dark mb-4">Connect With Us</h2>
                <p class="lead text-muted">Follow us on social media for updates and community discussions</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="row g-4">
                        <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                            <a href="#" class="text-decoration-none">
                                <div class="contact-card text-center h-100">
                                    <div class="contact-icon" style="background: #3b5998;">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Facebook</h6>
                                    <small class="text-muted">Follow for updates</small>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                            <a href="#" class="text-decoration-none">
                                <div class="contact-card text-center h-100">
                                    <div class="contact-icon" style="background: #1da1f2;">
                                        <i class="fab fa-twitter"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Twitter</h6>
                                    <small class="text-muted">Latest news</small>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                            <a href="#" class="text-decoration-none">
                                <div class="contact-card text-center h-100">
                                    <div class="contact-icon" style="background: #0077b5;">
                                        <i class="fab fa-linkedin-in"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">LinkedIn</h6>
                                    <small class="text-muted">Professional network</small>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                            <a href="#" class="text-decoration-none">
                                <div class="contact-card text-center h-100">
                                    <div class="contact-icon" style="background: #e4405f;">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark">Instagram</h6>
                                    <small class="text-muted">Community stories</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

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

        // FAQ Toggle Function
        function toggleFaq(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');
            
            if (answer.style.display === 'none' || answer.style.display === '') {
                answer.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
                element.parentElement.style.backgroundColor = '#f8f9ff';
            } else {
                answer.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
                element.parentElement.style.backgroundColor = 'white';
            }
        }

        // Contact Form Submission
        document.getElementById('contactForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading
            Swal.fire({
                title: 'Sending Message...',
                text: 'Please wait while we process your message',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/contact/submit', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: 'Message Sent Successfully!',
                        text: 'Thank you for contacting us. We\'ll get back to you within 2 hours.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        customClass: {
                            popup: 'rounded-3',
                            confirmButton: 'rounded-pill'
                        }
                    });
                    
                    // Reset form
                    this.reset();
                } else {
                    throw new Error(result.message || 'Failed to send message');
                }
            } catch (error) {
                console.error('Contact form error:', error);
                Swal.fire({
                    title: 'Message Failed to Send',
                    text: 'Sorry, there was an error sending your message. Please try again or call us directly.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    customClass: {
                        popup: 'rounded-3',
                        confirmButton: 'rounded-pill'
                    }
                });
            }
        });

        // Add form validation
        const form = document.getElementById('contactForm');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#10b981';
                }
            });

            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#e9ecef';
                }
            });
        });

        // Email validation
        const emailInput = form.querySelector('input[type="email"]');
        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.value)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#10b981';
            }
        });

        // Phone validation (optional field)
        const phoneInput = form.querySelector('input[type="tel"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                // Remove non-numeric characters except + and spaces
                this.value = this.value.replace(/[^\d+\s-]/g, '');
            });
        }
    </script>
</body>
</html>
