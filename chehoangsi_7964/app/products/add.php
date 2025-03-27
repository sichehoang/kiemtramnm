<?php
include '../config/database.php';
include '../shares/header.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Ma_NV = $_POST['Ma_NV'];
    $Ten_NV = $_POST['Ten_NV'];
    $Phai = $_POST['Phai'];
    $Noi_Sinh = $_POST['Noi_Sinh'];
    $Ma_Phong = $_POST['Ma_Phong'];
    $Luong = $_POST['Luong'];

    $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
            VALUES ('$Ma_NV', '$Ten_NV', '$Phai', '$Noi_Sinh', '$Ma_Phong', '$Luong')";

    if ($conn->query($sql) === TRUE) {
        header("Location: http://localhost/baitap6/index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhân Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center text-success">THÊM NHÂN VIÊN</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Mã Nhân Viên:</label>
            <input type="text" name="Ma_NV" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tên Nhân Viên:</label>
            <input type="text" name="Ten_NV" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Giới Tính:</label>
            <select name="Phai" class="form-control">
                <option value="NAM">NAM</option>
                <option value="NU">NỮ</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nơi Sinh:</label>
            <input type="text" name="Noi_Sinh" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phòng Ban:</label>
            <select name="Ma_Phong" class="form-control">
                <option value="QT">Quản Trị</option>
                <option value="TC">Tài Chính</option>
                <option value="KT">Kỹ Thuật</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Lương:</label>
            <input type="number" name="Luong" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Thêm</button>
    </form>
</div>
</body>
</html>
<?php include '../shares/footer.php'; ?>