<?php
session_start();
include ("db_connection.php");

$category = $_SESSION['cat1'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Calculate points for each task
    $points = calculateScore($hoursSpentQuestion) + calculateScore($hoursSpentExaminations) + calculateScore($hoursSpentAnswerBook);

    // Insert data into database
    $sql = "INSERT INTO exam_duties (cat1_id, subcat_1, employee_id, pbas_year, semester, stream_name, course_name, question_paper_count, hours_spent_question, examinations_count, hours_spent_examinations, answer_book_count, hours_spent_answer_book, points) 
            VALUES ('$category', '$subcategory_id', '$employee_id', '$pbasYear', '$semester', '$streamName', '$courseName', '$questionPaper', '$hoursSpentQuestion', '$numExaminations', '$hoursSpentExaminations', '$numAnswerBook', '$hoursSpentAnswerBook', '$points')";

    mysqli_query($conn, $sql);

    if (mysqli_error($conn)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "<script>window.location.reload();</script>";
        exit();
    }
} else {
    echo "Invalid request method.";
}
mysqli_close($conn);

function calculateScore($hoursSpent)
{
    // Calculate points for every 10 hours spent
    $points = ceil($hoursSpent / 10);
    return $points;
}
?>