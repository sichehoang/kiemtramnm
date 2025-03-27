<?php
include '../config/database.php';
include '../shares/header.php'; 
// Lấy danh sách phòng ban
$sqlPhong = "SELECT Ma_Phong, Ten_Phong FROM PHONGBAN";
$resultPhong = $conn->query($sqlPhong);

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM NHANVIEN WHERE Ma_NV = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy nhân viên.";
        exit();
    }
} else {
    echo "Thiếu ID nhân viên.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenNV = mysqli_real_escape_string($conn, $_POST['Ten_NV']);
    $phai = mysqli_real_escape_string($conn, $_POST['Phai']);
    $noiSinh = mysqli_real_escape_string($conn, $_POST['Noi_Sinh']);
    $maPhong = mysqli_real_escape_string($conn, $_POST['Ma_Phong']);
    $luong = mysqli_real_escape_string($conn, $_POST['Luong']);

    $updateSql = "UPDATE NHANVIEN SET Ten_NV='$tenNV', Phai='$phai', Noi_Sinh='$noiSinh', 
                  Ma_Phong='$maPhong', Luong='$luong' WHERE Ma_NV='$id'";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: http://localhost/baitap6/index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Nhân Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center text-warning">CHỈNH SỬA NHÂN VIÊN</h2>
    <form method="POST">
        <label>Tên Nhân Viên:</label>
        <input type="text" name="Ten_NV" class="form-control" value="<?= htmlspecialchars($row['Ten_NV']) ?>" required>

        <label>Giới Tính:</label>
        <select name="Phai" class="form-control">
            <option value="NAM" <?= ($row['Phai'] == 'NAM') ? 'selected' : '' ?>>Nam</option>
            <option value="NỮ" <?= ($row['Phai'] == 'NỮ') ? 'selected' : '' ?>>Nữ</option>
        </select>

        <label>Nơi Sinh:</label>
        <input type="text" name="Noi_Sinh" class="form-control" value="<?= htmlspecialchars($row['Noi_Sinh']) ?>" required>

        <label>Phòng Ban:</label>
        <select name="Ma_Phong" class="form-control">
            <?php
            if ($resultPhong->num_rows > 0) {
                while ($phong = $resultPhong->fetch_assoc()) {
                    $selected = ($row['Ma_Phong'] == $phong['Ma_Phong']) ? 'selected' : '';
                    echo "<option value='{$phong['Ma_Phong']}' $selected>{$phong['Ten_Phong']}</option>";
                }
            }
            ?>
        </select>

        <label>Lương:</label>
        <input type="number" name="Luong" class="form-control" value="<?= htmlspecialchars($row['Luong']) ?>" required>

        <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
        <a href="http://localhost/baitap6/index.php" class="btn btn-secondary mt-3">Quay Lại</a>
    </form>
</div>
</body>
</html>
<?php include '../shares/footer.php'; ?>