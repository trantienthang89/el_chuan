-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3307:3307
-- Thời gian đã tạo: Th10 30, 2024 lúc 08:33 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `english1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conver`
--

CREATE TABLE `conver` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('conversation','other') DEFAULT 'conversation',
  `duration` varchar(50) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT 'Easy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `conver`
--

INSERT INTO `conver` (`id`, `title`, `description`, `type`, `duration`, `difficulty`) VALUES
(1, 'At the Restaurant', 'Learn how to order food and interact with restaurant staff', 'conversation', '10 minutes', 'Easy'),
(2, 'Job Interview', 'Practice common job interview questions and responses', 'conversation', '15 minutes', 'Medium'),
(3, 'Shopping', 'Learn phrases for shopping in English', 'conversation', '8 minutes', 'Easy'),
(4, 'Travel', 'Learn how to ask for directions while traveling', 'conversation', '12 minutes', 'Medium');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `lesson_count` int(11) NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `type` enum('premium','regular') DEFAULT 'regular',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `name`, `price`, `lesson_count`, `features`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Business English', 99.99, 30, '[\"Professional vocabulary\", \"Business writing\", \"Meeting skills\"]', 'premium', '2024-11-29 12:08:54', '2024-11-29 12:08:54'),
(2, 'IELTS Preparation', 149.99, 40, '[\"Full practice tests\", \"Speaking tutorials\", \"Writing feedback\"]', 'premium', '2024-11-29 12:08:54', '2024-11-29 12:08:54'),
(3, 'Conversational Mastery', 79.99, 25, '[\"Native speaker sessions\", \"Real-life scenarios\", \"Pronunciation guide\"]', 'premium', '2024-11-29 12:08:54', '2024-11-29 12:08:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dialogues`
--

CREATE TABLE `dialogues` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `script` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dialogues`
--

INSERT INTO `dialogues` (`id`, `title`, `script`, `image`) VALUES
(1, 'At the Restaurant', 'Customer: Hi there! Can I get a medium cappuccino, please?\r\n\r\nBarista: Of course! Would you like that hot or iced?\r\n\r\nCustomer: Hot, please. And could you add a shot of vanilla syrup to that?\r\n\r\nBarista: Absolutely! Would you like any whipped cream on top?\r\n\r\nCustomer: Yes, that sounds great!\r\n\r\nBarista: Perfect! That\'ll be $4.50.\r\n\r\nCustomer: Here you go.\r\n\r\nBarista: Thank you! Your order will be ready shortly.\r\n\r\nCustomer: Thanks! By the way, do you have any pastries today?\r\n\r\nBarista: Yes, we have croissants, muffins, and some delicious chocolate chip cookies.\r\n\r\nCustomer: I’ll take a chocolate chip cookie as well.\r\n\r\nBarista: Great choice! Your total is now $6.00.\r\n\r\nCustomer: Here’s the rest.\r\n\r\nBarista: Thank you! Your cappuccino and cookie will be ready in just a moment.\r\n\r\nCustomer: I appreciate it!\r\n\r\nBarista: You’re welcome! Enjoy your day!\r\n\r\nCustomer: You too!', 'https://tse3.mm.bing.net/th?id=OIP.IbAEgEG_pHp-2fU8xKeA8AHaFj&pid=Api&P=0&h=180'),
(2, 'Shopping', 'A: Excuse me, where can I find the shoes? B: They are on the second floor, next to the clothing section.', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `grammar_questions`
--

CREATE TABLE `grammar_questions` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `type` enum('multiple_choice','text') NOT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `correct_answer` varchar(255) NOT NULL,
  `explanation` text DEFAULT NULL,
  `question_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `grammar_questions`
--

INSERT INTO `grammar_questions` (`id`, `lesson_id`, `question`, `type`, `options`, `correct_answer`, `explanation`, `question_order`) VALUES
(1, 1, 'He ____ to work every day.', 'multiple_choice', '[\"goes\", \"go\", \"going\", \"went\"]', 'goes', 'We use \"goes\" with third-person singular subjects (he/she/it) in the present simple tense.', 1),
(2, 1, 'They ____ basketball on weekends.', 'multiple_choice', '[\"plays\", \"play\", \"playing\", \"played\"]', 'play', 'We use the base form of the verb with plural subjects in the present simple tense.', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `level` int(11) NOT NULL,
  `lesson_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `level`, `lesson_order`, `created_at`) VALUES
(1, 'Present Simple Tense', 'Learn when and how to use the present simple tense', 1, 1, '2024-11-29 04:28:53'),
(2, 'Present Continuous Tense', 'Understanding ongoing actions in the present', 1, 2, '2024-11-29 04:28:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `practice`
--

CREATE TABLE `practice` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `topics` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `questions` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `practice`
--

INSERT INTO `practice` (`id`, `title`, `topics`, `duration`, `questions`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Test 1', 'Present Tense, Vocabulary', 30, 25, 1, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(2, 'Test 2', 'Past Tense, Articles', 30, 25, 1, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(3, 'Test 3', 'Future Tense, Adjectives', 30, 25, 2, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(4, 'Test 4', 'Vocabulary, Reading Comprehension', 30, 25, 2, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(5, 'Test 5', 'Conditional Sentences, Vocabulary', 30, 25, 2, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(6, 'Test 6', 'Pronouns, Prepositions', 30, 25, 3, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(7, 'Test 7', 'Adverbs, Conjunctions', 30, 25, 3, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(8, 'Test 8', 'Reading Comprehension, Writing Skills', 30, 25, 3, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(9, 'Test 9', 'Listening Skills, Vocabulary', 30, 25, 4, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(10, 'Test 10', 'Grammar Review, Vocabulary', 30, 25, 4, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(11, 'Test 11', 'Essay Writing, Argumentative Skills', 45, 10, 5, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(12, 'Test 12', 'Business English, Vocabulary', 30, 25, 5, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(13, 'Test 13', 'Idioms, Phrasal Verbs', 30, 25, 3, '2024-11-28 06:07:07', '2024-11-28 06:07:07'),
(14, 'Test 14', 'Common Mistakes, Vocabulary', 30, 25, 2, '2024-11-28 06:07:07', '2024-11-28 06:07:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `type` enum('multiple_choice','text') NOT NULL,
  `choices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`choices`)),
  `correct_answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `content`, `type`, `choices`, `correct_answer`) VALUES
(1, 1, 'What is the present tense of the verb \"go\"?', 'multiple_choice', '[\"goes\", \"went\", \"gone\", \"go\"]', 'go'),
(2, 1, 'Choose the correct sentence: \"He ____ to school every day.\"', 'multiple_choice', '[\"goes\", \"going\", \"gone\", \"go\"]', 'goes'),
(3, 1, 'Translate the word \"beautiful\" into your native language.', 'text', NULL, 'User response'),
(4, 2, 'What is the past tense of the verb \"write\"?', 'multiple_choice', '[\"wrote\", \"written\", \"writing\", \"writes\"]', 'wrote'),
(5, 2, 'Choose the correct article: \"____ apple a day keeps the doctor away.\"', 'multiple_choice', '[\"An\", \"A\", \"The\", \"None\"]', 'An'),
(6, 3, 'What is the future tense of the verb \"read\"?', 'multiple_choice', '[\"will read\", \"reads\", \"reading\", \"read\"]', 'will read'),
(7, 3, 'Choose the correct adjective: \"This is a ____ story.\"', 'multiple_choice', '[\"interesting\", \"interests\", \"interest\", \"interested\"]', 'interesting');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `test_id`, `score`, `total_questions`, `created_at`) VALUES
(1, 2, 1, 0, 3, '2024-11-28 13:50:57'),
(2, 2, 1, 0, 3, '2024-11-28 13:51:05'),
(3, 2, 1, 0, 3, '2024-11-28 13:51:09'),
(4, 2, 1, 0, 3, '2024-11-28 13:51:13'),
(5, 2, 1, 1, 3, '2024-11-28 13:51:17'),
(6, 2, 2, 0, 2, '2024-11-28 13:52:43'),
(7, 2, 2, 0, 2, '2024-11-28 13:52:47'),
(8, 2, 2, 1, 2, '2024-11-28 13:52:51'),
(9, 2, 1, 0, 3, '2024-11-28 14:06:05'),
(10, 2, 1, 0, 3, '2024-11-28 14:12:56'),
(11, 2, 1, 0, 3, '2024-11-28 14:13:03'),
(12, 4, 10, 0, 0, '2024-11-30 00:54:13'),
(13, 4, 1, 0, 3, '2024-11-30 01:00:51'),
(14, 4, 1, 0, 3, '2024-11-30 01:01:17'),
(15, 4, 1, 0, 3, '2024-11-30 01:01:39'),
(16, 4, 1, 0, 3, '2024-11-30 01:01:55'),
(17, 4, 1, 0, 3, '2024-11-30 01:02:25'),
(18, 4, 1, 0, 3, '2024-11-30 01:40:03'),
(19, 4, 1, 1, 3, '2024-11-30 01:40:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test_details`
--

CREATE TABLE `test_details` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `options` text NOT NULL,
  `correct_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `test_details`
--

INSERT INTO `test_details` (`id`, `lesson_id`, `question`, `options`, `correct_answer`) VALUES
(1, 2, 'Which sentence is correct?', '{\"1\": \"She play football.\", \"2\": \"She plays football.\"}', '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `last_login`) VALUES
(1, 'thanhtan', 'thanhtan2092k4@gmail.com', '$2y$10$/XOd778W9Omk1G.Kmy7AheEnwGRZPzRKtIcBIraHj5eK3/1ybDii2', 'user', '2024-11-29 04:30:06', '2024-11-29 16:51:04'),
(2, 'thang', 'thang@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2024-11-29 16:24:12', NULL),
(4, 'admintha', 'admin@gmail.com', '$2y$10$5FIiQSK4bMD4YB5DwgHvuOvIFml0gqzV2W/lyax7Fwc6OZs40jABS', 'user', '2024-11-29 16:52:03', '2024-11-30 06:23:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `answered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `conver`
--
ALTER TABLE `conver`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dialogues`
--
ALTER TABLE `dialogues`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `grammar_questions`
--
ALTER TABLE `grammar_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Chỉ mục cho bảng `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_lesson` (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Chỉ mục cho bảng `practice`
--
ALTER TABLE `practice`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Chỉ mục cho bảng `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

--
-- Chỉ mục cho bảng `test_details`
--
ALTER TABLE `test_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `conver`
--
ALTER TABLE `conver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `dialogues`
--
ALTER TABLE `dialogues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `grammar_questions`
--
ALTER TABLE `grammar_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `practice`
--
ALTER TABLE `practice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `test_details`
--
ALTER TABLE `test_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `grammar_questions`
--
ALTER TABLE `grammar_questions`
  ADD CONSTRAINT `grammar_questions_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`);

--
-- Các ràng buộc cho bảng `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`),
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `test_details`
--
ALTER TABLE `test_details`
  ADD CONSTRAINT `test_details_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `grammar_questions` (`id`),
  ADD CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
