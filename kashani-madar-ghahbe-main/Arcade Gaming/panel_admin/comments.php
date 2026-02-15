<?php
require_once __DIR__ . '/../include/db.php';
$connection = $mysqli;
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $connection->query("DELETE FROM comments WHERE id = $id");
    echo "<script>window.location.href='?section=comments';</script>";
    exit();
}
if (isset($_POST['update_btn'])) {
    $id = intval($_POST['edit_id']);
    $new_text = $connection->real_escape_string($_POST['text']);
    $connection->query("UPDATE comments SET text='$new_text' WHERE id=$id");
    echo "<script>window.location.href='?section=comments';</script>";
    exit();
}
$edit_row = null;
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    $res = $connection->query("SELECT * FROM comments WHERE id=$id");
    $edit_row = $res ? $res->fetch_assoc() : null;
}
$query = $connection->query("SELECT id, post_id, user_id, text, created_at FROM comments ORDER BY id DESC");
?>
<div class="container-fluid p-0">
    <?php if ($edit_row): ?>
    <div class="card mb-4 border-warning shadow-sm">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">ویرایش نظر شماره <?= $edit_row['id']; ?> (پست <?= $edit_row['post_id']; ?>)</h5>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="edit_id" value="<?= $edit_row['id']; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small text-muted">کاربر:</label>
                            <input type="text" class="form-control" value="<?= $edit_row['user_id']; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small text-muted">آیدی پست:</label>
                            <input type="text" class="form-control" value="<?= $edit_row['post_id']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="small text-muted">متن نظر:</label>
                    <textarea name="text" rows="3" class="form-control" required><?= $edit_row['text']; ?></textarea>
                </div>
                <div class="text-left">
                    <a href="?section=comments" class="btn btn-secondary">انصراف</a>
                    <button type="submit" name="update_btn" class="btn btn-success px-4">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">مدیریت نظرات سایت</h5>
        </div>
        <div class="card-body p-0">
            <?php if($query && $query->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th style="width: 10%;">آیدی پست</th>
                            <th style="width: 10%;">آیدی کاربر</th>
                            <th style="width: 45%;">متن نظر</th>
                            <th style="width: 15%;">تاریخ</th>
                            <th style="width: 10%;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $query->fetch_assoc()): ?>
                        <tr class="<?= (isset($_GET['edit_id']) && $_GET['edit_id'] == $row['id']) ? 'table-warning' : '' ?>">
                            <td><?= $row['id']; ?></td>
                            <td><span class="badge bg-dark text-white"># <?= $row['post_id']; ?></span></td>
                            <td class="fw-bold"><?= $row['user_id']; ?></td>
                            <td class="text-right small"><?= htmlspecialchars($row['text']); ?></td>
                            <td dir="ltr" class="small"><?= $row['created_at']; ?></td>
                            <td>
                                <a href="?section=comments&edit_id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> ویرایش
                                </a>
                                <a href="?section=comments&delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این نظر مطمئن هستید؟');">
                                    <i class="fas fa-trash"></i> حذف
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <div class="p-5 text-center text-muted">هیچ نظری برای نمایش وجود ندارد.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
