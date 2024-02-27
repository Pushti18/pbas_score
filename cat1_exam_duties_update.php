<?php
session_start();
include("db_connection.php");

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

// Updating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $entryId = $_POST["entry_id"];
    $pbasYear = mysqli_real_escape_string($conn, $_POST["editPbasYear"]);
    $semester = mysqli_real_escape_string($conn, $_POST["editsemester"]);
    $streamName = mysqli_real_escape_string($conn, $_POST["editstreamName"]);
    $courseName = mysqli_real_escape_string($conn, $_POST["editcourseName"]);
    $questionPaper = mysqli_real_escape_string($conn, $_POST["editquestionPaper"]);
    $hoursSpentQuestion = mysqli_real_escape_string($conn, $_POST["edithoursSpentQuestion"]);
    $numExaminations = mysqli_real_escape_string($conn, $_POST["editnumExaminations"]);
    $hoursSpentExaminations = mysqli_real_escape_string($conn, $_POST["edithoursSpentExaminations"]);
    $numAnswerBook = mysqli_real_escape_string($conn, $_POST["editnumAnswerBook"]);
    $hoursSpentAnswerBook = mysqli_real_escape_string($conn, $_POST["edithoursSpentAnswerBook"]);

    $sql = "UPDATE exam_duties SET pbas_year='$pbasYear', semester='$semester', stream_name='$streamName', course_name='$courseName', question_paper_count='$questionPaper', hours_spent_question='$hoursSpentQuestion', examinations_count='$numExaminations', hours_spent_examinations='$hoursSpentExaminations', answer_book_count='$numAnswerBook', hours_spent_answer_book='$hoursSpentAnswerBook' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }

}
?>