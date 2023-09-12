<?php
// Include database connection file
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input to prevent SQL injection
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);

    // Validate input (you can add more specific validation as needed)
    if (!is_numeric($student_id) || !is_numeric($course_id)) {
        die("Invalid input. Please enter numeric values for Student ID and Course ID.");
    }

    // Prepare and bind parameters to prevent SQL injection
    $query = $conn->prepare("INSERT INTO Enrollments (student_id, course_id, enrollment_date)
                            VALUES (?, ?, NOW())");
    $query->bind_param("ii", $student_id, $course_id);

    if ($query->execute()) {
        echo "Enrollment successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $query->close();
    mysqli_close($conn);
}
?>
