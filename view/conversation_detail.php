<?php
session_start(); // Khởi động phiên

include '../model/db.php'; // Bao gồm tệp kết nối cơ sở dữ liệu

// Lấy tiêu đề từ URL
$title = isset($_GET['title']) ? $_GET['title'] : '';

// Kiểm tra xem tiêu đề có hợp lệ không
if (empty($title)) {
    echo "No conversation selected!";
    exit;
}

// Fetch a single conversation by title from the 'dialogues' table
$stmt = $pdo->prepare("SELECT * FROM dialogues WHERE title = ?");
$stmt->execute([$title]);
$conversation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conversation) {
    echo "Conversation not found!";
    exit;
}

// Kiểm tra xem cột 'script' có tồn tại và không rỗng
if (!isset($conversation['script']) || empty($conversation['script'])) {
    echo "No script found for the conversation!";
    exit;
}

// Tách kịch bản thành các dòng bằng ký tự xuống dòng
$lines = explode("\n", $conversation['script']); // Tách bằng ký tự xuống dòng
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($conversation['title']); ?></title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            flex-direction: column;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Tiêu đề */
        h1 {
            font-size: 2.5em;
            text-align: center; /* Canh giữa tiêu đề */
            margin-bottom: 20px;
            color: #333;
        }

        /* Đoạn hội thoại */
        .conversation-script {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            gap: 20px;
        }

        .conversation-text {
            flex: 1;
            padding-right: 20px;
        }

        .conversation-text p {
            font-size: 1.2em; /* Tăng kích thước font chữ */
            line-height: 1.6;
            color: #555;
            margin-bottom: 10px;
        }

        /* Hình ảnh */
        .image {
            width: 350px;
            height: auto;
            background-image: url('<?php echo htmlspecialchars($conversation['image']); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Responsive Design: Đảm bảo giao diện đẹp trên các màn hình nhỏ */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .conversation-script {
                flex-direction: column;
                align-items: center;
            }

            .image {
                width: 100%;
                height: 250px;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($conversation['title']); ?></h1>
        <div class="conversation-script">
            <div class="conversation-text">
                <?php foreach ($lines as $line): ?>
                    <p><?php echo htmlspecialchars($line); ?></p>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($conversation['image'])): ?>
                <div class="image"></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
