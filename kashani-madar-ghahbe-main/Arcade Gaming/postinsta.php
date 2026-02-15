<?php
require_once __DIR__ . '/include/db.php';

$limit = 3;
$posts = [];

if ($mysqli) {
    $stmt = $mysqli->prepare('SELECT id, title, content, image_url FROM posts ORDER BY created_at DESC LIMIT ?');
    if ($stmt) {
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) {
            $posts[] = $row;
        }
        $stmt->close();
    }
}

function get_like_count($mysqli, $pid) {
    if (!$mysqli) return 0;
    $s = $mysqli->prepare('SELECT COUNT(*) as c FROM likes WHERE post_id=?');
    if (!$s) return 0;
    $s->bind_param('i', $pid);
    $s->execute();
    $r = $s->get_result()->fetch_assoc();
    $s->close();
    return (int)$r['c'];
}

function user_liked($mysqli, $pid, $uid) {
    if (!$mysqli) return false;
    $s = $mysqli->prepare('SELECT 1 FROM likes WHERE post_id=? AND user_id=?');
    if (!$s) return false;
    $s->bind_param('ii', $pid, $uid);
    $s->execute();
    $s->store_result();
    $ok = $s->num_rows > 0;
    $s->close();
    return $ok;
}

function get_comments($mysqli, $pid) {
    if (!$mysqli) return [];
    $s = $mysqli->prepare('SELECT c.id, c.text, u.username FROM comments c JOIN users u ON c.user_id=u.id WHERE c.post_id=? ORDER BY c.created_at ASC');
    if (!$s) return [];
    $s->bind_param('i', $pid);
    $s->execute();
    $r = $s->get_result();
    $out = [];
    while ($row = $r->fetch_assoc()) {
        $out[] = $row;
    }
    $s->close();
    return $out;
}
?>
<section class="post-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Community Posts</h2>
            <p class="section-subtitle">Latest updates from our community</p>
        </div>
        <div class="row g-4">
            <?php foreach ($posts as $p): ?>
                <?php
                $pid = (int)$p['id'];
                $like_count = get_like_count($mysqli, $pid);
                $liked = isset($_SESSION['user_id']) ? user_liked($mysqli, $pid, (int)$_SESSION['user_id']) : false;
                $comments = get_comments($mysqli, $pid);
                $content = $p['content'];
                $content_len = mb_strlen($content);
                ?>
                <div class="col-12 col-md-4">
                    <div class="post-card border rounded shadow-sm p-3 h-100" data-post-id="<?php echo $pid; ?>">
                        <img class="post-image w-100" src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="post">
                        <div class="card-body p-0 mt-3">
                            <h5 class="post-title"><?php echo htmlspecialchars($p['title']); ?></h5>
                            <p class="mb-2"><?php echo htmlspecialchars($content); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="char-limit"><span><?php echo $content_len; ?></span> chars</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button class="btn btn-outline-light btn-sm like-btn <?php echo $liked ? 'active' : ''; ?>">
                                <i class="fa<?php echo $liked ? 's' : 'r'; ?> fa-heart me-1"></i>
                                <span class="like-count"><?php echo $like_count; ?></span>
                            </button>
                        </div>
                        <div class="comment-list mt-3">
                            <?php if (empty($comments)): ?>
                                <div class="text-muted">No comments</div>
                            <?php else: ?>
                                <?php foreach ($comments as $c): ?>
                                    <div class="comment-item">
                                        <div>
                                            <span class="comment-user">@<?php echo htmlspecialchars($c['username']); ?></span>
                                            <span class="comment-text"><?php echo htmlspecialchars($c['text']); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="post-actions mt-3">
                            <input type="text" class="form-control form-control-sm comment-input" placeholder="Write a comment">
                            <button class="btn btn-primary btn-sm submit-comment">Submit</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
document.querySelectorAll('.post-card').forEach(function(card) {
    var postId = card.getAttribute('data-post-id');
    var likeBtn = card.querySelector('.like-btn');
    var likeIcon = likeBtn ? likeBtn.querySelector('i') : null;
    var likeCountEl = likeBtn ? likeBtn.querySelector('.like-count') : null;
    var commentInput = card.querySelector('.comment-input');
    var submitBtn = card.querySelector('.submit-comment');
    var commentList = card.querySelector('.comment-list');
    
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            fetch('php_admin/api/like.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({post_id: postId})
            })
            .then(function(r){
                if (r.status === 401) {
                    var lm = new bootstrap.Modal(document.getElementById('loginModal'));
                    lm.show();
                    return null;
                }
                return r.json();
            })
            .then(function(d){
                if (d && d.success && likeCountEl && likeIcon) {
                    likeCountEl.textContent = d.like_count;
                    likeBtn.classList.toggle('active', d.liked);
                    likeIcon.className = d.liked ? 'fas fa-heart me-1' : 'far fa-heart me-1';
                }
            })
            .catch(function(err) {
                console.error('Like error:', err);
            });
        });
    }
    
    if (submitBtn && commentInput) {
        submitBtn.addEventListener('click', function() {
            var text = commentInput.value.trim();
            if (!text) return;
            
            if (window.IS_LOGGED_IN === false) {
                var lm = new bootstrap.Modal(document.getElementById('loginModal'));
                lm.show();
                return;
            }
            
            fetch('php_admin/api/comment.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({post_id: postId, text: text})
            })
            .then(function(r){
                if (r.status === 401) {
                    var lm = new bootstrap.Modal(document.getElementById('loginModal'));
                    lm.show();
                    return null;
                }
                return r.json();
            })
            .then(function(d){
                if (d && d.success && commentList) {
                    commentList.innerHTML = '';
                    if (!d.comments || d.comments.length === 0) {
                        var empty = document.createElement('div');
                        empty.className = 'text-muted';
                        empty.textContent = 'No comments';
                        commentList.appendChild(empty);
                    } else {
                        d.comments.forEach(function(c){
                            var item = document.createElement('div');
                            item.className = 'comment-item';
                            var inner = document.createElement('div');
                            var user = document.createElement('span');
                            user.className = 'comment-user';
                            user.textContent = '@' + c.username;
                            var sep = document.createTextNode(' ');
                            var text = document.createElement('span');
                            text.className = 'comment-text';
                            text.textContent = c.text;
                            inner.appendChild(user);
                            inner.appendChild(sep);
                            inner.appendChild(text);
                            item.appendChild(inner);
                            commentList.appendChild(item);
                        });
                    }
                    commentInput.value = '';
                }
            })
            .catch(function(err) {
                console.error('Comment error:', err);
            });
        });
        
        // Allow Enter key to submit comment
        commentInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                submitBtn.click();
            }
        });
    }
});
</script>
