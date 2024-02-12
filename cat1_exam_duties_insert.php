<?php
session_start();
include("db_connection.php");

$employee_id = $_SESSION['employee_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $pbas_year = $_POST['pbasYear'];
    $semester = $_POST['semester'];
    $stream_name = $_POST['streamName'];
    $course_name = $_POST['courseName'];
    $question_paper_count = $_POST['questionPaper'];
    $hours_spent_question = $_POST['hoursSpentQuestion'];
    $examinations_count = $_POST['numExaminations'];
    $hours_spent_examinations = $_POST['hoursSpentExaminations'];
    $answer_book_count = $_POST['numAnswerBook'];
    $hours_spent_answer_book = $_POST['hoursSpentAnswerBook'];

    $hours_score = calculateScore($hours_spent_question, $hours_spent_examinations, $hours_spent_answer_book);

    $sql = "INSERT INTO exam_duties (employee_id, pbas_year, semester, stream_name, course_name, question_paper_count, hours_spent_question, examinations_count, hours_spent_examinations, answer_book_count, hours_spent_answer_book, score) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssiiiiiii", $employee_id, $pbas_year, $semester, $stream_name, $course_name, $question_paper_count, $hours_spent_question, $examinations_count, $hours_spent_examinations, $answer_book_count, $hours_spent_answer_book, $hours_score);

    if ($stmt->execute()) {
        // echo "Data inserted successfully.";
    } else {
        // echo "Error: " . $stmt->error;
    }

    // $stmt->close();
    $conn->close();
}
function calculateScore($hours_spent_question, $hours_spent_examinations, $hours_spent_answer_book) {
    $total_hours = $hours_spent_question + $hours_spent_examinations + $hours_spent_answer_book;
    $score = ceil($total_hours / 10); // Calculate score based on 10 hours per point
    return $score;
}
?>
