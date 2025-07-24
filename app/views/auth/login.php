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

    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center py-20">
        <div class="max-w-md w-full mx-4">
            <div class="glass p-8 rounded-2xl">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-2xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Welcome Back!</h1>
                    <p class="text-gray-300">Sign in to your Carpool India account</p>
                </div>

                <form id="loginForm" data-ajax="true" action="/login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="form-group">
                        <label class="form-label text-white">Email Address</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" 
                                   name="email" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your email"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label text-white">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="password" 
                                   name="password" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your password"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword(this)" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center text-white">
                            <input type="checkbox" name="remember_me" class="mr-2">
                            <span class="text-sm">Remember me</span>
                        </label>
                        <button type="button" 
                                onclick="showForgotPassword()" 
                                class="text-blue-300 hover:text-blue-200 text-sm">
                            Forgot Password?
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary w-full mb-4">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>

                    <div class="text-center">
                        <span class="text-gray-300">Don't have an account? </span>
                        <a href="/signup" class="text-blue-300 hover:text-blue-200 font-semibold">
                            Sign up here
                        </a>
                    </div>
                </form>
            </div>

            <!-- Alternative Login Options -->
            <div class="glass p-6 rounded-2xl mt-6">
                <h3 class="text-white text-center mb-4">Quick Login with OTP</h3>
                <button onclick="showOtpLogin()" class="btn btn-secondary w-full">
                    <i class="fas fa-mobile-alt mr-2"></i>Login with OTP
                </button>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="glass p-8 rounded-2xl max-w-md w-full">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Reset Password</h2>
                    <p class="text-gray-300">Enter your email to receive reset instructions</p>
                </div>
                
                <form id="forgotPasswordForm" data-ajax="true" action="/forgot-password" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="form-group">
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" 
                                   name="email" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your email"
                                   required>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1">
                            Send Reset Link
                        </button>
                        <button type="button" onclick="hideForgotPassword()" class="btn btn-secondary">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- OTP Login Modal -->
    <div id="otpLoginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div class="glass p-8 rounded-2xl max-w-md w-full">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Login with OTP</h2>
                    <p class="text-gray-300">Enter your email to receive login OTP</p>
                </div>
                
                <form id="otpLoginForm" data-ajax="true">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    
                    <div class="form-group">
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" 
                                   name="email" 
                                   class="form-control pl-10 bg-white/20 border-white/30 text-white placeholder-gray-300" 
                                   placeholder="Enter your email"
                                   required>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary flex-1">
                            Send OTP
                        </button>
                        <button type="button" onclick="hideOtpLogin()" class="btn btn-secondary">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="public/js/app.js"></script>
    <script>
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

        // Show forgot password modal
        function showForgotPassword() {
            document.getElementById('forgotPasswordModal').classList.remove('hidden');
        }

        // Hide forgot password modal
        function hideForgotPassword() {
            document.getElementById('forgotPasswordModal').classList.add('hidden');
        }

        // Show OTP login modal
        function showOtpLogin() {
            document.getElementById('otpLoginModal').classList.remove('hidden');
        }

        // Hide OTP login modal
        function hideOtpLogin() {
            document.getElementById('otpLoginModal').classList.add('hidden');
        }

        // Handle modal close on outside click
        document.querySelectorAll('.fixed.inset-0').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
