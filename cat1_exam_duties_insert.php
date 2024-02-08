<?php
// Include your database connection file or establish a database connection here
session_start();
include("db_connect.php");

// Retrieve session variable
$employee_id = $_SESSION['employee_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $cat1_id = $_POST['cat1_id'];
    $pbas_year = $_POST['pbas_year'];
    $semester = $_POST['semester'];
    $stream_name = $_POST['streamName'];
    $course_name = $_POST['courseName'];
    $question_paper_count = $_POST['questionPaper'];
    $hours_spent_question = $_POST['hoursSpentQuestion'];
    $examinations_count = $_POST['numExaminations'];
    $hours_spent_examinations = $_POST['hoursSpentExaminations'];
    $answer_book_count = $_POST['numAnswerBook'];
    $hours_spent_answer_book = $_POST['hoursSpentAnswerBook'];

    // Prepare SQL INSERT statement
    $sql = "INSERT INTO exam_duties (employee_id, cat1_id, pbas_year, semester, stream_name, course_name, question_paper_count, hours_spent_question, examinations_count, hours_spent_examinations, answer_book_count, hours_spent_answer_book) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisssiiiiii", $employee_id, $cat1_id, $pbas_year, $semester, $stream_name, $course_name, $question_paper_count, $hours_spent_question, $examinations_count, $hours_spent_examinations, $answer_book_count, $hours_spent_answer_book);

    // Execute the statement
    if ($stmt->execute()) {
        // Insertion successful
        echo "Data inserted successfully.";
    } else {
        // Insertion failed
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
    
    // Close database connection
    $conn->close();
}
?>
