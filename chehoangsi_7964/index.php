<?php
include 'app/config/database.php';
include 'app/shares/header.php'; 
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản Lý Nhân Viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center text-primary fw-bold">THÔNG TIN NHÂN VIÊN</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="app/products/add.php" class="btn btn-success">➕ THÊM NHÂN VIÊN</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center align-middle">
            <thead>
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
                        <a href="app/products/edit.php?id=<?= $row['Ma_NV'] ?>" class="btn btn-primary btn-sm">✏️ Sửa</a>
                        <a href="app/products/delete.php?id=<?= $row['Ma_NV'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">🗑️ Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Hiển thị phân trang -->
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>">« Trước</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>">Sau »</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'app/shares/footer.php'; ?>
<?php $conn->close(); ?>
