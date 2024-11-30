<?php
session_start();
require_once '../model/db.php';
require_once '../model/LessonModel.php';
require_once '../controller/LessonController.php';

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Lấy lesson_id và danh sách câu trả lời từ người dùng
$lesson_id = $_POST['lesson_id'] ?? null;
$answers = $_POST['answers'] ?? [];

if (!$lesson_id || empty($answers)) {
    echo json_encode(['error' => 'Lesson ID or answers are missing']);
    exit;
}

$controller = new LessonController($pdo);
$questions = $controller->getQuestions($lesson_id);

$results = [];
$correct_count = 0;

// Kiểm tra từng câu trả lời
foreach ($questions as $question) {
    $question_id = $question['id'];
    $user_answer = $answers[$question_id] ?? null;
    $is_correct = strtolower(trim($user_answer)) === strtolower(trim($question['correct_answer']));

    if ($is_correct) {
        $correct_count++;
    }

    $results[] = [
        'question_id' => $question_id,
        'user_answer' => $user_answer,
        'is_correct' => $is_correct,
        'correct_answer' => $question['correct_answer'],
        'explanation' => $question['explanation'] ?? 'No explanation provided'
    ];
}

// Tính điểm
$total_questions = count($questions);
$score = $total_questions > 0 ? ($correct_count / $total_questions) * 100 : 0;

// Trả kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode([
    'answers' => $results,
    'score' => $score,
    'correct_count' => $correct_count,
    'total_questions' => $total_questions,
    'completed' => $score >= 70 // Xác định nếu điểm số vượt qua 70%
]);
