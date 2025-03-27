<?php
$servername = "localhost";
$username = "root";  // Thay bằng tài khoản MySQL của bạn
$password = "";  // Nếu có mật khẩu, hãy nhập vào đây
$dbname = "QL_NhanSu";

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
