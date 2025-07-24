<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <meta name="csrf-token" content="<?= Security::generateCSRFToken() ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">
    
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

        .connection-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 10px 0;
            border-left: 5px solid;
            transition: all 0.3s ease;
        }

        .connection-card.active-connection {
            border-left-color: #10b981;
        }

        .connection-card.pending-request {
            border-left-color: #f59e0b;
        }

        .connection-card.sent-request {
            border-left-color: #3b82f6;
        }

        .connection-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-accepted { background: #d1fae5; color: #065f46; }
        .status-connected { background: #dcfce7; color: #166534; }
        .status-declined { background: #fee2e2; color: #991b1b; }

        .btn-action {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-accept {
            background: var(--success-gradient);
            color: white;
        }

        .btn-accept:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(17, 153, 142, 0.3);
            color: white;
        }

        .btn-decline {
            background: var(--warning-gradient);
            color: white;
        }

        .btn-decline:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(240, 147, 251, 0.3);
            color: white;
        }

        .btn-contact {
            background: var(--info-gradient);
            color: white;
        }

        .btn-contact:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .filter-badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-badge {
            padding: 8px 16px;
            border-radius: 25px;
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .filter-badge.active {
            background: var(--primary-gradient);
            border-color: transparent;
            color: white;
        }

        .ride-info {
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

        .route-dot.from { background: #10b981; }
        .route-dot.to { background: #ef4444; }

        .connection-stats {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .stat-item i {
            margin-right: 5px;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .connection-card {
                padding: 15px;
            }
            
            .avatar {
                width: 50px;
                height: 50px;
                font-size: 1.1rem;
            }
            
            .filter-badges {
                justify-content: center;
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
                        <a class="nav-link active fw-bold text-primary" href="/dashboard/connections">Connections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard/my-rides">My Rides</a>
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
                            <div class="avatar" style="width: 35px; height: 35px; font-size: 0.9rem;">
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
                        <i class="fas fa-users text-primary me-3"></i>My Connections
                    </h1>
                    <p class="lead text-muted">Build your carpool network and manage ride partnerships</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-5">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card stats-card text-center">
                        <div class="card-body position-relative">
                            <i class="fas fa-handshake fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= count($connections ?? []) ?></h3>
                            <p class="mb-0 opacity-75">Active Connections</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-center" style="background: var(--success-gradient); color: white;">
                        <div class="card-body">
                            <i class="fas fa-inbox fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= count(array_filter($all_incoming_requests ?? [], fn($r) => $r['status'] === 'pending')) ?></h3>
                            <p class="mb-0 opacity-75">Pending Requests</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-center" style="background: var(--warning-gradient); color: white;">
                        <div class="card-body">
                            <i class="fas fa-paper-plane fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= count($all_outgoing_requests ?? []) ?></h3>
                            <p class="mb-0 opacity-75">Sent Requests</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-md-3 mb-3">
                    <div class="card text-center" style="background: var(--info-gradient); color: white;">
                        <div class="card-body">
                            <i class="fas fa-car fa-2x mb-3"></i>
                            <h3 class="fw-bold"><?= array_sum(array_column($connections ?? [], 'shared_rides', 0)) ?></h3>
                            <p class="mb-0 opacity-75">Shared Rides</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills justify-content-center mb-4" id="connectionTabs">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#connections" type="button">
                                <i class="fas fa-users me-2"></i>My Connections (<?= count($connections ?? []) ?>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#incoming" type="button">
                                <i class="fas fa-inbox me-2"></i>Incoming (<?= count($all_incoming_requests ?? []) ?>)
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#outgoing" type="button">
                                <i class="fas fa-paper-plane me-2"></i>Sent (<?= count($all_outgoing_requests ?? []) ?>)
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Active Connections Tab -->
                        <div class="tab-pane fade show active" id="connections">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="fw-bold text-dark">Active Connections</h4>
                                        <div class="filter-badges">
                                            <span class="filter-badge active" onclick="filterConnections('all')">All</span>
                                            <span class="filter-badge" onclick="filterConnections('recent')">Recent</span>
                                            <span class="filter-badge" onclick="filterConnections('frequent')">Frequent Riders</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if (empty($connections)): ?>
                                <div class="empty-state">
                                    <i class="fas fa-user-friends"></i>
                                    <h4 class="text-muted mb-3">No connections yet</h4>
                                    <p class="text-muted mb-4">Start building your carpool network by connecting with riders and drivers</p>
                                    <a href="/dashboard" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Find Rides to Connect
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php foreach ($connections as $connection): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="connection-card active-connection" data-filter="all">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar me-4">
                                                        <?= strtoupper(substr($connection['name'], 0, 2)) ?>
                                                    </div>
                                                    
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($connection['name']) ?></h5>
                                                                <p class="text-muted mb-0 small"><?= htmlspecialchars($connection['email']) ?></p>
                                                            </div>
                                                            <span class="status-badge status-connected">Connected</span>
                                                        </div>
                                                        
                                                        <div class="connection-stats">
                                                            <div class="stat-item">
                                                                <i class="fas fa-calendar"></i>
                                                                <span>Since <?= date('M Y', strtotime($connection['connected_at'])) ?></span>
                                                            </div>
                                                            <div class="stat-item">
                                                                <i class="fas fa-route"></i>
                                                                <span><?= $connection['shared_rides'] ?? 0 ?> rides</span>
                                                            </div>
                                                            <div class="stat-item">
                                                                <i class="fas fa-star"></i>
                                                                <span>4.8/5</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="d-flex gap-2 mt-3">
                                                            <?php if (!empty($connection['phone'])): ?>
                                                                <button onclick="contactUser('<?= htmlspecialchars($connection['name']) ?>', '<?= htmlspecialchars($connection['phone']) ?>')" 
                                                                        class="btn btn-action btn-contact">
                                                                    <i class="fas fa-phone me-1"></i>Call
                                                                </button>
                                                            <?php endif; ?>
                                                            <button onclick="messageUser('<?= htmlspecialchars($connection['name']) ?>')" 
                                                                    class="btn btn-action btn-accept">
                                                                <i class="fas fa-comment me-1"></i>Message
                                                            </button>
                                                            <button onclick="viewHistory(<?= $connection['id'] ?>)" 
                                                                    class="btn btn-action btn-decline">
                                                                <i class="fas fa-history me-1"></i>History
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Incoming Requests Tab -->
                        <div class="tab-pane fade" id="incoming">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="fw-bold text-dark mb-3">Incoming Connection Requests</h4>
                                </div>
                            </div>

                            <?php if (empty($all_incoming_requests)): ?>
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h4 class="text-muted mb-3">No incoming requests</h4>
                                    <p class="text-muted">You'll see connection requests from other users here</p>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-12">
                                        <?php foreach ($all_incoming_requests as $request): ?>
                                            <div class="connection-card pending-request mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar me-4">
                                                        <?= strtoupper(substr($request['sender_name'], 0, 2)) ?>
                                                    </div>
                                                    
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h5 class="fw-bold mb-1"><?= htmlspecialchars($request['sender_name']) ?></h5>
                                                                <p class="text-muted mb-0 small"><?= htmlspecialchars($request['sender_email'] ?? 'Email not available') ?></p>
                                                            </div>
                                                            <span class="status-badge status-<?= $request['status'] ?>">
                                                                <?= ucfirst($request['status']) ?>
                                                            </span>
                                                        </div>
                                                        
                                                        <?php if ($request['request_type'] === 'ride_book' && !empty($request['source'])): ?>
                                                            <div class="ride-info">
                                                                <h6 class="fw-semibold mb-2">
                                                                    <i class="fas fa-car me-2 text-primary"></i>Ride Booking Request
                                                                </h6>
                                                                <div class="route-point">
                                                                    <div class="route-dot from"></div>
                                                                    <span><?= htmlspecialchars($request['source']) ?></span>
                                                                </div>
                                                                <div class="route-point">
                                                                    <div class="route-dot to"></div>
                                                                    <span><?= htmlspecialchars($request['destination']) ?></span>
                                                                </div>
                                                                <?php if (!empty($request['ride_date'])): ?>
                                                                    <div class="stat-item mt-2">
                                                                        <i class="fas fa-calendar"></i>
                                                                        <span><?= date('d M Y, h:i A', strtotime($request['ride_date'] . ' ' . $request['ride_time'])) ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($request['message'])): ?>
                                                            <div class="alert alert-light mt-2 mb-2">
                                                                <small class="text-muted d-block mb-1">Message:</small>
                                                                <em>"<?= htmlspecialchars($request['message']) ?>"</em>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="stat-item mb-3">
                                                            <i class="fas fa-clock"></i>
                                                            <span>Received <?= date('d M Y, h:i A', strtotime($request['created_at'])) ?></span>
                                                        </div>
                                                        
                                                        <?php if ($request['status'] === 'pending'): ?>
                                                            <div class="d-flex gap-2">
                                                                <button onclick="respondToRequest(<?= $request['id'] ?>, 'accepted')" 
                                                                        class="btn btn-action btn-accept">
                                                                    <i class="fas fa-check me-1"></i>Accept
                                                                </button>
                                                                <button onclick="respondToRequest(<?= $request['id'] ?>, 'declined')" 
                                                                        class="btn btn-action btn-decline">
                                                                    <i class="fas fa-times me-1"></i>Decline
                                                                </button>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="text-muted small">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Request <?= $request['status'] ?> on <?= date('d M Y', strtotime($request['updated_at'])) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Outgoing Requests Tab -->
                        <div class="tab-pane fade" id="outgoing">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="fw-bold text-dark mb-3">Sent Connection Requests</h4>
                                </div>
                            </div>

                            <?php if (empty($all_outgoing_requests)): ?>
                                <div class="empty-state">
                                    <i class="fas fa-paper-plane"></i>
                                    <h4 class="text-muted mb-3">No sent requests</h4>
                                    <p class="text-muted">Requests you send to other users will appear here</p>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-12">
                                        <?php foreach ($all_outgoing_requests as $request): ?>
                                            <div class="connection-card sent-request mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar me-4">
                                                        <?= strtoupper(substr($request['receiver_name'], 0, 2)) ?>
                                                    </div>
                                                    
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h5 class="fw-bold mb-1">To: <?= htmlspecialchars($request['receiver_name']) ?></h5>
                                                                <p class="text-muted mb-0 small"><?= htmlspecialchars($request['receiver_email'] ?? 'Email not available') ?></p>
                                                            </div>
                                                            <span class="status-badge status-<?= $request['status'] ?>">
                                                                <?= ucfirst($request['status']) ?>
                                                            </span>
                                                        </div>
                                                        
                                                        <?php if ($request['request_type'] === 'ride_book' && !empty($request['source'])): ?>
                                                            <div class="ride-info">
                                                                <h6 class="fw-semibold mb-2">
                                                                    <i class="fas fa-car me-2 text-primary"></i>Ride Booking Request
                                                                </h6>
                                                                <div class="route-point">
                                                                    <div class="route-dot from"></div>
                                                                    <span><?= htmlspecialchars($request['source']) ?></span>
                                                                </div>
                                                                <div class="route-point">
                                                                    <div class="route-dot to"></div>
                                                                    <span><?= htmlspecialchars($request['destination']) ?></span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        
                                                        <div class="stat-item mb-2">
                                                            <i class="fas fa-clock"></i>
                                                            <span>
                                                                <?php if ($request['status'] === 'pending'): ?>
                                                                    Sent <?= date('d M Y, h:i A', strtotime($request['created_at'])) ?>
                                                                <?php else: ?>
                                                                    <?= ucfirst($request['status']) ?> on <?= date('d M Y, h:i A', strtotime($request['updated_at'])) ?>
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="text-muted small">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            <?php if ($request['status'] === 'pending'): ?>
                                                                Waiting for response...
                                                            <?php elseif ($request['status'] === 'accepted'): ?>
                                                                Request accepted! You are now connected.
                                                            <?php else: ?>
                                                                Request was declined.
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
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
    <script src="public/js/app.js"></script>
    
    <script>
        // Filter connections
        function filterConnections(type) {
            const badges = document.querySelectorAll('.filter-badge');
            const connections = document.querySelectorAll('[data-filter]');
            
            badges.forEach(badge => badge.classList.remove('active'));
            event.target.classList.add('active');
            
            connections.forEach(connection => {
                if (type === 'all') {
                    connection.style.display = 'block';
                } else {
                    // Add filter logic based on type
                    connection.style.display = 'block';
                }
            });
        }

        // Respond to connection request
        async function respondToRequest(requestId, status) {
            const action = status === 'accepted' ? 'accept' : 'decline';
            
            const result = await Swal.fire({
                title: `${action.charAt(0).toUpperCase() + action.slice(1)} Request?`,
                text: `Are you sure you want to ${action} this connection request?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: status === 'accepted' ? '#10b981' : '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${action}!`,
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const formData = new FormData();
                formData.append('request_id', requestId);
                formData.append('status', status);
                formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);

                Swal.fire({
                    title: 'Processing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch('/dashboard/respond-request', {
                    method: 'POST',
                    body: formData
                });

                const responseData = await response.json();

                if (responseData.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: responseData.message,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: responseData.message || 'Failed to respond to request',
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                console.error('Request response error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to respond to request. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        }

        // Contact user
        function contactUser(name, phone) {
            Swal.fire({
                title: `Contact ${name}`,
                text: `Call ${name} at ${phone}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Call Now',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`tel:${phone}`);
                }
            });
        }

        // Message user
        function messageUser(name) {
            Swal.fire({
                title: `Message ${name}`,
                text: 'Messaging feature coming soon! You can contact them directly via phone for now.',
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        }

        // View ride history
        function viewHistory(connectionId) {
            Swal.fire({
                title: 'Ride History',
                text: 'Detailed ride history feature coming soon!',
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        }
    </script>
</body>
</html>
