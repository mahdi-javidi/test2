<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../include/db.php';

if (!$mysqli) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not authenticated']);
    exit;
}

$post_id = (int)($_POST['post_id'] ?? 0);
$user_id = (int)$_SESSION['user_id'];

if ($post_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid post ID']);
    exit;
}

// Check if user already liked
$stmt = $mysqli->prepare('SELECT id FROM likes WHERE post_id = ? AND user_id = ?');
$stmt->bind_param('ii', $post_id, $user_id);
$stmt->execute();
$stmt->store_result();
$already_liked = $stmt->num_rows > 0;
$stmt->close();

if ($already_liked) {
    // Unlike
    $stmt = $mysqli->prepare('DELETE FROM likes WHERE post_id = ? AND user_id = ?');
    $stmt->bind_param('ii', $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
    $liked = false;
} else {
    // Like
    $stmt = $mysqli->prepare('INSERT INTO likes (post_id, user_id, created_at) VALUES (?, ?, NOW())');
    $stmt->bind_param('ii', $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
    $liked = true;
}

// Get updated like count
$stmt = $mysqli->prepare('SELECT COUNT(*) as count FROM likes WHERE post_id = ?');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$like_count = (int)$row['count'];
$stmt->close();

echo json_encode([
    'success' => true,
    'liked' => $liked,
    'like_count' => $like_count
]);
?>
