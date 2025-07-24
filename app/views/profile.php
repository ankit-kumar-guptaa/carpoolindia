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
<body class="bg-gray-50" data-logged-in="true">
    <!-- Navigation -->
    <nav class="navbar bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <a href="/" class="navbar-brand">
                    <i class="fas fa-car-side text-2xl"></i>
                    Carpool India
                </a>
                
                <div class="navbar-nav hidden md:flex">
                    <a href="/dashboard" class="nav-link">Dashboard</a>
                    <a href="/profile" class="nav-link text-blue-600 font-semibold">Profile</a>
                    <a href="/about" class="nav-link">About</a>
                    <a href="/contact" class="nav-link">Contact</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/dashboard" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <a href="/logout" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Profile Settings</h1>
                <p class="text-gray-600">Manage your account and vehicle information</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Profile Picture & Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                        <div class="relative inline-block mb-4">
                            <?php if ($user['profile_picture']): ?>
                                <img src="public/uploads/profiles/<?= htmlspecialchars($user['profile_picture']) ?>" 
                                     alt="Profile" 
                                     class="w-24 h-24 rounded-full mx-auto object-cover">
                            <?php else: ?>
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto text-white text-3xl font-bold">
                                    <?= strtoupper(substr($user['name'], 0, 2)) ?>
                                </div>
                            <?php endif; ?>
                            
                            <button onclick="document.getElementById('avatarInput').click()" 
                                    class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-blue-700 transition">
                                <i class="fas fa-camera text-sm"></i>
                            </button>
                        </div>
                        
                        <form id="avatarForm" enctype="multipart/form-data" style="display: none;">
                            <input type="file" 
                                   id="avatarInput" 
                                   name="avatar" 
                                   accept="image/*"
                                   onchange="uploadAvatar()">
                        </form>
                        
                        <h3 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($user['name']) ?></h3>
                        <p class="text-gray-600"><?= htmlspecialchars($user['email']) ?></p>
                        <p class="text-sm text-gray-500">Member since <?= date('M Y', strtotime($user['created_at'])) ?></p>
                    </div>
                </div>

                <!-- Profile Forms -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">
                            <i class="fas fa-user text-blue-600 mr-2"></i>Personal Information
                        </h2>
                        
                        <form id="profileForm" data-ajax="true" action="/profile/update" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                    <input type="text" 
                                           name="name" 
                                           value="<?= htmlspecialchars($user['name']) ?>"
                                           class="form-control" 
                                           required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" 
                                           name="phone" 
                                           value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
                                           class="form-control" 
                                           placeholder="Enter 10-digit mobile number"
                                           pattern="[6-9][0-9]{9}">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>"
                                       class="form-control bg-gray-100" 
                                       disabled>
                                <p class="text-sm text-gray-500 mt-1">Email cannot be changed for security reasons</p>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-2"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">
                            <i class="fas fa-car text-green-600 mr-2"></i>Vehicle Information
                        </h2>
                        
                        <form id="vehicleForm" data-ajax="true" action="/profile/update-vehicle" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Model</label>
                                    <input type="text" 
                                           name="model" 
                                           value="<?= htmlspecialchars($vehicle['model'] ?? '') ?>"
                                           class="form-control" 
                                           placeholder="e.g., Maruti Swift, Honda City"
                                           required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number Plate</label>
                                    <input type="text" 
                                           name="number_plate" 
                                           value="<?= htmlspecialchars($vehicle['number_plate'] ?? '') ?>"
                                           class="form-control" 
                                           placeholder="e.g., MH 01 AB 1234"
                                           style="text-transform: uppercase"
                                           required>
                                </div>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                                    <input type="text" 
                                           name="color" 
                                           value="<?= htmlspecialchars($vehicle['color'] ?? '') ?>"
                                           class="form-control" 
                                           placeholder="e.g., White, Black, Silver">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Seats</label>
                                    <select name="seats" class="form-control" required>
                                        <option value="">Select seats</option>
                                        <?php for ($i = 2; $i <= 8; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($vehicle['seats'] ?? 4) == $i ? 'selected' : '' ?>>
                                                <?= $i ?> Seats
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-2"></i>Update Vehicle
                                </button>
                                <?php if ($vehicle): ?>
                                    <button type="button" onclick="deleteVehicle()" class="btn btn-danger ml-3">
                                        <i class="fas fa-trash mr-2"></i>Remove Vehicle
                                    </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <!-- Security -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">
                            <i class="fas fa-shield-alt text-purple-600 mr-2"></i>Security
                        </h2>
                        
                        <form id="passwordForm" data-ajax="true" action="/profile/change-password" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            
                            <div class="grid md:grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="current_password" 
                                               class="form-control pr-10" 
                                               required>
                                        <button type="button" 
                                                onclick="togglePassword(this)" 
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="new_password" 
                                               class="form-control pr-10" 
                                               minlength="8"
                                               required>
                                        <button type="button" 
                                                onclick="togglePassword(this)" 
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="confirm_password" 
                                               class="form-control pr-10" 
                                               minlength="8"
                                               required>
                                        <button type="button" 
                                                onclick="togglePassword(this)" 
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key mr-2"></i>Change Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Account Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6">
                            <i class="fas fa-cogs text-red-600 mr-2"></i>Account Actions
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h4 class="font-semibold text-gray-800">Download My Data</h4>
                                    <p class="text-sm text-gray-600">Get a copy of all your account data</p>
                                </div>
                                <button class="btn btn-secondary btn-sm">
                                    <i class="fas fa-download mr-2"></i>Download
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                                <div>
                                    <h4 class="font-semibold text-red-800">Delete Account</h4>
                                    <p class="text-sm text-red-600">Permanently delete your account and all data</p>
                                </div>
                                <button onclick="confirmDeleteAccount()" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash mr-2"></i>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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

        // Upload avatar
        async function uploadAvatar() {
            const fileInput = document.getElementById('avatarInput');
            const file = fileInput.files[0];
            
            if (!file) return;
            
            // Validate file
            if (!file.type.startsWith('image/')) {
                app.showNotification('Please select a valid image file', 'error');
                return;
            }
            
            if (file.size > 2 * 1024 * 1024) { // 2MB
                app.showNotification('Image size must be less than 2MB', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('avatar', file);
            formData.append('csrf_token', '<?= $csrf_token ?>');
            
            try {
                const response = await fetch('/profile/upload-avatar', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    app.showNotification('Profile picture updated successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    app.showNotification(result.message || 'Upload failed', 'error');
                }
            } catch (error) {
                console.error('Upload error:', error);
                app.showNotification('Upload failed. Please try again.', 'error');
            }
        }

        // Delete vehicle
        function deleteVehicle() {
            if (confirm('Are you sure you want to remove your vehicle details? You won\'t be able to create rides without vehicle information.')) {
                // Implementation would go here
                app.showNotification('Vehicle removal feature will be implemented', 'info');
            }
        }

        // Confirm delete account
        function confirmDeleteAccount() {
            if (confirm('Are you absolutely sure you want to delete your account? This action cannot be undone and all your data will be permanently lost.')) {
                if (confirm('This is your final warning. Type DELETE to confirm account deletion.')) {
                    const confirmation = prompt('Type DELETE to confirm:');
                    if (confirmation === 'DELETE') {
                        app.showNotification('Account deletion feature will be implemented', 'info');
                    }
                }
            }
        }

        // Auto-uppercase number plate
        document.querySelector('input[name="number_plate"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Phone number validation
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            if (e.target.value.length > 10) {
                e.target.value = e.target.value.slice(0, 10);
            }
        });
    </script>
</body>
</html>
