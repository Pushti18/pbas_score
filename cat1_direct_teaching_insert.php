<?php
session_start();
include("db_connect.php");

// Retrieve session variable
$employee_id = $_SESSION['employee_id']; // Replace with your actual session variable

// Retrieve form data
$university = $_POST['university'];
$year = $_POST['year'];
$enroll = $_POST['enroll'];
$pbas_year = $_POST['pbasYear'];
$submisson_date = $_POST['submissionDate'];
$hours_spent = $_POST['hoursSpent'];
$degree = $_POST['degree'];
$student_name = $_POST['studentName'];
$project_title = $_POST['projectTitle'];
$project_type = $_POST['projectType'];
$status_of_work = $_POST['statusofwork'];
$attachment = $_FILES['attachment']['name'];

// Connect to the database
global $conn;

// Store the data in the new table
$sql = "INSERT INTO direct_teaching (cat1_id, employee_id, university, year, enroll, pbas_year, submission_date, hours_spent, degree, student_name, project_title, project_type, status_of_work, attachment) 
        VALUES ('$cat1_id', '$employee_id', '$university', '$year', '$enroll', '$pbas_year', '$submisson_date', '$hours_spent', '$degree', '$student_name', '$project_title', '$project_type', '$status_of_work', '$attachment')";
mysqli_query($conn, $sql);

// Handle potential errors
if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data stored successfully.";
}

mysqli_close($conn);

// ... rest of your PHP code for the page
?>
