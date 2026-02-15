<?php
require_once __DIR__ . '/../include/db.php';
$connection = $mysqli;
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $connection->query("DELETE FROM posts_new WHERE id='$id'");
    echo "<script>
        alert('مورد با موفقیت حذف شد ✅');
        window.location.href='?section=products';
    </script>";
    exit();
}
$message = "";
if (isset($_POST['save_item'])) {
    $id = $_POST['item_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url'];
    if ($id) {
        $stmt = $connection->prepare("UPDATE posts_new SET title=?, content=?, image_url=? WHERE id=?");
        $stmt->bind_param('sssi', $title, $content, $image_url, $id);
        $message = $stmt->execute() ? "آیتم ویرایش شد ✅" : "خطا";
        $stmt->close();
    } else {
        $stmt = $connection->prepare("INSERT INTO posts_new (title, content, image_url) VALUES (?,?,?)");
        $stmt->bind_param('sss', $title, $content, $image_url);
        $message = $stmt->execute() ? "آیتم جدید اضافه شد ✅" : "خطا";
        $stmt->close();
    }
}
$items = $connection->query("SELECT id, title, image_url, created_at, content FROM posts_new ORDER BY id DESC");
?>
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-gray-800">مدیریت محتوا</h2>
    </div>
    <?php if($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">افزودن یا ویرایش مورد</h6>
        </div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <input type="hidden" name="item_id" id="itemId">
                <div class="col-md-4">
                    <label class="form-label small text-muted">عنوان</label>
                    <input type="text" name="title" id="itemTitle" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">آدرس تصویر</label>
                    <input type="text" name="image_url" id="itemImage" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label small text-muted">متن</label>
                    <textarea name="content" id="itemContent" rows="3" class="form-control"></textarea>
                </div>
                <div class="col-12 mt-3 d-flex gap-2">
                    <button type="submit" name="save_item" class="btn btn-success flex-grow-1">ذخیره اطلاعات</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>عنوان</th>
                            <th>تصویر</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($items) while($row = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td class="fw-bold"><?= $row['title'] ?></td>
                            <td><?= htmlspecialchars($row['image_url']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1" onclick='editItem(<?= json_encode($row) ?>)'>
                                    <i class="fas fa-edit"></i> ویرایش
                                </button>
                                <a href="?section=products&delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این مورد مطمئن هستید؟')">
                                    <i class="fas fa-trash"></i> حذف
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function editItem(data){
    document.getElementById('itemId').value = data.id;
    document.getElementById('itemTitle').value = data.title;
    document.getElementById('itemImage').value = data.image_url;
    document.getElementById('itemContent').value = data.content;
    window.scrollTo({top: 0, behavior: 'smooth'});
}
</script>
