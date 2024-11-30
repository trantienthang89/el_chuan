<?php
include 'db.php';
class Course {
    // Thông tin khóa học
    public $id;
    public $name;
    public $price;
    public $features;

    // Hàm lấy tất cả khóa học từ database
    public static function getAllCourses() {
        global $db;
        $query = "SELECT * FROM courses";
        $result = mysqli_query($db, $query);
        $courses = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
        return $courses;
    }

    // Hàm tìm khóa học theo id
    public static function getCourseById($id) {
        global $db;
        $query = "SELECT * FROM courses WHERE id = $id";
        $result = mysqli_query($db, $query);
        return mysqli_fetch_assoc($result);
    }
}
