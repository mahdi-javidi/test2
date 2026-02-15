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
$text = trim($_POST['text'] ?? '');
$user_id = (int)$_SESSION['user_id'];

if ($post_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid post ID']);
    exit;
}

if (empty($text)) {
    echo json_encode(['success' => false, 'error' => 'Comment text is required']);
    exit;
}

if (strlen($text) > 500) {
    echo json_encode(['success' => false, 'error' => 'Comment is too long (max 500 characters)']);
    exit;
}

// Insert comment
$stmt = $mysqli->prepare('INSERT INTO comments (post_id, user_id, text, created_at) VALUES (?, ?, ?, NOW())');
$stmt->bind_param('iis', $post_id, $user_id, $text);

if (!$stmt->execute()) {
    $stmt->close();
    echo json_encode(['success' => false, 'error' => 'Failed to add comment']);
    exit;
}
$stmt->close();

// Get all comments for this post
$stmt = $mysqli->prepare('SELECT c.id, c.text, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at ASC');
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();

$comments = [];
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}
$stmt->close();

echo json_encode([
    'success' => true,
    'comments' => $comments
]);
?>
