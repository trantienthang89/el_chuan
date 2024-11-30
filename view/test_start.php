<?php
// test_start.php
session_start();
include '../model/db.php';

if (!isset($_GET['id'])) {
    die("Test ID not provided.");
}

// Lấy ID của bài kiểm tra
$test_id = (int)$_GET['id'];

// Lấy thông tin bài kiểm tra từ bảng Practice
$stmt = $pdo->prepare("SELECT * FROM Practice WHERE id = ?");
$stmt->execute([$test_id]);
$test = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$test) {
    die("Test not found.");
}

// Lấy các câu hỏi cho bài kiểm tra
$question_stmt = $pdo->prepare("SELECT * FROM Questions WHERE test_id = ?");
$question_stmt->execute([$test_id]);
$questions = $question_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($test['title']); ?> - Take Test</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../public/css//navbar.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa; /* Màu nền sáng */
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            border-radius: 10px;
            border: none;
            background-color: #ffffff; /* Màu nền của card */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        h5 {
            font-size: 1.2rem;
        }

        p {
            font-size: 1rem;
        }

        label {
            font-size: 1rem;
        }

        textarea {
            resize: none;
            font-size: 1rem;
        }

        .btn-submit {
            display: block;
            margin: 20px auto; /* Căn giữa nút */
            font-size: 1.2rem;
            padding: 10px 30px;
        }
    </style>
</head>
<body>
<?php include '../view/page/navbar.php'; ?>

    <div class="container mt-5">
        <div class="card shadow p-4">
            <h1 class="text-center text-primary"><?php echo htmlspecialchars($test['title']); ?></h1>
            <div class="text-center mb-4">
                <p><strong>Topics:</strong> <?php echo htmlspecialchars($test['topics']); ?></p>
                <p><strong>Duration:</strong> <?php echo htmlspecialchars($test['duration']); ?> minutes</p>
                <p><strong>Total Questions:</strong> <?php echo count($questions); ?></p>
            </div>
            
            <form action="test_submit.php" method="POST">
                <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">

                <?php if (count($questions) > 0): ?>
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="mb-4">
                            <h5 class="text-dark">Question <?php echo $index + 1; ?>:</h5>
                            <p><?php echo htmlspecialchars($question['content']); ?></p>
                            <?php if ($question['type'] === 'multiple_choice'): ?>
                                <?php 
                                $choices = json_decode($question['choices'], true); 
                                ?>
                                <div class="form-check">
                                    <?php foreach ($choices as $choice): ?>
                                        <label class="form-check-label d-block">
                                            <input type="radio" class="form-check-input" name="answers[<?php echo $question['id']; ?>]" value="<?php echo htmlspecialchars($choice); ?>">
                                            <?php echo htmlspecialchars($choice); ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif ($question['type'] === 'text'): ?>
                                <textarea class="form-control" name="answers[<?php echo $question['id']; ?>]" rows="3" placeholder="Your answer..."></textarea>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-danger">No questions available for this test.</p>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary btn-submit">Submit Test</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
