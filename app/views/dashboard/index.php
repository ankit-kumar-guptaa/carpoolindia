<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="csrf-token" content="<?= $csrf_token ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --purple-gradient: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-card {
            background: var(--primary-gradient);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-card.success {
            background: var(--success-gradient);
        }

        .stats-card.warning {
            background: var(--warning-gradient);
        }

        .stats-card.info {
            background: var(--info-gradient);
        }

        .stats-card.purple {
            background: var(--purple-gradient);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .search-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 12px 15px 12px 45px;
            font-size: 0.95rem;
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
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 5;
        }

        .btn-search {
            background: var(--primary-gradient);
            border: none;
            border-radius: 15px;
            padding: 12px 25px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-action {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
        }

        .btn-success {
            background: var(--success-gradient);
        }

        .btn-warning {
            background: var(--warning-gradient);
        }

        .btn-info {
            background: var(--info-gradient);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .ride-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 10px 0;
            border-left: 5px solid;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .ride-card.created {
            border-left-color: #667eea;
        }

        .ride-card.booked {
            border-left-color: #11998e;
        }

        .ride-card.search-result {
            border-left-color: #f093fb;
        }

        .ride-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .route-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }

        .route-point {
            display: flex;
            align-items: center;
            margin: 8px 0;
        }

        .route-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .route-dot.from { background: #28a745; }
        .route-dot.to { background: #dc3545; }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active { background: #e3f2fd; color: #1976d2; }
        .status-completed { background: #e8f5e8; color: #2e7d32; }
        .status-cancelled { background: #ffebee; color: #c62828; }

        .sidebar-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .quick-action {
            display: block;
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            color: white;
        }

        .quick-action.search { background: var(--info-gradient); }
        .quick-action.create { background: var(--success-gradient); }
        .quick-action.rides { background: var(--purple-gradient); }
        .quick-action.connections { background: var(--warning-gradient); }

        .quick-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .autocomplete-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e9ecef;
            border-top: none;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        }

        .autocomplete-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f8f9fa;
            transition: background 0.2s ease;
        }

        .autocomplete-item:hover {
            background: #f8f9fa;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .vehicle-info {
            background: linear-gradient(135deg, #e8f5e8 0%, #f0f8f0 100%);
            border: 1px solid #c8e6c9;
            border-radius: 15px;
            padding: 15px;
        }

        .vehicle-warning {
            background: linear-gradient(135deg, #fff3e0 0%, #fff8f0 100%);
            border: 1px solid #ffcc02;
            border-radius: 15px;
            padding: 15px;
        }

        .section-header {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        @media (max-width: 768px) {
            .card {
                margin: 10px 0;
                border-radius: 15px;
            }
            
            .search-card {
                padding: 1.5rem;
            }
            
            .sidebar-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-car-side me-2"></i>Carpool India
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-primary" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/connections">Connections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/my-rides">My Rides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <div class="avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                <?= strtoupper(substr($user['name'], 0, 2)) ?>
                            </div>
                            <span class="d-none d-md-inline fw-semibold"><?= htmlspecialchars($user['name']) ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="/dashboard/my-rides"><i class="fas fa-car me-2"></i>My Rides</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid" style="margin-top: 100px;">
        <div class="container">
            <!-- Welcome Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="section-header text-center">
                        <h1 class="section-title">
                            Welcome back, <?= explode(' ', $user['name'])[0] ?>! 🚗
                        </h1>
                        <p class="text-muted mb-0">Ready to share your journey or find your perfect ride?</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Profile Card -->
                    <div class="sidebar-card">
                        <div class="text-center mb-4">
                            <div class="avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 1.8rem;">
                                <?= strtoupper(substr($user['name'], 0, 2)) ?>
                            </div>
                            <h5 class="fw-bold mb-1"><?= htmlspecialchars($user['name']) ?></h5>
                            <p class="text-muted small"><?= htmlspecialchars($user['email']) ?></p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></div>
                                <small class="text-success fw-semibold">Online</small>
                            </div>
                        </div>
                        
                        <!-- Vehicle Status -->
                        <?php if (!$vehicle): ?>
                            <div class="vehicle-warning mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <span class="fw-semibold text-warning">Vehicle Required</span>
                                </div>
                                <p class="small text-muted mb-2">Add your vehicle to start offering rides</p>
                                <a href="/profile" class="btn btn-warning btn-sm">
                                    <i class="fas fa-plus me-1"></i>Add Vehicle
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="vehicle-info mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-car text-success me-2"></i>
                                    <span class="fw-semibold text-success"><?= htmlspecialchars($vehicle['model']) ?></span>
                                </div>
                                <p class="small mb-1 fw-semibold"><?= htmlspecialchars($vehicle['number_plate']) ?></p>
                                <p class="small text-muted mb-0"><?= $vehicle['seats'] ?> Seats • <?= htmlspecialchars($vehicle['color']) ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Quick Actions -->
                        <div class="d-grid gap-2">
                            <a href="#search" class="quick-action search">
                                <i class="fas fa-search me-2"></i>Search Rides
                            </a>
                            <a href="#create" class="quick-action create">
                                <i class="fas fa-plus me-2"></i>Offer Ride
                            </a>
                            <a href="/dashboard/my-rides" class="quick-action rides">
                                <i class="fas fa-history me-2"></i>My Rides
                            </a>
                            <div class="position-relative">
                                <a href="/dashboard/connections" class="quick-action connections">
                                    <i class="fas fa-users me-2"></i>Connections
                                </a>
                                <?php if (isset($connection_stats) && $connection_stats['pending_incoming'] > 0): ?>
                                    <span class="notification-badge"><?= $connection_stats['pending_incoming'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Impact Stats -->
                    <div class="sidebar-card">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-chart-line text-primary me-2"></i>Your Impact
                        </h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h4 fw-bold text-primary mb-1"><?= count($my_rides['created'] ?? []) ?></div>
                                    <div class="small text-muted">Created</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h4 fw-bold text-success mb-1"><?= count($my_rides['booked'] ?? []) ?></div>
                                    <div class="small text-muted">Booked</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-center p-3 bg-light rounded">
                                    <div class="h5 fw-bold text-info mb-1"><?= number_format((count($my_rides['booked'] ?? []) * 5.2), 1) ?>kg</div>
                                    <div class="small text-muted">CO₂ Saved</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card stats-card text-center">
                                <div class="card-body position-relative">
                                    <i class="fas fa-car fa-2x mb-3"></i>
                                    <h3 class="fw-bold"><?= count($my_rides['created'] ?? []) ?></h3>
                                    <p class="mb-0 opacity-75">Rides Created</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card stats-card success text-center">
                                <div class="card-body position-relative">
                                    <i class="fas fa-ticket-alt fa-2x mb-3"></i>
                                    <h3 class="fw-bold"><?= count($my_rides['booked'] ?? []) ?></h3>
                                    <p class="mb-0 opacity-75">Rides Booked</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card stats-card warning text-center">
                                <div class="card-body position-relative">
                                    <i class="fas fa-users fa-2x mb-3"></i>
                                    <h3 class="fw-bold"><?= isset($connection_stats) ? $connection_stats['total_connections'] : 0 ?></h3>
                                    <p class="mb-0 opacity-75">Connections</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card stats-card info text-center">
                                <div class="card-body position-relative">
                                    <i class="fas fa-leaf fa-2x mb-3"></i>
                                    <h3 class="fw-bold"><?= number_format((count($my_rides['booked'] ?? []) * 5.2), 1) ?></h3>
                                    <p class="mb-0 opacity-75">kg CO₂ Saved</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Section -->
                    <section id="search" class="mb-4">
                        <div class="search-card">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-search text-white"></i>
                                </div>
                                <div>
                                    <h4 class="section-title mb-1">Find Your Perfect Ride</h4>
                                    <p class="text-muted mb-0">Search from thousands of available rides</p>
                                </div>
                            </div>
                            
                            <form id="searchForm" class="row g-3">
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="fas fa-circle text-success search-icon"></i>
                                        <input type="text" id="searchSource" name="source" 
                                               class="search-input form-control" placeholder="From location"
                                               data-autocomplete="location" data-results="searchSourceResults" required>
                                        <div id="searchSourceResults" class="autocomplete-dropdown d-none"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="fas fa-circle text-danger search-icon"></i>
                                        <input type="text" id="searchDestination" name="destination" 
                                               class="search-input form-control" placeholder="To location"
                                               data-autocomplete="location" data-results="searchDestinationResults" required>
                                        <div id="searchDestinationResults" class="autocomplete-dropdown d-none"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="position-relative">
                                        <i class="fas fa-calendar search-icon"></i>
                                        <input type="date" name="date" class="search-input form-control" 
                                               min="<?= date('Y-m-d') ?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <button type="submit" class="btn-search w-100">
                                        <i class="fas fa-search me-1"></i>Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <!-- Search Results -->
                    <?php if (!empty($search_results)): ?>
                        <section class="mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <h5 class="section-title mb-0">
                                            <i class="fas fa-map-marked-alt text-success me-2"></i>
                                            Search Results (<?= count($search_results) ?> found)
                                        </h5>
                                    </div>
                                    
                                    <div class="row">
                                        <?php foreach ($search_results as $ride): ?>
                                            <div class="col-12 mb-3">
                                                <div class="ride-card search-result">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-8">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="avatar me-3">
                                                                    <?= strtoupper(substr($ride['driver_name'], 0, 2)) ?>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($ride['driver_name']) ?></h6>
                                                                    <small class="text-muted"><?= htmlspecialchars($ride['vehicle_model'] ?? 'Vehicle') ?> • <?= htmlspecialchars($ride['number_plate'] ?? '') ?></small>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="route-info">
                                                                <div class="route-point">
                                                                    <div class="route-dot from"></div>
                                                                    <span class="fw-semibold"><?= htmlspecialchars($ride['source']) ?></span>
                                                                </div>
                                                                <div class="route-point">
                                                                    <div class="route-dot to"></div>
                                                                    <span class="fw-semibold"><?= htmlspecialchars($ride['destination']) ?></span>
                                                                </div>
                                                                <div class="route-point">
                                                                    <i class="fas fa-clock text-primary me-2"></i>
                                                                    <span><?= date('d M Y, h:i A', strtotime($ride['ride_date'] . ' ' . $ride['ride_time'])) ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 text-end">
                                                            <div class="h3 fw-bold text-success mb-1">₹<?= $ride['price_per_seat'] ?></div>
                                                            <div class="text-muted small mb-3"><?= $ride['seats_available'] ?> seats available</div>
                                                            <button onclick="bookRide(<?= $ride['id'] ?>, '<?= htmlspecialchars($ride['driver_name']) ?>')" 
                                                                    class="btn btn-action btn-success">
                                                                <i class="fas fa-ticket-alt me-2"></i>Book Now
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                    <!-- Create Ride Section -->
                    <section id="create" class="mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-success rounded-circle p-3 me-3">
                                        <i class="fas fa-plus text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="section-title mb-1">Offer a Ride</h4>
                                        <p class="text-muted mb-0">Share your journey and earn money</p>
                                    </div>
                                </div>
                                
                                <?php if (!$vehicle): ?>
                                    <div class="vehicle-warning">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-info-circle text-warning me-3 fs-4"></i>
                                            <div>
                                                <h6 class="fw-bold text-warning mb-1">Vehicle Details Required</h6>
                                                <p class="small text-muted mb-0">Add your vehicle information to start offering rides</p>
                                            </div>
                                        </div>
                                        <a href="/profile" class="btn btn-warning">
                                            <i class="fas fa-plus me-2"></i>Add Vehicle Details
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <form id="createRideForm" class="row g-3">
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i class="fas fa-circle text-success search-icon"></i>
                                                <input type="text" name="source" id="createSource"
                                                       class="search-input form-control" placeholder="From location"
                                                       data-autocomplete="location" data-results="createSourceResults" required>
                                                <div id="createSourceResults" class="autocomplete-dropdown d-none"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="position-relative">
                                                <i class="fas fa-circle text-danger search-icon"></i>
                                                <input type="text" name="destination" id="createDestination"
                                                       class="search-input form-control" placeholder="To location"
                                                       data-autocomplete="location" data-results="createDestinationResults" required>
                                                <div id="createDestinationResults" class="autocomplete-dropdown d-none"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                <i class="fas fa-calendar search-icon"></i>
                                                <input type="date" name="ride_date" class="search-input form-control" 
                                                       min="<?= date('Y-m-d') ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                <i class="fas fa-clock search-icon"></i>
                                                <input type="time" name="ride_time" class="search-input form-control" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <select name="seats_available" class="search-input form-control" required>
                                                <option value="">Seats</option>
                                                <option value="1">1 Seat</option>
                                                <option value="2">2 Seats</option>
                                                <option value="3">3 Seats</option>
                                                <option value="4">4 Seats</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="position-relative">
                                                <i class="fas fa-rupee-sign search-icon"></i>
                                                <input type="number" name="price_per_seat" class="search-input form-control" 
                                                       placeholder="Price per seat" min="1" max="1000" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <textarea name="description" class="search-input form-control" rows="3" 
                                                      placeholder="Additional notes or preferences (optional)"></textarea>
                                        </div>
                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn-search">
                                                <i class="fas fa-plus me-2"></i>Create Ride & Start Earning
                                            </button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>

                    <!-- Recent Activity -->
                    <section>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h5 class="section-title mb-0">
                                        <i class="fas fa-history text-purple me-2"></i>Recent Activity
                                    </h5>
                                    <a href="/dashboard/my-rides" class="btn btn-outline-primary btn-sm">
                                        View All <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                                
                                <?php
                                $recentRides = array_merge(
                                    array_slice($my_rides['created'] ?? [], 0, 3),
                                    array_slice($my_rides['booked'] ?? [], 0, 3)
                                );
                                if (!empty($recentRides)) {
                                    usort($recentRides, function($a, $b) {
                                        return strtotime($b['ride_date']) - strtotime($a['ride_date']);
                                    });
                                    $recentRides = array_slice($recentRides, 0, 5);
                                }
                                ?>
                                
                                <?php if (empty($recentRides)): ?>
                                    <div class="empty-state">
                                        <i class="fas fa-route"></i>
                                        <h6 class="fw-bold mb-2">No rides yet</h6>
                                        <p class="small mb-4">Start your carpooling journey by searching for rides or creating your own!</p>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="#search" class="btn btn-primary btn-sm">Find Rides</a>
                                            <a href="#create" class="btn btn-success btn-sm">Offer Ride</a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?php foreach ($recentRides as $ride): ?>
                                            <div class="col-12 mb-3">
                                                <div class="ride-card <?= isset($ride['driver_name']) ? 'booked' : 'created' ?>">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar me-3">
                                                                <?= isset($ride['driver_name']) ? strtoupper(substr($ride['driver_name'], 0, 2)) : strtoupper(substr($user['name'], 0, 2)) ?>
                                                            </div>
                                                            <div>
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <h6 class="fw-bold mb-0 me-2">
                                                                        <?= htmlspecialchars($ride['source']) ?> → <?= htmlspecialchars($ride['destination']) ?>
                                                                    </h6>
                                                                    <span class="status-badge <?= isset($ride['driver_name']) ? 'status-active' : 'status-completed' ?>">
                                                                        <?= isset($ride['driver_name']) ? 'Booked' : 'Created' ?>
                                                                    </span>
                                                                </div>
                                                                <div class="small text-muted">
                                                                    <i class="fas fa-clock me-1"></i>
                                                                    <?= date('d M Y, h:i A', strtotime($ride['ride_date'] . ' ' . $ride['ride_time'])) ?>
                                                                    <?php if (isset($ride['driver_name'])): ?>
                                                                        • Driver: <?= htmlspecialchars($ride['driver_name']) ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-end">
                                                            <div class="h6 fw-bold text-success mb-0">₹<?= $ride['price_per_seat'] ?></div>
                                                            <?php if (!isset($ride['driver_name']) && isset($ride['total_bookings'])): ?>
                                                                <div class="small text-muted"><?= $ride['total_bookings'] ?> bookings</div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Smooth scrolling for anchor links
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

        // Search form submission
        document.getElementById('searchForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const source = document.getElementById('searchSource').value;
            const destination = document.getElementById('searchDestination').value;
            const date = document.querySelector('input[name="date"]').value;
            
            if (!source || !destination || !date) {
                Swal.fire('Error', 'Please fill all search fields', 'error');
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('source', source);
                formData.append('destination', destination);
                formData.append('date', date);
                formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);

                Swal.fire({
                    title: 'Searching...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch('/dashboard/search', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    Swal.close();
                    if (result.rides && result.rides.length > 0) {
                        window.location.href = '/dashboard?search=true';
                    } else {
                        Swal.fire('No Rides Found', 'No rides available for your search criteria.', 'info');
                    }
                } else {
                    Swal.fire('Error', result.message || 'Search failed', 'error');
                }
            } catch (error) {
                console.error('Search error:', error);
                Swal.fire('Error', 'Search failed. Please try again.', 'error');
            }
        });

        // Create ride form submission
        document.getElementById('createRideForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);
            
            try {
                Swal.fire({
                    title: 'Creating Ride...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch('/dashboard/create-ride', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Ride created successfully!',
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', result.message || 'Failed to create ride', 'error');
                }
            } catch (error) {
                console.error('Create ride error:', error);
                Swal.fire('Error', 'Failed to create ride. Please try again.', 'error');
            }
        });

        // Book ride function
        async function bookRide(rideId, driverName) {
            const { value: message } = await Swal.fire({
                title: `Book ride with ${driverName}?`,
                text: 'Send a booking request with an optional message',
                input: 'textarea',
                inputPlaceholder: 'Optional message for the driver...',
                showCancelButton: true,
                confirmButtonText: 'Send Request',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444'
            });

            if (message !== undefined) {
                try {
                    const formData = new FormData();
                    formData.append('ride_id', rideId);
                    formData.append('seats_requested', 1);
                    formData.append('message', message || '');
                    formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);

                    Swal.fire({
                        title: 'Sending Request...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const response = await fetch('/dashboard/send-booking-request', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        Swal.fire({
                            title: 'Request Sent!',
                            text: 'Your booking request has been sent to the driver.',
                            icon: 'success',
                            confirmButtonColor: '#10b981'
                        });
                    } else {
                        Swal.fire('Error', result.message || 'Booking request failed', 'error');
                    }
                } catch (error) {
                    console.error('Booking error:', error);
                    Swal.fire('Error', 'Failed to send booking request.', 'error');
                }
            }
        }

        // Autocomplete functionality
        document.querySelectorAll('[data-autocomplete="location"]').forEach(input => {
            let timeout;
            
            input.addEventListener('input', function() {
                const query = this.value.trim();
                const resultsDiv = document.getElementById(this.dataset.results);
                
                clearTimeout(timeout);
                
                if (query.length < 3) {
                    resultsDiv.classList.add('d-none');
                    return;
                }
                
                timeout = setTimeout(async () => {
                    try {
                        const response = await fetch(`/api/geocode?q=${encodeURIComponent(query)}`);
                        const results = await response.json();
                        
                        if (results.length > 0) {
                            resultsDiv.innerHTML = results.map(result => 
                                `<div class="autocomplete-item" onclick="selectLocation('${this.id}', '${result.display_name.replace(/'/g, "\\'")}', '${this.dataset.results}')">
                                    ${result.display_name}
                                </div>`
                            ).join('');
                            resultsDiv.classList.remove('d-none');
                        } else {
                            resultsDiv.classList.add('d-none');
                        }
                    } catch (error) {
                        console.error('Autocomplete error:', error);
                        resultsDiv.classList.add('d-none');
                    }
                }, 300);
            });
        });

        function selectLocation(inputId, location, resultsId) {
            document.getElementById(inputId).value = location;
            document.getElementById(resultsId).classList.add('d-none');
        }

        // Close autocomplete when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.matches('[data-autocomplete="location"]')) {
                document.querySelectorAll('.autocomplete-dropdown').forEach(dropdown => {
                    dropdown.classList.add('d-none');
                });
            }
        });

        // Auto-load search results from home page
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('search') === 'true') {
                const searchParams = JSON.parse(sessionStorage.getItem('searchParams') || '{}');
                
                if (searchParams.source && searchParams.destination && searchParams.date) {
                    document.getElementById('searchSource').value = searchParams.source;
                    document.getElementById('searchDestination').value = searchParams.destination;
                    document.querySelector('input[name="date"]').value = searchParams.date;
                    
                    // Clear from session storage
                    sessionStorage.removeItem('searchParams');
                }
            }
        });
    </script>
</body>
</html>
