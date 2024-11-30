<?php
session_start();
include '../../model/db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiến độ học tập - Hi English</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link rel="stylesheet" href="../../public/css/footer.css">
    <style>
        .progress-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .progress-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .overview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .overview-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        .chart-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .level-progress {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .progress-bar {
            height: 20px;
            background: #f0f0f0;
            border-radius: 10px;
            margin: 1rem 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #003366;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .level-item {
            margin-bottom: 2rem;
        }

        .level-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .recent-activity {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-top: 2rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #003366;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="progress-container">
        <div class="progress-header">
            <h1>Tiến độ học tập</h1>
            <p>Theo dõi quá trình học tập của bạn</p>
        </div>

        <div class="overview-grid">
            <div class="overview-card">
                <i class="fas fa-calendar-check fa-2x"></i>
                <h3>Ngày học liên tiếp</h3>
                <p class="count">7 ngày</p>
            </div>
            <div class="overview-card">
                <i class="fas fa-clock fa-2x"></i>
                <h3>Thời gian học</h3>
                <p class="count">24 giờ</p>
            </div>
            <div class="overview-card">
                <i class="fas fa-star fa-2x"></i>
                <h3>Điểm kinh nghiệm</h3>
                <p class="count">1,250 XP</p>
            </div>
        </div>

        <div class="chart-container">
            <h2>Hoạt động trong tuần</h2>
            <canvas id="activityChart"></canvas>
        </div>

        <div class="level-progress">
            <h2>Tiến độ các cấp độ</h2>
            <?php for($i = 1; $i <= 6; $i++): ?>
            <div class="level-item">
                <div class="level-header">
                    <h3>Level <?php echo $i; ?></h3>
                    <span>75%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%"></div>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <div class="recent-activity">
            <h2>Hoạt động gần đây</h2>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="activity-info">
                    <h4>Hoàn thành bài học Present Simple</h4>
                    <p>Hôm nay, 15:30</p>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="activity-info">
                    <h4>Đạt 90% bài kiểm tra Grammar Test 1</h4>
                    <p>Hôm qua, 18:45</p>
                </div>
            </div>
        </div>
    </div>

    <?php include '../page/footer.php'; ?>

    <script>
        // Activity Chart
        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                datasets: [{
                    label: 'Thời gian học (phút)',
                    data: [30, 45, 60, 35, 50, 40, 55],
                    borderColor: '#003366',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>