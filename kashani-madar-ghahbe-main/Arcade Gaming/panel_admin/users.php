<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../include/db.php';
$connection = $mysqli;
if (isset($_GET['set_status']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $new_status = $_GET['set_status'] === 'active' ? 'active' : 'deactive';
    if ($id != ($_SESSION['user_id'] ?? -1)) {
        $stmt = $connection->prepare("UPDATE users_new SET status=? WHERE id=?");
        $stmt->bind_param('si', $new_status, $id);
        $stmt->execute();
        $stmt->close();
        echo "<script>window.location.href='?section=users';</script>";
        exit();
    }
}
$message = "";
if (isset($_POST['create_user_btn'])) {
    $username = $connection->real_escape_string($_POST['username']);
    $email = $connection->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $status = $_POST['status'] === 'deactive' ? 'deactive' : 'active';
    $check = $connection->query("SELECT 1 FROM users_new WHERE username='$username'");
    if ($check && $check->num_rows > 0) {
        $message = "خطا: این نام کاربری قبلاً ثبت شده است.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("INSERT INTO users_new (username, email, password_hash, status) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $username, $email, $hashed_password, $status);
        if ($stmt->execute()) {
            echo "<script>window.location.href='?section=users';</script>";
            exit();
        } else {
            $message = "خطا در دیتابیس.";
        }
        $stmt->close();
    }
}
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    if ($id != ($_SESSION['user_id'] ?? -1)) {
        $connection->query("DELETE FROM users_new WHERE id = $id");
    }
    echo "<script>window.location.href='?section=users';</script>";
    exit();
}
$users = $connection->query("SELECT id, username, email, status FROM users_new ORDER BY id DESC");
?>
<div class="container-fluid p-0">
    <div class="card mb-4 border-success">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">+ ایجاد حساب کاربری جدید</h5>
        </div>
        <div class="card-body">
            <?php if($message): ?><div class="alert alert-danger"><?= $message ?></div><?php endif; ?>
            <form method="post" class="row">
                <div class="col-md-3 mb-2"><input type="text" name="username" class="form-control" placeholder="نام کاربری" required></div>
                <div class="col-md-3 mb-2"><input type="email" name="email" class="form-control" placeholder="ایمیل" required></div>
                <div class="col-md-3 mb-2"><input type="password" name="password" class="form-control" placeholder="رمز عبور" required></div>
                <div class="col-md-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="active">فعال</option>
                        <option value="deactive">غیرفعال</option>
                    </select>
                </div>
                <div class="col-md-1"><button type="submit" name="create_user_btn" class="btn btn-success w-100">ثبت</button></div>
            </form>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header font-weight-bold">لیست کاربران</div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover text-center mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users) while($row = $users->fetch_assoc()): ?>
                    <tr style="<?= $row['status'] === 'deactive' ? 'background:#fff5f5;' : '' ?>">
                        <td><?= $row['id']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td>
                            <?php if($row['status'] === 'active'): ?>
                                <span class="text-success font-weight-bold">فعال</span>
                            <?php else: ?>
                                <span class="text-danger font-weight-bold">غیرفعال</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['id'] != ($_SESSION['user_id'] ?? -1)): ?>
                                <?php if($row['status'] === 'active'): ?>
                                    <a href="?section=users&set_status=deactive&id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">غیرفعال کردن</a>
                                <?php else: ?>
                                    <a href="?section=users&set_status=active&id=<?= $row['id']; ?>" class="btn btn-success btn-sm">فعال‌سازی</a>
                                <?php endif; ?>
                                <a href="?section=users&delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این کاربر مطمئن هستید؟')">حذف</a>
                            <?php else: ?>
                                <span class="text-muted small">غیرقابل تغییر</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
