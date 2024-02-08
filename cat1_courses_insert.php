<?php
// Include your database connection file or establish a database connection here
session_start();
include("db_connect.php");

// Retrieve session variable
$employee_id = $_SESSION['employee_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare a SQL INSERT statement
    $sql = "INSERT INTO cat1_courses (employee_id, pbasYear, courseName, detailofuploadedsubject, hoursSpentInnovation, documentInnovation, uploadexecutive) VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("iisssss", $_POST['employee_id'], $_POST['pbasYear'], $_POST['courseName'], $_POST['detailofuploadedsubject'], $_POST['hoursSpentInnovation'], $_POST['documentInnovation'], $_POST['uploadexecutive']);
    $stmt->execute();

    // Check if the query was successful
    if ($stmt->affected_rows > 0) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>