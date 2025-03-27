<?php
include '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Tránh lỗi SQL Injection bằng cách sử dụng mysqli_real_escape_string
    $id = mysqli_real_escape_string($conn, $id);

    // Thêm dấu nháy đơn quanh giá trị
    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng về trang chính
        header("Location: http://localhost/baitap6/index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
