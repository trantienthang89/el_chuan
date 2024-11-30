<?php
session_start();
include '../model/db.php';
include '../model/Course.php';  // Bao gồm model khóa học
include '../model/Cart.php';    // Bao gồm model giỏ hàng

// Lấy danh sách khóa học từ database
$courses = Course::getAllCourses(); 

// Xử lý thêm khóa học vào giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $courseId = $_GET['id'];
    Cart::addItem($courseId);
    header('Location: shop.php'); // Chuyển hướng lại trang shop sau khi thêm khóa học vào giỏ
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi English - Shop Khóa Học</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/index.css">
</head>

<body>
    <!-- Banner -->
    <nav class="navbar">
        <section class="banner">
            <img src="../public/img/index.jpg" alt="Banner" class="banner-image">
        </section>
        <div class="container-logo">
            <div class="logo">
                <a href="../index.php">English Learning</a>
            </div>
            <div class="login-success">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="user-menu">
                        <div class="welcome-message">
                            <p>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?> <i class="fas fa-chevron-down"></i></p>
                        </div>
                        <div class="user-menu-content">
                            <?php if ($_SESSION['username'] == 'thanhtan'): ?>
                                <!-- Thêm quyền quản trị viên cho thanh tân -->
                            <?php endif; ?>
                            <a href="../view/login/profile.php"><i class="fas fa-user"></i> Hồ sơ</a>
                            <a href="../view/login/progress.php"><i class="fas fa-chart-line"></i> Tiến độ học tập</a>
                            <a href="../view/admin/admin.php"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển quản trị</a>
                            <a href="../view/login/change_password.php"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                            <a href="../view/login/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="nav-buttons">
                        <a href="../view/login.php" class="btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        <a href="../view/register.php" class="btn"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Section Navigation Menu -->
    <div class="nav-menu">
        <div class="container">
            <button class="nav-btn " data-section="grammar">
                <i class="fas fa-book"></i> GRAMMAR LESSONS
            </button>
            <button class="nav-btn" data-section="practice">
                <i class="fas fa-tasks"></i> PRACTICE TESTS
            </button>
            <button class="nav-btn" data-section="conversation">
                <i class="fas fa-comments"></i> CONVERSATIONS
            </button>
            <button class="nav-btn premium-btn active" data-section="premium">
                <a href=""><i class="fas fa-crown"></i> PREMIUM COURSES</a>
            </button>
        </div>
    </div>

    <!-- Main Content: Hiển thị danh sách khóa học -->
    <div class="container main-content">
        <h2>Danh Sách Khóa Học</h2>
        <div class="course-list">
            <?php foreach ($courses as $course): ?>
                <div class="course-item">
                    <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                    <p>Price: <?php echo number_format($course['price']); ?> VNĐ</p>
                    <p>Features: <?php echo htmlspecialchars(implode(", ", json_decode($course['features']))); ?></p>
                    <a href="shop.php?action=add&id=<?php echo $course['id']; ?>" class="btn-add-to-cart">Thêm vào giỏ</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Giỏ hàng -->
    <div class="cart-summary">
        <h3>Giỏ Hàng</h3>
        <?php
        $cartItems = Cart::getCartItems();
        if (empty($cartItems)): ?>
            <p>Giỏ hàng của bạn hiện chưa có sản phẩm nào.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li><?php echo htmlspecialchars($item['name']); ?> - <?php echo number_format($item['price']); ?> VNĐ</li>
                <?php endforeach; ?>
            </ul>
            <a href="checkout.php" class="btn">Thanh toán</a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include '../view/page/footer.php'; ?>
</body>
</html>
