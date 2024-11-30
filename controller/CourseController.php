<?php
include_once '../models/Course.php';

class CourseController {
    public function index() {
        // Lấy danh sách các khóa học
        $courses = Course::getAllCourses();
        include '../views/courses/index.php';
    }
}
