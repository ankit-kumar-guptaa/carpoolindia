<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="csrf-token" content="<?= $csrf_token ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-900 via-purple-800 to-indigo-900 min-h-screen">
    <!-- Navigation -->
    <nav class="navbar bg-transparent">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a href="/" class="navbar-brand text-white">
                    <i class="fas fa-car-side text-2xl"></i>
                    Carpool India
                </a>
                <a href="/" class="text-white hover:text-blue-300">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Home
                </a>
            </div>
        </div>
    </nav>

    <!-- Signup Form -->
    <div class="min-h-screen flex items-center justify-center py-20">
        <div class="max-w-md w-full mx-4">
            <!-- Step 1: Email & OTP -->
            <div id="step1" class="glass p-8 rounded-2xl">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-2xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Join Carpool India!</h1>
                    <p class="text-gray-300">Start your smart commuting journey today</p>
                </div>

                <form id="step1Form" data-ajax="true" action="/signup-step1" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="form-group">
                        <label class="form-label text-white">Email Address</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" 
                                   name="email" 
                                   id="signupEmail"
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your corporate email"
                                   required>
                        </div>
                        <p class="text-sm text-gray-400 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            We'll send a verification code to this email
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary w-full mb-4">
                        <i class="fas fa-paper-plane mr-2"></i>Send Verification Code
                    </button>

                    <div class="text-center">
                        <span class="text-gray-300">Already have an account? </span>
                        <a href="/login" class="text-blue-300 hover:text-blue-200 font-semibold">
                            Sign in here
                        </a>
                    </div>
                </form>
            </div>

            <!-- Step 2: OTP Verification & Details -->
            <div id="step2" class="glass p-8 rounded-2xl hidden">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-key text-2xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Verify Your Email</h1>
                    <p class="text-gray-300">Enter the verification code sent to your email</p>
                </div>

                <form id="step2Form" data-ajax="true" action="/signup-step2" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input type="hidden" name="email" id="hiddenEmail">
                    
                    <div class="form-group">
                        <label class="form-label text-white">Verification Code</label>
                        <div class="relative">
                            <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" 
                                   name="otp" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300 text-center text-2xl tracking-widest" 
                                   placeholder="000000"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-white">Full Name</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" 
                                   name="name" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your full name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-white">Phone Number (Optional)</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="tel" 
                                   name="phone" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your mobile number"
                                   pattern="[6-9][0-9]{9}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-white">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" 
                                   name="password" 
                                   id="signupPassword"
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Create a strong password"
                                   minlength="8"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword(this)" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-white">Confirm Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" 
                                   name="confirm_password" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Confirm your password"
                                   minlength="8"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword(this)" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="flex items-center text-white">
                            <input type="checkbox" required class="mr-3">
                            <span class="text-sm">
                                I agree to the <a href="/privacy" class="text-blue-300 hover:text-blue-200">Terms & Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-full mb-4">
                        <i class="fas fa-check mr-2"></i>Create Account
                    </button>

                    <button type="button" onclick="goBackToStep1()" class="btn btn-secondary w-full">
                        <i class="fas fa-arrow-left mr-2"></i>Change Email
                    </button>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-400">
                        Didn't receive the code? 
                        <button onclick="resendOTP()" class="text-blue-300 hover:text-blue-200">
                            Resend OTP
                        </button>
                    </p>
                </div>
            </div>

            <!-- Features -->
            <div class="glass p-6 rounded-2xl mt-6">
                <h3 class="text-white text-center mb-4">Why Join Carpool India?</h3>
                <div class="space-y-3">
                    <div class="flex items-center text-white">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <span class="text-sm">Save up to 70% on travel costs</span>
                    </div>
                    <div class="flex items-center text-white">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <span class="text-sm">Verified corporate users only</span>
                    </div>
                    <div class="flex items-center text-white">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <span class="text-sm">Secure OTP-based verification</span>
                    </div>
                    <div class="flex items-center text-white">
                        <i class="fas fa-check-circle text-green-400 mr-3"></i>
                        <span class="text-sm">Real-time ride tracking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="public/js/app.js"></script>
    <script>
        let currentStep = 1;

        // Handle step 1 form success
        document.getElementById('step1Form').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const email = formData.get('email');
            
            try {
                const response = await fetch('/signup-step1', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Move to step 2
                    document.getElementById('step1').classList.add('hidden');
                    document.getElementById('step2').classList.remove('hidden');
                    document.getElementById('hiddenEmail').value = email;
                    
                    app.showNotification(result.message, 'success');
                } else {
                    app.showNotification(result.message, 'error');
                }
            } catch (error) {
                app.showNotification('Network error. Please try again.', 'error');
            }
        });

        // Toggle password visibility
        function togglePassword(button) {
            const input = button.parentElement.querySelector('input');
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        // Go back to step 1
        function goBackToStep1() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
        }

        // Resend OTP
        async function resendOTP() {
            const email = document.getElementById('hiddenEmail').value;
            
            try {
                const formData = new FormData();
                formData.append('email', email);
                formData.append('csrf_token', '<?= $csrf_token ?>');
                
                const response = await fetch('/signup-step1', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    app.showNotification('OTP resent successfully!', 'success');
                } else {
                    app.showNotification(result.message, 'error');
                }
            } catch (error) {
                app.showNotification('Failed to resend OTP.', 'error');
            }
        }

        // Auto-focus on OTP input
        document.querySelector('input[name="otp"]').addEventListener('input', function(e) {
            // Only allow numbers
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            
            // Auto-submit when 6 digits are entered
            if (e.target.value.length === 6) {
                document.getElementById('step2Form').querySelector('button[type="submit"]').focus();
            }
        });

        // Password strength indicator
        document.getElementById('signupPassword').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = calculatePasswordStrength(password);
            
            // Update UI based on strength
            const strengthIndicator = document.getElementById('strengthIndicator');
            if (strengthIndicator) {
                strengthIndicator.className = `strength-${strength}`;
            }
        });

        function calculatePasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength < 2) return 'weak';
            if (strength < 4) return 'medium';
            return 'strong';
        }
    </script>
</body>
</html>
