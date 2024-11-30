<?php session_start();
include './model/db.php';

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hi English - App học tiếng Anh miễn phí</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/css/index.css">
</head>

<body>
    <!-- Banner -->
    <nav class="navbar">
        <section class="banner">
            <img src="./public/img/index.jpg" alt="Banner" class="banner-image">
        </section>
        <div class="container-logo">
            <div class="logo">
                <a href="index.php">English Learning</a>
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
                            <a href="./view/login/profile.php"><i class="fas fa-user"></i> Hồ sơ</a>
                            <a href="./view/login/progress.php"><i class="fas fa-chart-line"></i> Tiến độ học tập</a>
                            <a href="./view/admin/admin.php"><i class="fas fa-tachometer-alt"></i> Bảng điều khiển quản trị</a>
                            <a href="./view/login/change_password.php"><i class="fas fa-key"></i> Đổi mật khẩu</a>
                            <a href="./view/login/logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
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

    <!-- Section Navigation Menu -->
    <div class="nav-menu">
        <div class="container">
            <button class="nav-btn active" data-section="grammar">
                <i class="fas fa-book"></i> GRAMMAR LESSONS
            </button>
            <button class="nav-btn" data-section="practice">
                <i class="fas fa-tasks"></i> PRACTICE TESTS
            </button>
            <button class="nav-btn" data-section="conversation">
                <i class="fas fa-comments"></i> CONVERSATIONS
            </button>
            <button class="nav-btn premium-btn" data-section="premium">
    <a href="./view/shop.php"><i class="fas fa-crown"></i> PREMIUM COURSES</a>
</button>

        </div>
    </div>
    <!-- Main Content -->
    <div class="container main-content">

        <!-- Grammar Section -->
        <section class="course-section" id="grammar-section">
            <div class="section-header">
                <h2><i class="fas fa-book"></i> GRAMMAR LESSONS</h2>
            </div>
            <div class="course-grid">
                <?php
                for ($i = 1; $i <= 6; $i++) {
                    $progress = rand(0, 100); // Replace with actual progress tracking
                    echo "
                    <div class='course-card'>
                        <div class='card-header'>
                            <h3>Level $i</h3>
                            <div class='lesson-count'>15 lessons</div>
                        </div>
                        <div class='card-content'>
                            <div class='progress-bar'>
                                <div class='progress' style='width: {$progress}%'></div>
                            </div>
                            <p>{$progress}% Complete</p>
                            <a href='./view/lessons.php?level=$i' class='start-btn'>
                                <i class='fas fa-play'></i> Start Learning
                            </a>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </section>

        <!-- Practice Tests Section -->
                <!-- Practice Tests Section -->
                <section class="course-section hidden" id="practice-section">
            <div class="section-header">
                <h2><i class="fas fa-tasks"></i> PRACTICE TESTS</h2>
            </div>
            <div class="course-grid">
                <?php
                // Kết nối và lấy dữ liệu từ bảng Practice
                try {
                    $stmt = $pdo->prepare("SELECT * FROM Practice");
                    $stmt->execute();
                    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($tests && count($tests) > 0): // Nếu có dữ liệu
                        foreach ($tests as $test):
                            ?>
                            <div class="course-card">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($test['title']); ?></h3>
                                    <div class="lesson-count">Level: <?php echo htmlspecialchars($test['level']); ?></div>
                                </div>
                                <div class="card-content">
                                    <p>Topics: <?php echo htmlspecialchars($test['topics']); ?></p>
                                    <p>Duration: <?php echo htmlspecialchars($test['duration']); ?> minutes</p>
                                    <p>Questions: <?php echo htmlspecialchars($test['questions']); ?></p>
                                    <a href="./view/test_start.php?id=<?php echo htmlspecialchars($test['id']); ?>" class="start-btn">
                                        <i class="fas fa-play"></i> Start Test
                                    </a>
                                </div>
                            </div>
                        <?php
                        endforeach;
                    else: // Nếu không có dữ liệu
                        ?>
                        <p>No tests available. Please check back later.</p>
                    <?php
                    endif;
                } catch (Exception $e) {
                    echo "<p>Error loading practice tests: " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                ?>
            </div>
        </section>


        <!-- Conversation Section -->
                    <!-- Conversation Section -->
                    <section class="course-section hidden" id="conversation-section">
    <div class="section-header">
        <h2><i class="fas fa-comments"></i> CONVERSATIONS</h2>
    </div>
    <div class="course-grid">
        <?php
        // Lấy tất cả các cuộc hội thoại từ bảng `conver`
        $stmt = $pdo->prepare("SELECT * FROM conver WHERE type = 'conversation'");
        $stmt->execute();
        $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($conversations)): // Kiểm tra nếu có dữ liệu
            foreach ($conversations as $conversation): ?>
                <div class="course-card">
                    <div class="card-header">
                        <h3><?php echo htmlspecialchars($conversation['title']); ?></h3>
                    </div>
                    <div class="card-content">
                        <p><?php echo htmlspecialchars($conversation['description']); ?></p>
                        <p>Duration: <?php echo htmlspecialchars($conversation['duration']); ?> minutes</p>
                        <p>Difficulty: <?php echo htmlspecialchars($conversation['difficulty']); ?></p>
                        <a href="./view/conversation_detail.php?title=<?php echo urlencode($conversation['title']); ?>" class="start-btn">
                            <i class="fas fa-play"></i> Start Practice
                        </a>
                    </div>
                </div>
            <?php endforeach; 
        else: // Trường hợp không có dữ liệu
            ?>
            <p>No conversations available at the moment. Please check back later.</p>
        <?php endif; ?>
    </div>
</section>




    </div>
    <!-- Footer -->
    <?php include './view/page/footer.php'; ?>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('.nav-btn');
            const sections = document.querySelectorAll('.course-section');

            sections.forEach(section => {
                section.classList.remove('hidden');
            });
            const premiumSection = document.getElementById('premium-section');
            if (premiumSection) {
                premiumSection.classList.add('hidden');
            }

            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    navButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    sections.forEach(section => {
                        section.classList.add('hidden');
                    });

                    const sectionId = `${button.dataset.section}-section`;
                    document.getElementById(sectionId).classList.remove('hidden');
                });
            });
        });
    </script>
</body>

</html>