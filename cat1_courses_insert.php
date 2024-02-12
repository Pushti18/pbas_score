<?php
session_start();
include("db_connection.php");

// Handle form data
$employee_id = $_POST['employee_id'];
$pbasYear = $_POST['pbasYear'];
$courseName = $_POST['courseName'];

$detailofuploadedsubject = $_POST['detailofuploadedsubject'];
$hoursSpentInnovation = $_POST['hoursSpentInnovation'];

// Handle file uploads
// $targetDirectory = "uploads/";
// $documentInnovation = $_FILES['documentInnovation']['name'];
// $documentInnovation_temp = $_FILES['documentInnovation']['tmp_name'];
// $uploadexecutive = $_FILES['uploadexecutive']['name'];
// $uploadexecutive_temp = $_FILES['uploadexecutive']['tmp_name'];

// $targetDocumentInnovation = $targetDirectory . basename($documentInnovation);
// $targetUploadExecutive = $targetDirectory . basename($uploadexecutive);

// // Move uploaded files to target directory
// move_uploaded_file($documentInnovation_temp, $targetDocumentInnovation);
// move_uploaded_file($uploadexecutive_temp, $targetUploadExecutive);
$hours = intval($hoursSpentInnovation); // Convert hours to integer
$points = 0; // Initialize points
if ($hours >= 10) {
    // Calculate points: 1 point for every 10 hours
    $points = floor($hours / 10);
}

// Insert data into the database
$sql = "INSERT INTO courses (employee_id, pbasYear, courseName, detailofuploadedsubject, hoursSpentInnovation, documentInnovation, uploadexecutive,points) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isissss", $employee_id, $pbasYear, $courseName, $detailofuploadedsubject, $hoursSpentInnovation, $targetDocumentInnovation, $targetUploadExecutive,$points);
$stmt->execute();
$stmt->close();

// Close database connection
$conn->close();

// Return a response
echo "Data inserted successfully.";
?>
