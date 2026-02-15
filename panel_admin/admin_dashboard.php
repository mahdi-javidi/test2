<?php
session_start();
if (!isset($_SESSION['role'])) { $_SESSION['role'] = 'admin'; }
if (!isset($_SESSION['username'])) { $_SESSION['username'] = 'Local Admin'; }
if (!isset($_SESSION['user_id'])) { $_SESSION['user_id'] = -1; }
$page = isset($_GET['section']) ? $_GET['section'] : 'main';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>پنل مدیریت گرین‌نت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
      body{background:#f8f9fa}
      .sidebar{width:240px;position:fixed;right:0;top:0;bottom:0;padding:1rem;background:#fff;border-left:1px solid #dee2e6}
      .main-content{margin-right:260px;padding:1rem}
      .nav-link{display:block;padding:.5rem .75rem;border-radius:.375rem}
      .nav-link.active{background:#0d6efd;color:#fff}
      .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-leaf text-success"></i> گرین‌نت پنل
        </div>
        <nav>
            <a href="?section=main" class="nav-link <?= $page == 'main' ? 'active' : '' ?>">
                <i class="fas fa-home"></i> پیشخوان
            </a>
            <a href="?section=users" class="nav-link <?= $page == 'users' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> مدیریت کاربران
            </a>
            <a href="?section=posts" class="nav-link <?= $page == 'posts' ? 'active' : '' ?>">
                <i class="fas fa-file-alt"></i> مدیریت پست‌ها
            </a>
            <a href="?section=products" class="nav-link <?= $page == 'products' ? 'active' : '' ?>">
                <i class="fas fa-box"></i> مدیریت محصولات
            </a>
            <a href="?section=slider" class="nav-link <?= $page == 'slider' ? 'active' : '' ?>">
                <i class="fas fa-images"></i> مدیریت اسلایدر
            </a>
            <a href="?section=comments" class="nav-link <?= $page == 'comments' ? 'active' : '' ?>">
                <i class="fas fa-comments"></i> مدیریت نظرات
            </a>
            <hr style="border-color: #2d3748;">
            <a href="logout.php" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> خروج
            </a>
        </nav>
    </div>
    <div class="main-content">
        <div class="top-bar">
            <span class="text-muted">خوش آمدید، <strong><?= $_SESSION['username'] ?></strong></span>
            <a href="persian site.php" class="btn btn-sm btn-outline-primary">مشاهده سایت</a>
        </div>
        <div class="content-body">
            <?php
            switch ($page) {
                case 'users':
                    include(__DIR__ . '/users.php');
                    break;
                case 'posts':
                    include(__DIR__ . '/posts.php');
                    break;
                case 'products':
                    include(__DIR__ . '/subscription.php');
                    break;
                case 'slider':
                    include(__DIR__ . '/slidedr.php');
                    break;
                case 'comments':
                    include(__DIR__ . '/comments.php');
                    break;
                default:
                    echo '<div class="alert alert-info">Welcome to Admin Dashboard. Select a section from the sidebar.</div>';
                    break;
            }
            ?>
        </div>
    </div>
</body>
</html>
