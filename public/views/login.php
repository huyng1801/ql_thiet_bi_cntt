<?php
session_start();
include '../dao/user_dao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_nguoi_dung = $_POST['ten_nguoi_dung'];
    $mat_khau = $_POST['mat_khau'];

    $user = getUserByUsername($ten_nguoi_dung);
    if ($user && $user['mat_khau'] === $mat_khau) { // Verify using MD5
        $_SESSION['ten_nguoi_dung'] = $user['ten_nguoi_dung'];
        header("Location: thiet_bi.php");
        exit();
    } else {
        $error = "Tên người dùng hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
        }
        .login-container .form-group {
            margin-bottom: 20px;
        }
        .login-container .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .login-container .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .login-container .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2 class="text-center">Đăng Nhập</h2>
    <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post" action="login.php">
        <div class="form-group">
            <label for="ten_nguoi_dung">Tên Người Dùng</label>
            <input type="text" class="form-control" id="ten_nguoi_dung" name="ten_nguoi_dung" required>
        </div>
        <div class="form-group">
            <label for="mat_khau">Mật Khẩu</label>
            <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
    </form>
</div>
</body>
</html>
