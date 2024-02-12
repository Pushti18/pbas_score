<?php
// Start session and include database connection
session_start();
include("db_connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $pbasYear = $_POST['pbasYear'];
    $mentorName = $_POST['mentorName'];
    $studentNames = $_POST['studentNames'];
    $outcomeMentoring = $_POST['outcomeMentoring'];
    $hoursSpent = $_POST['hoursSpent'];

    // Calculate points based on hours spent
    $points = 0;
    if ($hoursSpent >= 10) {
        $points = floor($hoursSpent / 10);
    }

    // Insert data into the database
    $sql = "INSERT INTO mentoring (employee_id, pbasYear, mentorName, studentNames, outcomeMentoring, hoursSpent, points) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isisssi", $employee_id, $pbasYear, $mentorName, $studentNames, $outcomeMentoring, $hoursSpent, $points);
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
