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
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
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
            <a href="?section=subscriptions" class="nav-link <?= $page == 'subscriptions' ? 'active' : '' ?>">
                <i class="fas fa-crown"></i> مدیریت اشتراک
            </a>
            <a href="?section=slider" class="nav-link <?= $page == 'slider' ? 'active' : '' ?>">
                <i class="fas fa-images"></i> مدیریت اسلایدر
            </a>
            <a href="?section=comments" class="nav-link <?= $page == 'comments' ? 'active' : '' ?>">
                <i class="fas fa-comments"></i> مدیریت نظرات
            </a>
            <hr style="border-color: #2d3748;">
            <a href="#" id="darkModeToggle" class="nav-link">
                <i class="fas fa-moon"></i> حالت تاریک
            </a>
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
                case 'subscriptions':
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
    <script>
        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;
        
        // Check for saved dark mode preference
        if (localStorage.getItem('adminDarkMode') === 'enabled') {
            body.classList.add('dark-mode');
            updateDarkModeIcon(true);
        }
        
        darkModeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('adminDarkMode', 'enabled');
                updateDarkModeIcon(true);
            } else {
                localStorage.setItem('adminDarkMode', 'disabled');
                updateDarkModeIcon(false);
            }
        });
        
        function updateDarkModeIcon(isDark) {
            const icon = darkModeToggle.querySelector('i');
            const text = darkModeToggle.childNodes[1];
            if (isDark) {
                icon.className = 'fas fa-sun';
                text.textContent = ' حالت روشن';
            } else {
                icon.className = 'fas fa-moon';
                text.textContent = ' حالت تاریک';
            }
        }
    </script>
</body>
</html>