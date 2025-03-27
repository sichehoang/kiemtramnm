<?php
include 'app/config/database.php';

// Cấu hình phân trang
$limit = 5; // Số nhân viên mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
$offset = ($page - 1) * $limit; // Vị trí bắt đầu lấy dữ liệu

// Truy vấn dữ liệu có phân trang
$sql = "SELECT NHANVIEN.*, PHONGBAN.Ten_Phong FROM NHANVIEN 
        JOIN PHONGBAN ON NHANVIEN.Ma_Phong = PHONGBAN.Ma_Phong 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Đếm tổng số nhân viên
$totalSql = "SELECT COUNT(*) AS total FROM NHANVIEN";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalEmployees = $totalRow['total'];

// Tính tổng số trang
$totalPages = ceil($totalEmployees / $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Nhân Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center text-primary">THÔNG TIN NHÂN VIÊN</h2>
    <a href="app/products/add.php" class="btn btn-success mb-3">THÊM NHÂN VIÊN</a>
    <table class="table table-bordered text-center">
        <thead class="table-danger">
            <tr>
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Giới Tính</th>
                <th>Nơi Sinh</th>
                <th>Phòng Ban</th>
                <th>Lương</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Ma_NV'] ?></td>
                <td><?= $row['Ten_NV'] ?></td>
                <td>
                    <?php 
                        $gender = trim(strtoupper($row['Phai']));
                        $genderImage = ($gender == 'NAM') ? 'man.png' : 'woman.png'; 
                    ?>
                    <img src="assets/images/<?= $genderImage ?>" alt="<?= $row['Phai'] ?>" width="30">
                </td>
                <td><?= $row['Noi_Sinh'] ?></td>
                <td><?= $row['Ten_Phong'] ?></td>
                <td><?= number_format($row['Luong']) ?> VNĐ</td>
                <td>
                    <a href="app/products/edit.php?id=<?= $row['Ma_NV'] ?>" class="btn btn-primary">✏️</a>
                    <a href="app/products/delete.php?id=<?= $row['Ma_NV'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">🗑️</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Hiển thị phân trang -->
    <div class="d-flex justify-content-center mt-3">
        <nav>
            <ul class="pagination">
                <!-- Nút Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">« Trước</a>
                </li>

                <!-- Các số trang -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Nút Next -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Sau »</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
