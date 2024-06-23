<?php
session_start();
if (!isset($_SESSION['ten_nguoi_dung'])){
    header("Location: login.php");
    exit();
}
$ten_nguoi_dung = $_SESSION['ten_nguoi_dung'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .sidebar {
            background-color: #007bff;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 16.6667%; /* This is 2/12 of the Bootstrap grid */
            padding-top: 56px; /* Adjust if your header height is different */
        }
        .nav-link {
            color: white;
            font-weight: bold;
            font-size: 1.1em;
            text-transform: uppercase;
        }
        .nav-link:hover {
            color: #d1ecf1;
        }
        .nav-link i {
            margin-right: 8px;
        }
        .main-content {
            margin-left: 16.6667%; /* This is 2/12 of the Bootstrap grid */
            
        }
        .title {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column d-flex align-content-center mb-5">
                    <li class="nav-item">
                        <span class="nav-link">Xin chào, <?php echo $ten_nguoi_dung; ?></span>
                    </li>
                    <li class="nav-item text-center">
                        <a href="logout.php" class="btn btn-outline-light btn-sm">Đăng xuất</a>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="quan_huyen.php">
                            <i class="fas fa-map-marker-alt"></i> Quận Huyện
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="buu_cuc.php">
                            <i class="fas fa-envelope"></i> Bưu Cục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="danh_muc_thiet_bi.php">
                            <i class="fas fa-list"></i> Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="thiet_bi.php">
                            <i class="fas fa-desktop"></i> Thiết bị
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">
                            <i class="fas fa-user"></i> Người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nhap.php">
                            <i class="fas fa-arrow-down"></i> Nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="xuat.php">
                            <i class="fas fa-arrow-up"></i> Xuất
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cap_thiet_bi.php">
                            <i class="fas fa-tools"></i> Cấp thiết bị
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 main-content">
