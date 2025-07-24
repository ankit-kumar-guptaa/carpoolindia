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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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

        .nav-pills .nav-link {
            border-radius: 50px;
            margin: 0 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 12px 25px;
        }

        .nav-pills .nav-link.active {
            background: var(--primary-gradient);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .ride-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 10px 0;
            border-left: 5px solid;
            transition: all 0.3s ease;
        }

        .ride-card.created {
            border-left-color: #667eea;
        }

        .ride-card.booked {
            border-left-color: #11998e;
        }

        .ride-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active { background: #e3f2fd; color: #1976d2; }
        .status-started { background: #e8f5e8; color: #2e7d32; }
        .status-completed { background: #f3e5f5; color: #7b1fa2; }
        .status-cancelled { background: #ffebee; color: #c62828; }
        .status-pending { background: #fff3e0; color: #f57c00; }
        .status-confirmed { background: #e8f5e8; color: #2e7d32; }

        .btn-action {
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
            margin: 2px;
        }

        .btn-start {
            background: var(--success-gradient);
            color: white;
        }

        .btn-complete {
            background: var(--warning-gradient);
            color: white;
        }

        .btn-complete:disabled {
            background: #6c757d;
            color: white;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-action:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .payment-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }

        .passenger-item {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .passenger-item:hover {
            background: #f8f9fa;
            border-color: #667eea;
        }

        .payment-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-status {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .payment-cash {
            background: #d4edda;
            color: #155724;
        }

        .payment-online {
            background: #cce5ff;
            color: #004085;
        }

        .payment-pending {
            background: #fff3cd;
            color: #856404;
        }

        .earnings-display {
            background: var(--success-gradient);
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.3);
        }

        .route-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
        }

        .route-point {
            display: flex;
            align-items: center;
            margin: 8px 0;
        }

        .route-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .route-dot.from { background: #28a745; }
        .route-dot.to { background: #dc3545; }

        .complete-disabled-hint {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 10px;
            margin: 10px 0;
            font-size: 0.85rem;
            color: #856404;
        }

        .sort-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-btn {
            padding: 8px 16px;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 20px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sort-btn.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
        }

        @media (max-width: 768px) {
            .ride-card {
                padding: 15px;
            }
            
            .payment-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .sort-controls {
                flex-wrap: wrap;
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
                        <a class="nav-link" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/connections">Connections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-primary" href="/dashboard/my-rides">My Rides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">Profile</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <a href="/dashboard" class="btn btn-outline-primary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                <?= strtoupper(substr($user['name'], 0, 2)) ?>
                            </div>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid" style="margin-top: 100px;">
        <div class="container">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-car me-3 text-primary"></i>My Rides Dashboard
                    </h1>
                    <p class="lead text-muted">Manage your rides and track payments efficiently</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-5">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card stats-card text-center">
                        <div class="card-body position-relative">
                            <i class="fas fa-car fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= count($rides['created'] ?? []) ?></h3>
                            <p class="mb-0 opacity-75">Rides Created</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <div class="card stats-card success text-center">
                        <div class="card-body position-relative">
                            <i class="fas fa-ticket-alt fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= count($rides['booked'] ?? []) ?></h3>
                            <p class="mb-0 opacity-75">Rides Booked</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <div class="card stats-card warning text-center">
                        <div class="card-body position-relative">
                            <i class="fas fa-money-bill-wave fa-2x mb-3"></i>
                            <h3 class="fw-bold">₹<?= number_format($total_earnings ?? 0) ?></h3>
                            <p class="mb-0 opacity-75">Total Earnings</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <div class="card stats-card info text-center">
                        <div class="card-body position-relative">
                            <i class="fas fa-bell fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= count($booking_requests ?? []) ?></h3>
                            <p class="mb-0 opacity-75">New Requests</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills justify-content-center mb-4" id="myTab">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#created" type="button">
                                <i class="fas fa-car me-2"></i>My Rides (<?= count($rides['created'] ?? []) ?>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#booked" type="button">
                                <i class="fas fa-ticket-alt me-2"></i>My Bookings (<?= count($rides['booked'] ?? []) ?>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#requests" type="button">
                                <i class="fas fa-bell me-2"></i>Requests (<?= count($booking_requests ?? []) ?>)
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Created Rides Tab -->
                        <div class="tab-pane fade show active" id="created">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-steering-wheel me-2"></i>Rides You Created (Pooler)
                                    </h4>
                                    
                                    <!-- Sort Controls -->
                                    <div class="sort-controls">
                                        <span class="text-muted me-2">Sort by:</span>
                                        <button class="sort-btn active" onclick="sortRides('created', 'date_desc')">
                                            <i class="fas fa-calendar me-1"></i>Latest First
                                        </button>
                                        <button class="sort-btn" onclick="sortRides('created', 'date_asc')">
                                            <i class="fas fa-calendar me-1"></i>Oldest First
                                        </button>
                                        <button class="sort-btn" onclick="sortRides('created', 'status')">
                                            <i class="fas fa-filter me-1"></i>By Status
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php if (empty($rides['created'])): ?>
                                <div class="card text-center py-5">
                                    <div class="card-body">
                                        <i class="fas fa-car fa-5x text-muted mb-4"></i>
                                        <h3 class="text-muted mb-3">No rides created yet</h3>
                                        <p class="text-muted mb-4">Start offering rides to earn money and help others commute!</p>
                                        <a href="/dashboard#create" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create Your First Ride
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div id="createdRidesContainer">
                                    <?php 
                                    // Sort rides by latest first
                                    usort($rides['created'], function($a, $b) {
                                        return strtotime($b['ride_date'] . ' ' . $b['ride_time']) - strtotime($a['ride_date'] . ' ' . $a['ride_time']);
                                    });
                                    
                                    foreach ($rides['created'] as $ride): 
                                        // Get bookings for this ride
                                        $bookings = [];
                                        $allPaymentsRecorded = true;
                                        $totalEarned = 0;
                                        
                                        try {
                                            $bookings = $this->db->fetchAll("
                                                SELECT b.*, u.name as passenger_name
                                                FROM bookings b
                                                JOIN users u ON b.user_id = u.id
                                                WHERE b.ride_id = ? AND b.booking_status = 'confirmed'
                                            ", [$ride['id']]);
                                            
                                            foreach ($bookings as $booking) {
                                                if (!isset($booking['payment_mode']) || !$booking['payment_mode']) {
                                                    $allPaymentsRecorded = false;
                                                } else {
                                                    $totalEarned += $booking['booking_amount'];
                                                }
                                            }
                                        } catch (Exception $e) {
                                            $allPaymentsRecorded = false;
                                        }
                                    ?>
                                        <div class="ride-card created mb-4" data-date="<?= strtotime($ride['ride_date'] . ' ' . $ride['ride_time']) ?>" data-status="<?= $ride['status'] ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <!-- Ride Header -->
                                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                                        <div class="d-flex align-items-center">
                                                            <span class="status-badge status-<?= strtolower($ride['status']) ?>">
                                                                <?= ucfirst($ride['status']) ?>
                                                            </span>
                                                            <span class="badge bg-light text-dark ms-2">
                                                                Ride #<?= $ride['id'] ?>
                                                            </span>
                                                            <span class="badge bg-info text-white ms-2">
                                                                <i class="fas fa-clock me-1"></i>
                                                                <?= date('d M Y', strtotime($ride['ride_date'])) ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Route Information -->
                                                    <div class="route-info mb-3">
                                                        <div class="route-point">
                                                            <div class="route-dot from"></div>
                                                            <strong>From:</strong>
                                                            <span class="ms-2"><?= htmlspecialchars($ride['source']) ?></span>
                                                        </div>
                                                        <div class="route-point">
                                                            <div class="route-dot to"></div>
                                                            <strong>To:</strong>
                                                            <span class="ms-2"><?= htmlspecialchars($ride['destination']) ?></span>
                                                        </div>
                                                        <div class="route-point">
                                                            <i class="fas fa-calendar text-primary me-2"></i>
                                                            <span><?= date('d M Y', strtotime($ride['ride_date'])) ?> at <?= date('h:i A', strtotime($ride['ride_time'])) ?></span>
                                                        </div>
                                                    </div>

                                                    <!-- Ride Details -->
                                                    <div class="row text-center mb-3">
                                                        <div class="col-3">
                                                            <i class="fas fa-users text-info"></i>
                                                            <div class="small fw-semibold"><?= $ride['seats_available'] ?> seats left</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <i class="fas fa-check text-success"></i>
                                                            <div class="small fw-semibold"><?= $ride['confirmed_bookings'] ?? 0 ?> confirmed</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <i class="fas fa-clock text-warning"></i>
                                                            <div class="small fw-semibold"><?= $ride['pending_requests'] ?? 0 ?> pending</div>
                                                        </div>
                                                        <div class="col-3">
                                                            <i class="fas fa-rupee-sign text-primary"></i>
                                                            <div class="small fw-semibold">₹<?= $ride['price_per_seat'] ?> per seat</div>
                                                        </div>
                                                    </div>

                                                    <!-- Payment Management Section -->
                                                    <?php if (count($bookings) > 0): ?>
                                                        <div class="payment-section">
                                                            <h6 class="fw-bold text-primary mb-3">
                                                                <i class="fas fa-money-check-alt me-2"></i>Passenger Payments
                                                                <?php if ($ride['status'] !== 'started'): ?>
                                                                    <small class="text-muted">(Start ride to record payments)</small>
                                                                <?php endif; ?>
                                                            </h6>
                                                            
                                                            <?php foreach ($bookings as $booking): ?>
                                                                <div class="passenger-item">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                                                <?= strtoupper(substr($booking['passenger_name'], 0, 2)) ?>
                                                                            </div>
                                                                            <div>
                                                                                <div class="fw-semibold"><?= htmlspecialchars($booking['passenger_name']) ?></div>
                                                                                <small class="text-muted"><?= $booking['seats_booked'] ?> seat(s) • ₹<?= $booking['booking_amount'] ?></small>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="payment-controls">
                                                                            <?php if (isset($booking['payment_mode']) && $booking['payment_mode']): ?>
                                                                                <span class="payment-status payment-<?= $booking['payment_mode'] ?>">
                                                                                    <i class="fas fa-<?= $booking['payment_mode'] === 'cash' ? 'money-bill' : 'credit-card' ?> me-1"></i>
                                                                                    <?= $booking['payment_mode'] === 'cash' ? 'Cash Received' : 'Paid Online' ?>
                                                                                </span>
                                                                            <?php elseif ($ride['status'] === 'started'): ?>
                                                                                <div class="d-flex align-items-center">
                                                                                    <select class="form-select form-select-sm me-2" id="paymentMode<?= $booking['id'] ?>" style="width: 150px;">
                                                                                        <option value="">Payment Mode</option>
                                                                                        <option value="cash">💵 Cash</option>
                                                                                        <option value="online">💳 Online</option>
                                                                                    </select>
                                                                                    <button onclick="recordPayment(<?= $booking['id'] ?>)" 
                                                                                            class="btn btn-primary btn-sm">
                                                                                        <i class="fas fa-save me-1"></i>Save
                                                                                    </button>
                                                                                </div>
                                                                            <?php else: ?>
                                                                                <span class="payment-status payment-pending">
                                                                                    <i class="fas fa-clock me-1"></i>
                                                                                    Start ride first
                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                            
                                                            <?php if ($ride['status'] === 'started' && !$allPaymentsRecorded): ?>
                                                                <div class="complete-disabled-hint">
                                                                    <i class="fas fa-info-circle me-2"></i>
                                                                    <strong>Complete ride:</strong> Record payment mode for all passengers to enable ride completion.
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <!-- Earnings Display -->
                                                    <div class="earnings-display mb-4">
                                                        <h4 class="fw-bold mb-1">₹<?= $totalEarned ?></h4>
                                                        <p class="mb-0 opacity-75">Money Earned</p>
                                                        <small class="opacity-75">Expected: ₹<?= ($ride['confirmed_bookings'] ?? 0) * $ride['price_per_seat'] ?></small>
                                                    </div>

                                                    <!-- Action Buttons -->
                                                    <div class="d-grid gap-2">
                                                        <?php if ($ride['status'] === 'active'): ?>
                                                            <button onclick="startRide(<?= $ride['id'] ?>)" 
                                                                    class="btn btn-action btn-start">
                                                                <i class="fas fa-play me-2"></i>Start Ride
                                                            </button>
                                                            <button onclick="cancelRide(<?= $ride['id'] ?>)" 
                                                                    class="btn btn-action btn-cancel">
                                                                <i class="fas fa-times me-2"></i>Cancel Ride
                                                            </button>
                                                        <?php elseif ($ride['status'] === 'started'): ?>
                                                            <button onclick="completeRide(<?= $ride['id'] ?>)" 
                                                                    class="btn btn-action btn-complete <?= !$allPaymentsRecorded ? 'disabled' : '' ?>"
                                                                    <?= !$allPaymentsRecorded ? 'disabled title="Record all payments first"' : '' ?>>
                                                                <i class="fas fa-check me-2"></i>Complete Ride
                                                            </button>
                                                            <?php if (!$allPaymentsRecorded): ?>
                                                                <small class="text-muted text-center">
                                                                    <i class="fas fa-info-circle me-1"></i>
                                                                    Record payments to complete
                                                                </small>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        
                                                        <button onclick="viewRideDetails(<?= $ride['id'] ?>)" 
                                                                class="btn btn-outline-primary">
                                                            <i class="fas fa-eye me-2"></i>View Details
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Booked Rides Tab -->
                        <div class="tab-pane fade" id="booked">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="fw-bold text-success mb-3">
                                        <i class="fas fa-user me-2"></i>Your Bookings (Seeker)
                                    </h4>
                                    
                                    <!-- Sort Controls -->
                                    <div class="sort-controls">
                                        <span class="text-muted me-2">Sort by:</span>
                                        <button class="sort-btn active" onclick="sortRides('booked', 'date_desc')">
                                            <i class="fas fa-calendar me-1"></i>Latest First
                                        </button>
                                        <button class="sort-btn" onclick="sortRides('booked', 'date_asc')">
                                            <i class="fas fa-calendar me-1"></i>Oldest First
                                        </button>
                                        <button class="sort-btn" onclick="sortRides('booked', 'status')">
                                            <i class="fas fa-filter me-1"></i>By Status
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <?php if (empty($rides['booked'])): ?>
                                <div class="card text-center py-5">
                                    <div class="card-body">
                                        <i class="fas fa-search fa-5x text-muted mb-4"></i>
                                        <h3 class="text-muted mb-3">No bookings yet</h3>
                                        <p class="text-muted mb-4">Search and book rides to start your journey!</p>
                                        <a href="/dashboard#search" class="btn btn-success">
                                            <i class="fas fa-search me-2"></i>Search Rides
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div id="bookedRidesContainer">
                                    <?php 
                                    // Sort bookings by latest first
                                    usort($rides['booked'], function($a, $b) {
                                        return strtotime($b['ride_date'] . ' ' . $b['ride_time']) - strtotime($a['ride_date'] . ' ' . $a['ride_time']);
                                    });
                                    
                                    foreach ($rides['booked'] as $booking): 
                                    ?>
                                        <div class="ride-card booked mb-4" data-date="<?= strtotime($booking['ride_date'] . ' ' . $booking['ride_time']) ?>" data-status="<?= $booking['booking_status'] ?>">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                            <?= strtoupper(substr($booking['driver_name'], 0, 2)) ?>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-1 fw-bold">Driver: <?= htmlspecialchars($booking['driver_name']) ?></h5>
                                                            <span class="status-badge status-<?= strtolower($booking['booking_status']) ?>">
                                                                <?= ucfirst($booking['booking_status']) ?>
                                                            </span>
                                                            <span class="badge bg-info text-white ms-2">
                                                                <i class="fas fa-clock me-1"></i>
                                                                <?= date('d M Y', strtotime($booking['ride_date'])) ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Route Information -->
                                                    <div class="route-info mb-3">
                                                        <div class="route-point">
                                                            <div class="route-dot from"></div>
                                                            <strong>From:</strong>
                                                            <span class="ms-2"><?= htmlspecialchars($booking['source']) ?></span>
                                                        </div>
                                                        <div class="route-point">
                                                            <div class="route-dot to"></div>
                                                            <strong>To:</strong>
                                                            <span class="ms-2"><?= htmlspecialchars($booking['destination']) ?></span>
                                                        </div>
                                                        <div class="route-point">
                                                            <i class="fas fa-calendar text-primary me-2"></i>
                                                            <span><?= date('d M Y', strtotime($booking['ride_date'])) ?> at <?= date('h:i A', strtotime($booking['ride_time'])) ?></span>
                                                        </div>
                                                    </div>

                                                    <?php if (in_array($booking['booking_status'], ['confirmed', 'started']) && !empty($booking['driver_phone'])): ?>
                                                        <div class="mb-3">
                                                            <button onclick="callDriver('<?= htmlspecialchars($booking['driver_phone']) ?>')" 
                                                                    class="btn btn-success btn-sm">
                                                                <i class="fas fa-phone me-1"></i><?= htmlspecialchars($booking['driver_phone']) ?>
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="earnings-display mb-3">
                                                        <h4 class="fw-bold mb-1">₹<?= $booking['booking_amount'] ?></h4>
                                                        <p class="mb-0 opacity-75">
                                                            <?php if (isset($booking['payment_mode']) && $booking['payment_mode']): ?>
                                                                <?= $booking['payment_mode'] === 'cash' ? 'Cash Payment' : 'Online Payment' ?>
                                                            <?php else: ?>
                                                                Payment Mode TBD
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>

                                                    <div class="d-grid gap-2">
                                                        <?php if (in_array($booking['booking_status'], ['pending', 'confirmed'])): ?>
                                                            <button onclick="cancelBooking(<?= $booking['booking_id'] ?>)" 
                                                                    class="btn btn-action btn-cancel">
                                                                <i class="fas fa-times me-2"></i>Cancel Booking
                                                            </button>
                                                        <?php endif; ?>
                                                        
                                                        <?php if ($booking['booking_status'] === 'completed'): ?>
                                                            <button onclick="rateRide(<?= $booking['booking_id'] ?>)" 
                                                                    class="btn btn-warning">
                                                                <i class="fas fa-star me-2"></i>Rate Ride
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Booking Requests Tab -->
                        <div class="tab-pane fade" id="requests">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="fw-bold text-warning mb-3">
                                        <i class="fas fa-bell me-2"></i>Booking Requests for Your Rides
                                    </h4>
                                </div>
                            </div>

                            <?php if (empty($booking_requests)): ?>
                                <div class="card text-center py-5">
                                    <div class="card-body">
                                        <i class="fas fa-bell fa-5x text-muted mb-4"></i>
                                        <h3 class="text-muted mb-3">No booking requests</h3>
                                        <p class="text-muted">People will send booking requests for your rides here.</p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php 
                                // Sort requests by latest first
                                usort($booking_requests, function($a, $b) {
                                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                                });
                                
                                foreach ($booking_requests as $request): 
                                ?>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                            <?= strtoupper(substr($request['passenger_name'], 0, 2)) ?>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-1 fw-bold"><?= htmlspecialchars($request['passenger_name']) ?></h5>
                                                            <span class="badge bg-warning text-dark">New Request</span>
                                                            <span class="badge bg-info text-white ms-2">
                                                                <i class="fas fa-clock me-1"></i>
                                                                <?= date('d M Y', strtotime($request['created_at'])) ?>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Route:</small>
                                                                <div><?= htmlspecialchars($request['source']) ?> → <?= htmlspecialchars($request['destination']) ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <small class="text-muted">Date & Time:</small>
                                                                <div><?= date('d M Y, h:i A', strtotime($request['ride_date'] . ' ' . $request['ride_time'])) ?></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <small class="text-muted">Seats & Amount:</small>
                                                        <div><?= $request['seats_booked'] ?> seat(s) - ₹<?= $request['booking_amount'] ?></div>
                                                    </div>

                                                    <?php if (!empty($request['request_message'])): ?>
                                                        <div class="alert alert-light">
                                                            <small class="text-muted">Message:</small>
                                                            <div class="fst-italic">"<?= htmlspecialchars($request['request_message']) ?>"</div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="d-grid gap-2">
                                                        <button onclick="acceptBookingRequest(<?= $request['id'] ?>)" 
                                                                class="btn btn-success">
                                                            <i class="fas fa-check me-2"></i>Accept Request
                                                        </button>
                                                        <button onclick="rejectBookingRequest(<?= $request['id'] ?>)" 
                                                                class="btn btn-danger">
                                                            <i class="fas fa-times me-2"></i>Reject Request
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Sort rides function
        function sortRides(type, sortBy) {
            const container = document.getElementById(type + 'RidesContainer');
            const rides = Array.from(container.children);
            const buttons = document.querySelectorAll('.sort-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            let sortedRides;
            
            switch(sortBy) {
                case 'date_desc':
                    sortedRides = rides.sort((a, b) => {
                        const dateA = parseInt(a.dataset.date);
                        const dateB = parseInt(b.dataset.date);
                        return dateB - dateA;
                    });
                    break;
                    
                case 'date_asc':
                    sortedRides = rides.sort((a, b) => {
                        const dateA = parseInt(a.dataset.date);
                        const dateB = parseInt(b.dataset.date);
                        return dateA - dateB;
                    });
                    break;
                    
                case 'status':
                    sortedRides = rides.sort((a, b) => {
                        const statusA = a.dataset.status;
                        const statusB = b.dataset.status;
                        const order = ['active', 'started', 'completed', 'cancelled'];
                        return order.indexOf(statusA) - order.indexOf(statusB);
                    });
                    break;
                    
                default:
                    sortedRides = rides;
            }
            
            // Clear container and add sorted rides
            container.innerHTML = '';
            sortedRides.forEach(ride => container.appendChild(ride));
        }

        // Record payment for passenger (only if ride is started)
        async function recordPayment(bookingId) {
            const paymentMode = document.getElementById(`paymentMode${bookingId}`).value;
            
            if (!paymentMode) {
                Swal.fire({
                    title: 'Select Payment Mode',
                    text: 'Please select how the passenger paid',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
                return;
            }

            try {
                const formData = new FormData();
                formData.append('booking_id', bookingId);
                formData.append('payment_mode', paymentMode);
                formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);

                Swal.fire({
                    title: 'Recording Payment...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch('/dashboard/record-payment', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: 'Payment Recorded!',
                        text: `Payment mode recorded as ${paymentMode === 'cash' ? 'Cash' : 'Online'}`,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Failed to record payment',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                console.error('Payment recording error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to record payment. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        }

        // Start ride without transaction issues
        function startRide(rideId) {
            Swal.fire({
                title: 'Start Ride?',
                text: 'This will notify all confirmed passengers that the ride has started.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Start Ride!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('/dashboard/start-ride', {
                        ride_id: rideId
                    });
                }
            });
        }

        // Complete ride (only if all payments recorded)
        function completeRide(rideId) {
            // Check if button is disabled
            const button = event.target;
            if (button.disabled || button.classList.contains('disabled')) {
                Swal.fire({
                    title: 'Cannot Complete Ride',
                    text: 'Please record payment mode for all passengers before completing the ride.',
                    icon: 'warning',
                    confirmButtonColor: '#f59e0b'
                });
                return;
            }

            Swal.fire({
                title: 'Complete Ride?',
                text: 'Mark this ride as completed? This action cannot be undone.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f093fb',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, Complete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('/dashboard/complete-ride', {
                        ride_id: rideId
                    });
                }
            });
        }

        // Cancel ride
        function cancelRide(rideId) {
            Swal.fire({
                title: 'Cancel Ride?',
                input: 'textarea',
                inputLabel: 'Reason for cancellation',
                inputPlaceholder: 'Please provide a reason...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please provide a reason for cancellation';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('/dashboard/update-ride-status', {
                        ride_id: rideId,
                        status: 'cancelled',
                        reason: result.value
                    });
                }
            });
        }

        // Accept booking request
        function acceptBookingRequest(requestId) {
            Swal.fire({
                title: 'Accept Booking Request?',
                text: 'The passenger will be notified and can proceed with the ride.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                confirmButtonText: 'Accept',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('/dashboard/respond-booking-request', {
                        booking_id: requestId,
                        status: 'confirmed'
                    });
                }
            });
        }

        // Reject booking request
        function rejectBookingRequest(requestId) {
            Swal.fire({
                title: 'Reject Booking Request?',
                input: 'textarea',
                inputLabel: 'Reason for rejection (optional)',
                inputPlaceholder: 'Let the passenger know why...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Reject',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('/dashboard/respond-booking-request', {
                        booking_id: requestId,
                        status: 'rejected',
                        reason: result.value || ''
                    });
                }
            });
        }

        // Cancel booking
        function cancelBooking(bookingId) {
            Swal.fire({
                title: 'Cancel Booking?',
                input: 'textarea',
                inputLabel: 'Reason for cancellation',
                inputPlaceholder: 'Please provide a reason...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Please provide a reason for cancellation';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    performAction('/dashboard/cancel-booking', {
                        booking_id: bookingId,
                        reason: result.value
                    });
                }
            });
        }

        // Call driver
        function callDriver(phone) {
            window.open(`tel:${phone}`);
        }

        // View ride details
        function viewRideDetails(rideId) {
            Swal.fire({
                title: 'Ride Details',
                text: `Viewing details for ride #${rideId}`,
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        }

        // Rate ride
        function rateRide(bookingId) {
            Swal.fire({
                title: 'Rate Your Ride Experience',
                text: 'Rating system coming soon!',
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        }

        // Perform action helper
        async function performAction(url, data) {
            try {
                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData();
                Object.keys(data).forEach(key => {
                    formData.append(key, data[key]);
                });
                formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.message || 'Action failed',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                console.error('Action error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Action failed. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    </script>
</body>
</html>
