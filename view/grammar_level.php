<?php
session_start();
require_once '../model/db.php';
require_once '../model/LessonModel.php';
require_once '../controller/LessonController.php';

$lesson_id = $_GET['lesson_id'] ?? 1;
$controller = new LessonController($pdo);
$lesson = $controller->getLesson($lesson_id);
$questions = $controller->getQuestions($lesson_id);
?>          

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($lesson['title']); ?> - Grammar Practice</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/lessons.css">
    <link rel="stylesheet" href="../public/css/navbar.css">
</head>
<body>
    <?php include '../view/page/navbar.php'; ?>

    <div class="container main-content">
        <div class="breadcrumb">
            <a href="../index.php">Home</a> > 
            <a href="grammar_lessons.php">Grammar Lessons</a> > 
            <?php echo htmlspecialchars($lesson['title']); ?>
        </div>

        <div class="lesson-container">
            <h1><?php echo htmlspecialchars($lesson['title']); ?></h1>
            <div class="lesson-description">
                <?php echo $lesson['description']; ?>
            </div>

            <form id="grammar-exercise" method="POST" action="process_answers.php">
                <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                
                <?php foreach ($questions as $index => $question): ?>
                    <div class="question-card" id="question-<?php echo $question['id']; ?>">
                        <h3>Question <?php echo $index + 1; ?></h3>
                        <p class="question-text"><?php echo htmlspecialchars($question['question']); ?></p>

                        <?php if ($question['type'] === 'multiple_choice'): ?>
                            <?php 
                            $options = json_decode($question['options'], true);
                            foreach ($options as $option): 
                            ?>
                                <label class="option">
                                    <input type="radio" 
                                           name="answers[<?php echo $question['id']; ?>]" 
                                           value="<?php echo htmlspecialchars($option); ?>">
                                    <?php echo htmlspecialchars($option); ?>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <input type="text" 
                                   name="answers[<?php echo $question['id']; ?>]" 
                                   class="answer-input" 
                                   placeholder="Your answer">
                        <?php endif; ?>

                        <div class="feedback hidden"></div>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="submit-btn">Submit Answers</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('grammar-exercise').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('process_answers.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.error) {
            alert(result.error);
            return;
        }

        // Hiển thị kết quả từng câu
        result.answers.forEach(answer => {
            const questionDiv = document.querySelector(`#question-${answer.question_id}`);
            const feedback = questionDiv.querySelector('.feedback');

            feedback.classList.remove('hidden');
            feedback.classList.add(answer.is_correct ? 'correct' : 'incorrect');
            feedback.innerHTML = `
                <p>${answer.is_correct ? 'Correct!' : 'Incorrect.'}</p>
                <p>Your Answer: ${answer.user_answer || 'No answer provided'}</p>
                <p>Correct Answer: ${answer.correct_answer}</p>
                <p>Explanation: ${answer.explanation}</p>
            `;
        });

        // Hiển thị tổng kết điểm
        alert(`Your score: ${result.score.toFixed(2)}%\nCorrect Answers: ${result.correct_count}/${result.total_questions}`);

        // Chuyển hướng nếu hoàn thành bài học
        if (result.completed) {
            window.location.href = `lesson_complete.php?lesson_id=${formData.get('lesson_id')}`;
        }
    } catch (error) {
        console.error('Error details:', error);
        alert(`An error occurred: ${error.message}`);
    }
});

    </script>
</body>
</html>