<?php
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $record_id = $_POST['record_id'];
    $university = $_POST['university'];
    $year = $_POST['year'];
    $enroll = $_POST['enroll'];
    $pbasYear = $_POST['pbasYear'];
    $submissionDate = $_POST['submissionDate'];
    $hoursSpent = $_POST['hoursSpent'];
    $degree = $_POST['degree'];
    $studentName = $_POST['studentName'];
    $projectTitle = $_POST['projectTitle'];
    $projectType = $_POST['projectType'];
    $statusofwork = $_POST['statusofwork'];

    $update_sql = "UPDATE direct_teaching SET 
                    university='$university', 
                    year='$year', 
                    enroll='$enroll', 
                    pbasYear='$pbasYear', 
                    submissionDate='$submissionDate', 
                    hoursSpent='$hoursSpent', 
                    degree='$degree', 
                    studentName='$studentName', 
                    projectTitle='$projectTitle', 
                    projectType='$projectType', 
                    statusofwork='$statusofwork' 
                    WHERE id='$record_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}