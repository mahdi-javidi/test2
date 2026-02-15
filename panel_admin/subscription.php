<?php
require_once __DIR__ . '/../include/db.php';
$connection = $mysqli;

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $connection->query("DELETE FROM subscriptions WHERE id='$id'");
    echo "<script>
        alert('اشتراک با موفقیت حذف شد ✅');
        window.location.href='?section=subscriptions';
    </script>";
    exit();
}

$message = "";
$edit_data = ['id'=>'', 'title'=>'', 'duration_months'=>'', 'price'=>'', 'discount_percentage'=>'', 'discount_end_date'=>'', 'description'=>'', 'is_active'=>1];

// Handle save/update
if (isset($_POST['save_subscription'])) {
    $id = intval($_POST['sub_id']);
    $title = $_POST['title'];
    $duration_months = intval($_POST['duration_months']);
    $price = floatval($_POST['price']);
    $discount_percentage = intval($_POST['discount_percentage']);
    $discount_end_date = !empty($_POST['discount_end_date']) ? $_POST['discount_end_date'] : NULL;
    $description = $_POST['description'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if ($id > 0) {
        $stmt = $connection->prepare("UPDATE subscriptions SET title=?, duration_months=?, price=?, discount_percentage=?, discount_end_date=?, description=?, is_active=? WHERE id=?");
        $stmt->bind_param('sidissii', $title, $duration_months, $price, $discount_percentage, $discount_end_date, $description, $is_active, $id);
        $message = $stmt->execute() ? "اشتراک ویرایش شد ✅" : "خطا در ویرایش";
        $stmt->close();
    } else {
        $stmt = $connection->prepare("INSERT INTO subscriptions (title, duration_months, price, discount_percentage, discount_end_date, description, is_active) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('sidissi', $title, $duration_months, $price, $discount_percentage, $discount_end_date, $description, $is_active);
        $message = $stmt->execute() ? "اشتراک جدید اضافه شد ✅" : "خطا در افزودن";
        $stmt->close();
    }
}

// Handle edit
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $connection->query("SELECT * FROM subscriptions WHERE id=$id");
    if ($res && $row = $res->fetch_assoc()) {
        $edit_data = $row;
    }
}

$subscriptions = $connection->query("SELECT * FROM subscriptions ORDER BY duration_months ASC");
?>
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-gray-800">مدیریت اشتراک‌ها</h2>
    </div>
    
    <?php if($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h6 class="m-0 font-weight-bold"><?= $edit_data['id'] ? 'ویرایش اشتراک' : 'افزودن اشتراک جدید' ?></h6>
        </div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <input type="hidden" name="sub_id" value="<?= $edit_data['id'] ?>">
                
                <div class="col-md-6">
                    <label class="form-label small text-muted">عنوان اشتراک</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($edit_data['title']) ?>" required>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-muted">مدت زمان (ماه)</label>
                    <input type="number" name="duration_months" class="form-control" value="<?= $edit_data['duration_months'] ?>" min="1" required>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label small text-muted">قیمت ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $edit_data['price'] ?>" min="0" required>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label small text-muted">درصد تخفیف (%)</label>
                    <input type="number" name="discount_percentage" class="form-control" value="<?= $edit_data['discount_percentage'] ?>" min="0" max="100">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label small text-muted">تاریخ پایان تخفیف</label>
                    <input type="datetime-local" name="discount_end_date" class="form-control" value="<?= $edit_data['discount_end_date'] ? date('Y-m-d\TH:i', strtotime($edit_data['discount_end_date'])) : '' ?>">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label small text-muted">وضعیت</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" <?= $edit_data['is_active'] ? 'checked' : '' ?>>
                        <label class="form-check-label">فعال</label>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <label class="form-label small text-muted">توضیحات</label>
                    <textarea name="description" rows="3" class="form-control"><?= htmlspecialchars($edit_data['description']) ?></textarea>
                </div>
                
                <div class="col-12 mt-3 d-flex gap-2">
                    <button type="submit" name="save_subscription" class="btn btn-success flex-grow-1">
                        <?= $edit_data['id'] ? 'بروزرسانی اشتراک' : 'افزودن اشتراک' ?>
                    </button>
                    <?php if($edit_data['id']): ?>
                        <a href="?section=subscriptions" class="btn btn-secondary">انصراف</a>
                    <?php endif; ?>
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
                            <th>مدت (ماه)</th>
                            <th>قیمت</th>
                            <th>تخفیف</th>
                            <th>تاریخ پایان تخفیف</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($subscriptions) while($row = $subscriptions->fetch_assoc()): 
                            $final_price = $row['price'];
                            $has_discount = false;
                            if ($row['discount_percentage'] > 0 && (!$row['discount_end_date'] || strtotime($row['discount_end_date']) > time())) {
                                $final_price = $row['price'] * (1 - $row['discount_percentage'] / 100);
                                $has_discount = true;
                            }
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= $row['duration_months'] ?> ماه</td>
                            <td>
                                <?php if($has_discount): ?>
                                    <span class="text-decoration-line-through text-muted">$<?= number_format($row['price'], 2) ?></span>
                                    <span class="text-success fw-bold">$<?= number_format($final_price, 2) ?></span>
                                <?php else: ?>
                                    $<?= number_format($row['price'], 2) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row['discount_percentage'] > 0): ?>
                                    <span class="badge bg-danger"><?= $row['discount_percentage'] ?>%</span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $row['discount_end_date'] ? date('Y-m-d H:i', strtotime($row['discount_end_date'])) : '-' ?>
                            </td>
                            <td>
                                <?php if($row['is_active']): ?>
                                    <span class="badge bg-success">فعال</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">غیرفعال</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?section=subscriptions&edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i> ویرایش
                                </a>
                                <a href="?section=subscriptions&delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این اشتراک مطمئن هستید؟')">
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
