<?php
session_start();
include("db_connection.php");
global $conn;
$employee_id = $_SESSION['employee_id'];

// $university = $_POST['university'];
// $year = $_POST['year'];
// $enroll = $_POST['enroll'];
// $pbas_year = $_POST['pbasYear'];
// $submisson_date = $_POST['submissionDate'];
// $hours_spent = $_POST['hoursSpent'];
// $degree = $_POST['degree'];
// $student_name = $_POST['studentName'];
// $project_title = $_POST['projectTitle'];
// $project_type = $_POST['projectType'];
// $status_of_work = $_POST['statusofwork'];
// $attachment = $_FILES['attachment']['name'];

// global $conn;

// $sql = "INSERT INTO direct_teaching (cat1_id, employee_id, university, year, enroll, pbas_year, submission_date, hours_spent, degree, student_name, project_title, project_type, status_of_work, attachment) 
//         VALUES ('$cat1_id', '$employee_id', '$university', '$year', '$enroll', '$pbas_year', '$submisson_date', '$hours_spent', '$degree', '$student_name', '$project_title', '$project_type', '$status_of_work', '$attachment')";
// mysqli_query($conn, $sql);

// if (mysqli_error($conn)) {
//     echo "Error: " . mysqli_error($conn);
// } else {
//     echo "Data stored successfully.";
// }

// mysqli_close($conn);

// $employee_id = $_POST['employee_id'];
$university = $_POST['university'];
$year = $_POST['year'];
$enroll = $_POST['enroll'];
$pbasYear = $_POST['pbasYear'];
$subDate = $_POST['submissionDate'];
$pbasYear = $_POST['pbasYear'];
$hoursSpent = $_POST['hoursSpent'];
$degree = $_POST['degree'];
$studentName = $_POST['studentName'];
$projectTitle = $_POST['projectTitle'];
$projectType = $_POST['projectType'];
$statusofwork = $_POST['statusofwork'];

// SQL query to insert data
$sql = "INSERT INTO direct_teaching (employee_id, university, year, enroll, pbasYear, submissionDate, pbasYear, hoursSpent, degree, studentName, projectTitle, projectType, statusofwork) 
        VALUES ('$employee_id', '$university', '$year', '$enroll', '$pbasYear', '$subDate', '$pbasYear', '$hoursSpent', '$degree', '$studentName', '$projectTitle', '$projectType', '$statusofwork')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>