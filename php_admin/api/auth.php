<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../include/db.php';

if (!$mysqli) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Database connection failed']);
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    
    // Validation
    if (strlen($username) < 2) {
        echo json_encode(['ok' => false, 'error' => 'Username must be at least 2 characters']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['ok' => false, 'error' => 'Invalid email address']);
        exit;
    }
    
    if (strlen($password) < 6) {
        echo json_encode(['ok' => false, 'error' => 'Password must be at least 6 characters']);
        exit;
    }
    
    // Check if username or email already exists
    $stmt = $mysqli->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo json_encode(['ok' => false, 'error' => 'Username or email already exists']);
        exit;
    }
    $stmt->close();
    
    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['profile_picture']['type'];
        
        if (in_array($file_type, $allowed)) {
            $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . basename($_FILES['profile_picture']['name']);
            $upload_path = __DIR__ . '/../../uploads/profile/' . $filename;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                $profile_picture = 'uploads/profile/' . $filename;
            }
        }
    }
    
    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $mysqli->prepare('INSERT INTO users (username, email, password, phone, profile_picture, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $stmt->bind_param('sssss', $username, $email, $password_hash, $phone, $profile_picture);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        
        $stmt->close();
        echo json_encode(['ok' => true, 'username' => $username, 'user_id' => $user_id]);
    } else {
        $stmt->close();
        echo json_encode(['ok' => false, 'error' => 'Registration failed']);
    }
    
} elseif ($action === 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        echo json_encode(['ok' => false, 'error' => 'Username and password are required']);
        exit;
    }
    
    $stmt = $mysqli->prepare('SELECT id, username, password FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $stmt->close();
        echo json_encode(['ok' => false, 'error' => 'Invalid username or password']);
        exit;
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        echo json_encode(['ok' => true, 'username' => $user['username'], 'user_id' => $user['id']]);
    } else {
        echo json_encode(['ok' => false, 'error' => 'Invalid username or password']);
    }
    
} elseif ($action === 'logout') {
    // Clear session
    $_SESSION = array();
    
    // Destroy session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    // Destroy session
    session_destroy();
    
    echo json_encode(['ok' => true, 'message' => 'Logged out successfully']);
    
} else {
    echo json_encode(['ok' => false, 'error' => 'Invalid action']);
}
?>
