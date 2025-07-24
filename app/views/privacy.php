<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="navbar bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a href="/" class="navbar-brand">
                    <i class="fas fa-car-side text-2xl"></i>
                    Carpool India
                </a>
                
                <div class="navbar-nav hidden md:flex">
                    <a href="/" class="nav-link">Home</a>
                    <a href="/about" class="nav-link">About</a>
                    <a href="/esg" class="nav-link">ESG</a>
                    <a href="/contact" class="nav-link">Contact</a>
                </div>
                
                <div class="flex items-center space-x-3">
                    <?php if (Security::isLoggedIn()): ?>
                        <a href="/dashboard" class="btn btn-primary">Dashboard</a>
                        <a href="/logout" class="btn btn-secondary">Logout</a>
                    <?php else: ?>
                        <a href="/login" class="nav-link">Login</a>
                        <a href="/signup" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 mb-4">Privacy Policy</h1>
                <p class="text-lg text-gray-600">
                    Your privacy is important to us. Learn how we collect, use, and protect your information.
                </p>
                <p class="text-sm text-gray-500 mt-4">Last updated: <?= date('F j, Y') ?></p>
            </div>

            <!-- Privacy Content -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="prose max-w-none">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">1. Information We Collect</h2>
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Personal Information</h3>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Name, email address, and phone number</li>
                            <li>Profile picture (optional)</li>
                            <li>Corporate email verification details</li>
                            <li>Location data for ride matching</li>
                            <li>Vehicle information (model, registration, etc.)</li>
                        </ul>

                        <h3 class="text-lg font-semibold text-gray-800 mb-3 mt-6">Usage Data</h3>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>App usage patterns and preferences</li>
                            <li>Ride history and booking information</li>
                            <li>Device information and IP address</li>
                            <li>Location data during app usage</li>
                        </ul>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">2. How We Use Your Information</h2>
                    <div class="mb-8">
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li><strong>Service Delivery:</strong> To provide carpooling services and match you with suitable rides</li>
                            <li><strong>Communication:</strong> To send OTPs, ride confirmations, and important notifications</li>
                            <li><strong>Safety & Security:</strong> To verify user identity and ensure platform security</li>
                            <li><strong>Improvement:</strong> To analyze usage patterns and improve our services</li>
                            <li><strong>Legal Compliance:</strong> To comply with applicable laws and regulations</li>
                        </ul>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">3. Information Sharing</h2>
                    <div class="mb-8">
                        <p class="text-gray-600 mb-4">We share your information only in the following circumstances:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li><strong>With Other Users:</strong> Basic profile information (name, photo) for ride matching</li>
                            <li><strong>Service Providers:</strong> Third-party services that help us operate the platform</li>
                            <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                            <li><strong>Business Transfers:</strong> In case of merger, acquisition, or sale of assets</li>
                        </ul>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mt-6">
                            <div class="flex">
                                <i class="fas fa-shield-alt text-blue-500 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="font-semibold text-blue-800">We Never Share:</h4>
                                    <p class="text-blue-700 text-sm">Your password, payment details, or private messages without your explicit consent.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">4. Data Security</h2>
                    <div class="mb-8">
                        <p class="text-gray-600 mb-4">We implement industry-standard security measures to protect your data:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>End-to-end encryption for sensitive communications</li>
                            <li>Secure servers with regular security updates</li>
                            <li>OTP-based verification for enhanced security</li>
                            <li>Regular security audits and monitoring</li>
                            <li>Access controls and employee training</li>
                        </ul>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">5. Your Rights</h2>
                    <div class="mb-8">
                        <p class="text-gray-600 mb-4">You have the following rights regarding your personal data:</p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2">
                                    <i class="fas fa-eye text-blue-600 mr-2"></i>Access
                                </h4>
                                <p class="text-sm text-gray-600">Request a copy of your personal data</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2">
                                    <i class="fas fa-edit text-green-600 mr-2"></i>Correction
                                </h4>
                                <p class="text-sm text-gray-600">Update or correct your information</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2">
                                    <i class="fas fa-trash text-red-600 mr-2"></i>Deletion
                                </h4>
                                <p class="text-sm text-gray-600">Request deletion of your account</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-2">
                                    <i class="fas fa-download text-purple-600 mr-2"></i>Portability
                                </h4>
                                <p class="text-sm text-gray-600">Export your data in a readable format</p>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">6. Cookies and Tracking</h2>
                    <div class="mb-8">
                        <p class="text-gray-600 mb-4">We use cookies and similar technologies to:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Remember your login preferences</li>
                            <li>Analyze how you use our platform</li>
                            <li>Provide personalized experiences</li>
                            <li>Ensure security and prevent fraud</li>
                        </ul>
                        <p class="text-gray-600 mt-4">You can control cookie settings through your browser preferences.</p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">7. Data Retention</h2>
                    <div class="mb-8">
                        <p class="text-gray-600 mb-4">We retain your data for as long as necessary to:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Provide our services to you</li>
                            <li>Comply with legal obligations</li>
                            <li>Resolve disputes and enforce agreements</li>
                            <li>Improve our platform and services</li>
                        </ul>
                        <p class="text-gray-600 mt-4">
                            When you delete your account, we will remove your personal information within 30 days, 
                            except where required by law.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">8. Children's Privacy</h2>
                    <div class="mb-8">
                        <p class="text-gray-600">
                            Our service is not intended for users under 18 years of age. We do not knowingly collect 
                            personal information from children under 18. If we discover that we have collected such 
                            information, we will delete it immediately.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">9. International Transfers</h2>
                    <div class="mb-8">
                        <p class="text-gray-600">
                            Your data is primarily stored in India. If we need to transfer data internationally, 
                            we ensure appropriate safeguards are in place to protect your information in accordance 
                            with applicable data protection laws.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">10. Updates to This Policy</h2>
                    <div class="mb-8">
                        <p class="text-gray-600">
                            We may update this Privacy Policy from time to time. We will notify you of any material 
                            changes by posting the new policy on our website and sending you an email notification. 
                            Your continued use of our services after such modifications constitutes acceptance of the 
                            updated policy.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-4">11. Contact Us</h2>
                    <div class="mb-8">
                        <p class="text-gray-600 mb-4">
                            If you have any questions about this Privacy Policy or our data practices, please contact us:
                        </p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="space-y-2">
                                <p class="text-gray-700"><strong>Email:</strong> privacy@carpoolindia.com</p>
                                <p class="text-gray-700"><strong>Phone:</strong> +91-9876543210</p>
                                <p class="text-gray-700"><strong>Address:</strong> Elite Corporate Solutions, Sector 62, Noida, UP 201309</p>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Badges -->
                    <div class="border-t pt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Compliance & Certifications</h3>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-lg">
                                <i class="fas fa-shield-alt text-green-600"></i>
                                <span class="text-sm font-medium text-green-800">GDPR Compliant</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-blue-50 px-4 py-2 rounded-lg">
                                <i class="fas fa-lock text-blue-600"></i>
                                <span class="text-sm font-medium text-blue-800">SSL Encrypted</span>
                            </div>
                            <div class="flex items-center space-x-2 bg-purple-50 px-4 py-2 rounded-lg">
                                <i class="fas fa-certificate text-purple-600"></i>
                                <span class="text-sm font-medium text-purple-800">ISO 27001</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container mx-auto px-4">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-car-side text-blue-400 text-2xl mr-3"></i>
                        <h3 class="text-white text-xl font-bold">Carpool India</h3>
                    </div>
                    <p class="text-gray-300">Your privacy is our priority.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Legal</h4>
                    <a href="/privacy">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Data Protection</a>
                </div>
                
                <div class="footer-section">
                    <h4>Support</h4>
                    <a href="/contact">Contact Us</a>
                    <a href="#">Help Center</a>
                    <a href="#">Report Issue</a>
                </div>
                
                <div class="footer-section">
                    <h4>Company</h4>
                    <a href="/about">About Us</a>
                    <a href="/esg">ESG Impact</a>
                    <a href="#">Careers</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Carpool India by Elite Corporate Solutions. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="public/js/app.js"></script>
</body>
</html>
