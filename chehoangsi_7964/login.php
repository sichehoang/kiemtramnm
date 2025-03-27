<?php
session_start();
include 'app/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Không mã hóa bằng md5

    // Sử dụng Prepared Statements để tránh SQL Injection
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // So sánh mật khẩu với password_hash trong database
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: /baitap6/index.php");
            exit();
        } else {
            echo "<script>alert('Sai mật khẩu!');</script>";
        }
    } else {
        echo "<script>alert('Sai tài khoản hoặc mật khẩu!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center text-primary">Đăng Nhập</h2>
    <form method="POST" class="p-4 border rounded shadow bg-white">
        <div class="mb-3">
            <label class="form-label">Tên đăng nhập:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mật khẩu:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
    </form>
    
    <p class="mt-3 text-center">Chưa có tài khoản? 
        <a href="register.php" class="btn btn-success">Đăng Ký</a>
    </p>
</div>
</body>
</html>
