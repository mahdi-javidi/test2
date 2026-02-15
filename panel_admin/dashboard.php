<?php
session_start();

// Set default session values if not logged in
if (!isset($_SESSION['role'])) { $_SESSION['role'] = 'admin'; }
if (!isset($_SESSION['username'])) { $_SESSION['username'] = 'Admin'; }
if (!isset($_SESSION['user_id'])) { $_SESSION['user_id'] = 1; }

$page = isset($_GET['section']) ? $_GET['section'] : 'main';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arcade Gaming - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4>
                <span class="logo-icon">
                    <i class="fas fa-gamepad"></i>
                </span>
                Arcade Admin
            </h4>
        </div>
        <nav>
            <div class="nav-section-title">Main</div>
            <a href="?section=main" class="nav-link <?= $page == 'main' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            
            <div class="nav-section-title">Content Management</div>
            <a href="?section=posts" class="nav-link <?= $page == 'posts' ? 'active' : '' ?>">
                <i class="fas fa-file-alt"></i> Posts
            </a>
            <a href="?section=slider" class="nav-link <?= $page == 'slider' ? 'active' : '' ?>">
                <i class="fas fa-images"></i> Slider
            </a>
            <a href="?section=comments" class="nav-link <?= $page == 'comments' ? 'active' : '' ?>">
                <i class="fas fa-comments"></i> Comments
            </a>
            
            <div class="nav-section-title">User Management</div>
            <a href="?section=users" class="nav-link <?= $page == 'users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="?section=subscription" class="nav-link <?= $page == 'subscription' ? 'active' : '' ?>">
                <i class="fas fa-envelope"></i> Subscriptions
            </a>
            
            <div class="nav-section-title">Settings</div>
            <a href="../arcade-gaming.php" class="nav-link" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
            <a href="logout.php" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <div>
                <h5>
                    <?php
                    $titles = [
                        'main' => 'Dashboard Overview',
                        'posts' => 'Posts Management',
                        'users' => 'User Management',
                        'slider' => 'Slider Management',
                        'comments' => 'Comments Management',
                        'subscription' => 'Subscriptions'
                    ];
                    echo $titles[$page] ?? 'Admin Panel';
                    ?>
                </h5>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                </div>
                <div>
                    <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                    <br>
                    <small class="text-muted"><?= ucfirst($_SESSION['role']) ?></small>
                </div>
            </div>
        </div>
        
        <div class="content-body">
            <?php
            switch ($page) {
                case 'posts':
                    include(__DIR__ . '/posts.php');
                    break;
                case 'users':
                    include(__DIR__ . '/users.php');
                    break;
                case 'slider':
                    include(__DIR__ . '/slidedr.php');
                    break;
                case 'comments':
                    include(__DIR__ . '/comments.php');
                    break;
                case 'subscription':
                    include(__DIR__ . '/subscription.php');
                    break;
                case 'main':
                default:
                    // Dashboard overview
                    require_once __DIR__ . '/../include/db.php';
                    if ($mysqli) {
                        $stats = [
                            'posts' => $mysqli->query("SELECT COUNT(*) as count FROM posts")->fetch_assoc()['count'],
                            'users' => $mysqli->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'],
                            'comments' => $mysqli->query("SELECT COUNT(*) as count FROM comments")->fetch_assoc()['count'],
                            'likes' => $mysqli->query("SELECT COUNT(*) as count FROM likes")->fetch_assoc()['count']
                        ];
                    ?>
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">Total Posts</h6>
                                            <h2 class="mb-0 mt-2"><?= $stats['posts'] ?></h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-file-alt fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">Total Users</h6>
                                            <h2 class="mb-0 mt-2"><?= $stats['users'] ?></h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-users fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">Total Comments</h6>
                                            <h2 class="mb-0 mt-2"><?= $stats['comments'] ?></h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-comments fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card text-white bg-danger">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title mb-0">Total Likes</h6>
                                            <h2 class="mb-0 mt-2"><?= $stats['likes'] ?></h2>
                                        </div>
                                        <div>
                                            <i class="fas fa-heart fa-3x opacity-50"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Recent Posts</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Likes</th>
                                                    <th>Comments</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $recent = $mysqli->query("SELECT p.*, 
                                                    (SELECT COUNT(*) FROM likes WHERE post_id=p.id) as likes,
                                                    (SELECT COUNT(*) FROM comments WHERE post_id=p.id) as comments
                                                    FROM posts p ORDER BY p.created_at DESC LIMIT 5");
                                                while($row = $recent->fetch_assoc()):
                                                ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                                    <td><span class="badge bg-danger"><?= $row['likes'] ?></span></td>
                                                    <td><span class="badge bg-primary"><?= $row['comments'] ?></span></td>
                                                    <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="?section=posts" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Create New Post
                                        </a>
                                        <a href="?section=users" class="btn btn-success">
                                            <i class="fas fa-user-plus"></i> Add New User
                                        </a>
                                        <a href="?section=slider" class="btn btn-info">
                                            <i class="fas fa-image"></i> Manage Slider
                                        </a>
                                        <a href="../arcade-gaming.php" class="btn btn-secondary" target="_blank">
                                            <i class="fas fa-external-link-alt"></i> View Website
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    } else {
                        echo '<div class="alert alert-danger">Database connection failed</div>';
                    }
                    break;
            }
            ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
