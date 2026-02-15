<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../include/db.php';

if (!$mysqli) {
    die('<div class="alert alert-danger">Database connection failed</div>');
}

$message = "";
$edit_post = null;

// Handle Create/Update Post
if (isset($_POST['save_post'])) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    if (empty($title) || empty($content)) {
        $message = '<div class="alert alert-danger">Title and content are required</div>';
    } else {
        // Handle image upload
        $image_url = $_POST['existing_image'] ?? '';
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed)) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $ext;
                $upload_path = __DIR__ . '/../uploads/' . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    // Delete old image if updating
                    if ($post_id > 0 && !empty($image_url) && file_exists(__DIR__ . '/../' . $image_url)) {
                        @unlink(__DIR__ . '/../' . $image_url);
                    }
                    $image_url = 'uploads/' . $filename;
                } else {
                    $message = '<div class="alert alert-warning">Failed to upload image, using existing image</div>';
                }
            } else {
                $message = '<div class="alert alert-warning">Invalid image type, using existing image</div>';
            }
        }
        
        if ($post_id > 0) {
            // Update existing post
            $stmt = $mysqli->prepare('UPDATE posts SET title=?, content=?, image_url=?, updated_at=NOW() WHERE id=?');
            $stmt->bind_param('sssi', $title, $content, $image_url, $post_id);
            
            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Post updated successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Failed to update post</div>';
            }
            $stmt->close();
        } else {
            // Create new post
            $user_id = $_SESSION['user_id'] ?? 1;
            $stmt = $mysqli->prepare('INSERT INTO posts (title, content, image_url, user_id, created_at) VALUES (?, ?, ?, ?, NOW())');
            $stmt->bind_param('sssi', $title, $content, $image_url, $user_id);
            
            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Post created successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Failed to create post</div>';
            }
            $stmt->close();
        }
    }
}

// Handle Delete Post
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    
    // Get image path before deleting
    $stmt = $mysqli->prepare('SELECT image_url FROM posts WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $image_path = __DIR__ . '/../' . $row['image_url'];
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
    }
    $stmt->close();
    
    // Delete post (likes and comments will be deleted automatically due to CASCADE)
    $stmt = $mysqli->prepare('DELETE FROM posts WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    
    echo "<script>window.location.href='?section=posts';</script>";
    exit();
}

// Handle Edit - Load post data
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    $stmt = $mysqli->prepare('SELECT * FROM posts WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_post = $result->fetch_assoc();
    $stmt->close();
}

// Get all posts with stats
$query = "SELECT p.*, 
          u.username,
          (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count,
          (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comment_count
          FROM posts p
          LEFT JOIN users u ON p.user_id = u.id
          ORDER BY p.created_at DESC";
$posts = $mysqli->query($query);
?>

<div class="container-fluid p-0">
    <?php if ($message): ?>
        <?= $message ?>
    <?php endif; ?>
    
    <!-- Create/Edit Post Form -->
    <div class="card mb-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-<?= $edit_post ? 'edit' : 'plus' ?>"></i> 
                <?= $edit_post ? 'Edit Post' : 'Create New Post' ?>
            </h5>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <?php if ($edit_post): ?>
                    <input type="hidden" name="post_id" value="<?= $edit_post['id'] ?>">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($edit_post['image_url']) ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Post Title *</label>
                        <input type="text" name="title" class="form-control" 
                               placeholder="Enter post title" 
                               value="<?= $edit_post ? htmlspecialchars($edit_post['title']) : '' ?>" 
                               required>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Content *</label>
                        <textarea name="content" class="form-control" rows="5" 
                                  placeholder="Enter post content" 
                                  required><?= $edit_post ? htmlspecialchars($edit_post['content']) : '' ?></textarea>
                        <small class="text-muted">Recommended: 100-500 characters</small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Post Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Recommended: 1200x675px (16:9 ratio), Max 5MB</small>
                        <?php if ($edit_post && $edit_post['image_url']): ?>
                            <div class="mt-2">
                                <img src="../<?= htmlspecialchars($edit_post['image_url']) ?>" 
                                     alt="Current image" 
                                     style="max-width: 200px; max-height: 150px; border-radius: 8px;">
                                <p class="text-muted small mt-1">Current image (leave empty to keep)</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-12">
                        <button type="submit" name="save_post" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $edit_post ? 'Update Post' : 'Create Post' ?>
                        </button>
                        <?php if ($edit_post): ?>
                            <a href="?section=posts" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Posts List -->
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="font-weight-bold">
                <i class="fas fa-list"></i> All Posts
            </span>
            <span class="badge bg-primary">
                <?= $posts ? $posts->num_rows : 0 ?> Total
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 100px;">Image</th>
                            <th>Title</th>
                            <th style="width: 200px;">Content Preview</th>
                            <th style="width: 120px;">Author</th>
                            <th style="width: 80px;">
                                <i class="fas fa-heart text-danger"></i> Likes
                            </th>
                            <th style="width: 80px;">
                                <i class="fas fa-comment text-primary"></i> Comments
                            </th>
                            <th style="width: 140px;">Created</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($posts && $posts->num_rows > 0): ?>
                            <?php while($post = $posts->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $post['id'] ?></td>
                                <td>
                                    <?php if ($post['image_url']): ?>
                                        <img src="../<?= htmlspecialchars($post['image_url']) ?>" 
                                             alt="Post image" 
                                             style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    <?php else: ?>
                                        <div style="width: 80px; height: 60px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($post['title']) ?></strong>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= htmlspecialchars(mb_substr($post['content'], 0, 50)) ?>...
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= htmlspecialchars($post['username'] ?? 'Unknown') ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger">
                                        <?= $post['like_count'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        <?= $post['comment_count'] ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                        <br>
                                        <?= date('H:i', strtotime($post['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="?section=posts&edit_id=<?= $post['id'] ?>" 
                                           class="btn btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?section=posts&delete_id=<?= $post['id'] ?>" 
                                           class="btn btn-danger" 
                                           onclick="return confirm('Are you sure you want to delete this post? This will also delete all likes and comments.')"
                                           title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    No posts found. Create your first post above!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-file-alt"></i> Total Posts
                    </h5>
                    <h2><?= $posts ? $posts->num_rows : 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-heart"></i> Total Likes
                    </h5>
                    <h2>
                        <?php
                        $result = $mysqli->query("SELECT COUNT(*) as total FROM likes");
                        echo $result ? $result->fetch_assoc()['total'] : 0;
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-comments"></i> Total Comments
                    </h5>
                    <h2>
                        <?php
                        $result = $mysqli->query("SELECT COUNT(*) as total FROM comments");
                        echo $result ? $result->fetch_assoc()['total'] : 0;
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chart-line"></i> Avg Engagement
                    </h5>
                    <h2>
                        <?php
                        $total_posts = $posts ? $posts->num_rows : 1;
                        $total_likes = $mysqli->query("SELECT COUNT(*) as total FROM likes")->fetch_assoc()['total'];
                        $total_comments = $mysqli->query("SELECT COUNT(*) as total FROM comments")->fetch_assoc()['total'];
                        $avg = round(($total_likes + $total_comments) / max($total_posts, 1), 1);
                        echo $avg;
                        ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    overflow: hidden;
}
.table th {
    font-weight: 600;
    font-size: 0.9rem;
}
.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
