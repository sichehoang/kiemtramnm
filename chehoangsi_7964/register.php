<?php
include 'app/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email']; // Thêm email vào
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Kiểm tra username hoặc email đã tồn tại chưa
    $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại!');</script>";
    } else {
        // Thêm user mới vào database
        $insert_sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Lỗi đăng ký!');</script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center text-primary">Đăng Ký Tài Khoản</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
    <div class="mb-3">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mật khẩu:</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Đăng Ký</button>
</form>

    <p class="mt-3 text-center">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</div>
</body>
</html>
