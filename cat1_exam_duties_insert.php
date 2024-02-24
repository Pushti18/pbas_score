<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat1'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $employee_id = $_POST['employee_id'];
    $pbasYear = $_POST['pbasYear'];
    $semester = $_POST['semester'];
    $streamName = $_POST['streamName'];
    $courseName = $_POST['courseName'];
    $questionPaper = $_POST['questionPaper'];
    $hoursSpentQuestion = $_POST['hoursSpentQuestion'];
    $numExaminations = $_POST['numExaminations'];
    $hoursSpentExaminations = $_POST['hoursSpentExaminations'];
    $numAnswerBook = $_POST['numAnswerBook'];
    $hoursSpentAnswerBook = $_POST['hoursSpentAnswerBook'];

    $hours_score = calculateScore($hours_spent_question, $hours_spent_examinations, $hours_spent_answer_book);

    $sql = "INSERT INTO exam_duties (cat1_id,subcat_1,employee_id, pbas_year, semester, stream_name, course_name, question_paper_count, hours_spent_question, examinations_count, hours_spent_examinations, answer_book_count, hours_spent_answer_book, points) 
            VALUES ('$category','$subcategory_id','$employee_id', '$pbasYear', '$semester', '$streamName', '$courseName', '$questionPaper', '$hoursSpentQuestion', '$numExaminations', '$hoursSpentExaminations', '$numAnswerBook','$hoursSpentAnswerBook','hours_score')";

mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data inserted into discipline table successfully.";
}
} else {
echo "Invalid request method.";
}
mysqli_close($conn);

function calculateScore($hours_spent_question, $hours_spent_examinations, $hours_spent_answer_book) {
    $total_hours = $hours_spent_question + $hours_spent_examinations + $hours_spent_answer_book;
    $score = ceil($total_hours / 10); // Calculate score based on 10 hours per point
    return $score;
}
?>