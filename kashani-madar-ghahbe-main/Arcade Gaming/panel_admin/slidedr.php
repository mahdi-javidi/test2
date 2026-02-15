<?php
require_once __DIR__ . '/../include/db.php';
$connection = $mysqli;
if (!is_dir(__DIR__ . '/uploads')) { @mkdir(__DIR__ . '/uploads', 0777, true); }
if (isset($_POST['add'])) {
    $image = $_FILES['image']['name'] ?? '';
    if (!empty($image)) {
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/" . $image);
    }
    $stmt = $connection->prepare("INSERT INTO slider (slider_img) VALUES (?)");
    $stmt->bind_param('s', $image);
    $stmt->execute();
    $stmt->close();
    echo "<script>window.location.href='admin_dashboard.php?section=slider';</script>";
    exit();
}
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . "/uploads/" . $image);
        $stmt = $connection->prepare("UPDATE slider SET slider_img=? WHERE slider_id=?");
        $stmt->bind_param('si', $image, $id);
        $stmt->execute();
        $stmt->close();
    }
    echo "<script>window.location.href='admin_dashboard.php?section=slider';</script>";
    exit();
}
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $connection->query("DELETE FROM slider WHERE slider_id=$id");
    echo "<script>window.location.href='admin_dashboard.php?section=slider';</script>";
    exit();
}
$edit_data = ['slider_id'=>'', 'slider_img'=>''];
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $connection->query("SELECT slider_id, slider_img FROM slider WHERE slider_id=$id");
    $edit_data = $res ? $res->fetch_assoc() : $edit_data;
}
$sliders = $connection->query("SELECT slider_id, slider_img FROM slider ORDER BY slider_id DESC");
?>
<div class="p-2">
    <h3 class="mb-4">🛠 مدیریت اسلایدر اصلی</h3>
    <form action="admin_dashboard.php?section=slider" method="POST" enctype="multipart/form-data" class="card card-body border-0 shadow-sm mb-5">
        <input type="hidden" name="id" value="<?= $edit_data['slider_id'] ?>">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small fw-bold">انتخاب تصویر</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
        <?php if (!empty($edit_data['slider_img'])): ?>
            <div class="mb-3">
                <p class="small text-muted mb-1">تصویر فعلی:</p>
                <img src="panel_admin/uploads/<?= $edit_data['slider_img'] ?>" width="120" class="rounded border">
            </div>
        <?php endif; ?>
        <div class="d-flex gap-2">
            <?php if (isset($_GET['edit'])): ?>
                <button name="update" class="btn btn-warning flex-grow-1">بروزرسانی تغییرات</button>
                <a href="admin_dashboard.php?section=slider" class="btn btn-secondary">انصراف</a>
            <?php else: ?>
                <button name="add" class="btn btn-success w-100">افزودن اسلاید جدید</button>
            <?php endif; ?>
        </div>
    </form>
    <div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center mb-0">
            <thead class="table-dark">
                <tr>
                    <th>تصویر</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($sliders) while($row = $sliders->fetch_assoc()): ?>
                <tr>
                    <td>
                        <img src="panel_admin/uploads/<?= $row['slider_img'] ?>" width="80" class="rounded shadow-sm">
                    </td>
                    <td>
                        <a href="admin_dashboard.php?section=slider&edit=<?= $row['slider_id'] ?>" class="btn btn-sm btn-outline-info">ویرایش</a>
                        <a href="admin_dashboard.php?section=slider&delete=<?= $row['slider_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا از حذف این اسلاید مطمئن هستید؟')">حذف</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
