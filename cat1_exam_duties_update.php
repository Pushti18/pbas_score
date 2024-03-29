<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM exam_duties WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $entryData = mysqli_fetch_assoc($result);
        echo json_encode($entryData);
    } else {
        echo "No data found for the given entry ID.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $entry_id = $_POST['entry_id'];
    $pbasYear = $_POST['editpbasYear'];
    $semester = $_POST['editsemester'];
    $streamName = $_POST['editstreamName'];
    $courseName = $_POST['editcourseName'];
    $questionPaper = $_POST['editquestionPaper'];
    $hoursSpentQuestion = $_POST['edithoursSpentQuestion'];
    $numExaminations = $_POST['editnumExaminations'];
    $hoursSpentExaminations = $_POST['edithoursSpentExaminations'];
    $numAnswerBook = $_POST['editnumAnswerBook'];
    $hoursSpentAnswerBook = $_POST['edithoursSpentAnswerBook'];

    // Perform the update operation
    $sql = "UPDATE exam_duties SET pbas_year='$pbasYear', semester='$semester', stream_name='$streamName', course_name='$courseName', question_paper_count='$questionPaper', hours_spent_question='$hoursSpentQuestion', examinations_count='$numExaminations', hours_spent_examinations='$hoursSpentExaminations', answer_book_count='$numAnswerBook', hours_spent_answer_book='$hoursSpentAnswerBook' WHERE id='$entry_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
        // echo "Record updated successfully";
    } else {

        // echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}