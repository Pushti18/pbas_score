<?php
// Include your database connection file or establish a database connection here
session_start();
include("db_connect.php");

// Retrieve session variable
$employee_id = $_SESSION['employee_id'];
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pbasYear = $_POST['pbasYear'];
    $courseName = $_POST['courseName'];
    $natureOfInnovation = $_POST['natureOfInnovation'];
    $hoursSpentInnovation = $_POST['hoursSpentInnovation'];
    // Handle file upload if needed
    $documentInnovation = $_FILES['documentInnovation']['name'];
    $documentInnovation_temp = $_FILES['documentInnovation']['tmp_name'];

    // Move uploaded file to a permanent location
    $target_dir = "uploads/"; // Directory where files will be stored
    $target_file = $target_dir . basename($documentInnovation);
    move_uploaded_file($documentInnovation_temp, $target_file);

    // Prepare SQL INSERT statement
    $sql = "INSERT INTO learning_methodologies (employee_id, pbasYear, courseName, natureOfInnovation, hoursSpentInnovation, documentInnovation) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisiss", $employee_id, $pbasYear, $courseName, $natureOfInnovation, $hoursSpentInnovation, $documentInnovation);

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
