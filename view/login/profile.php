<?php
session_start();
include '../../model/db.php'; // Bao gồm kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['username'];

// Truy vấn dữ liệu người dùng từ cơ sở dữ liệu
$sql = "SELECT username, email, created_at, role, password FROM users WHERE username = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi English - App học tiếng Anh miễn phí</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="/public/css/index.css">
    <style>
        /* Thêm style cho phần Profile */
        .profile-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 30px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 50px;
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.1);
        }

        .profile-info {
            flex-grow: 1;
        }

        .profile-info h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 18px;
            color: #555;
            margin: 5px 0;
        }

        .profile-info p i {
            color: #007bff;
            margin-right: 8px;
        }

        .edit-profile-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .edit-profile-btn:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        /* Đảm bảo responsive cho các màn hình nhỏ */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-avatar {
                margin-bottom: 20px;
            }

            .profile-info h1 {
                font-size: 24px;
            }

            .profile-info p {
                font-size: 16px;
            }

            .edit-profile-btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- Banner -->
    <nav class="navbar">
        <section class="banner">
            <img src="/public/img/index.jpg" alt="Banner" class="banner-image">
        </section>
        <div class="container-logo">
            <div class="logo">
                <a href="/index.php">English Learning</a>
            </div>
            <div class="login-success">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="user-menu">
                        <div class="welcome-message">
                            <p>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?> <i class="fas fa-chevron-down"></i></p>
                        </div>
                        <div class="user-menu-content">
                            <?php if ($_SESSION['username'] == 'thanhtan'): ?>
                                <!-- Thêm quyền quản trị viên cho Thanh Tân -->
                            <?php endif; ?>
                            <a href="/view/login/profile.php"><i class="fas fa-user"></i> Hồ sơ</a>
                            <a href="/view/login/progress.php"><i class="fas fa-chart-line"></i> Tiến độ học tập</a>
                            <a href="/view/admin/admin.php"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển quản trị</a>
                            <a href="/view/login/change_password.php"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                            <a href="/view/login/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="nav-buttons">
                        <a href="./view/login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        <a href="./view/register.php" class="btn"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><i class="fas fa-calendar"></i> Tham gia: <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
                <p><i class="fas fa-user-shield"></i> Vai trò: <?php echo htmlspecialchars($user['role']); ?></p>
                <p><i class="fas fa-lock"></i> Mật khẩu: <?php echo str_repeat('*', strlen($user['password'])); ?></p>
                <a href="update_profile.php" class="edit-profile-btn">Sửa hồ sơ</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Về chúng tôi</h3>
                <p>Hi English là nền tảng học tiếng Anh trực tuyến miễn phí, giúp người học cải thiện kỹ năng ngôn ngữ một cách hiệu quả.</p>
            </div>
            <div class="footer-section">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Khóa học</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kết nối với chúng tôi</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 Hi English. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
