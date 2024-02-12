<?php
session_start();
include("db_connection.php");
$cat2_id = $_SESSION['cat2_id']; 
$employee_id = $_SESSION['employee_id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pbasYear = $_POST['pbasYear'];
    $mainActivity = $_POST['mainActivity'];
    $subActivity = $_POST['subActivity'];
    $activityTitle = $_POST['activityTitle'];
    $briefRole = $_POST['briefRole'];
    $semester = $_POST['semester'];
    $hoursSpentAnswerBook = $_POST['hoursSpentAnswerBook'];
    $attachment = $_POST['attachment'];
    $description = $_POST['description'];

    $sql = "INSERT INTO administrative (cat2_id, employee_id, pbasYear, mainActivity, subActivity, activityTitle, briefRole, semester, hoursSpentAnswerBook, attachment, description)
            VALUES ('$cat2_id', '$employee_id', '$pbasYear', '$mainActivity', '$subActivity', '$activityTitle', '$briefRole', '$semester', '$hoursSpentAnswerBook', '$attachment', '$description')";

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
?>