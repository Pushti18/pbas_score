<?php
session_start();
include ("db_connection.php");
$category = $_SESSION['cat3'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];

$name_of_university = isset($_POST['nameOfUniversity']) ? $_POST['nameOfUniversity'] : '';
$degree = isset($_POST['degree']) ? $_POST['degree'] : '';
$degree_award_date = isset($_POST['degreeAwardDate']) ? $_POST['degreeAwardDate'] : '';
$student_name = isset($_POST['studentName']) ? $_POST['studentName'] : '';
$enrollment_no = isset($_POST['enrollmentNo']) ? $_POST['enrollmentNo'] : '';
$project_title = isset($_POST['projectTitle']) ? $_POST['projectTitle'] : '';
$project_year = isset($_POST['projectYear']) ? $_POST['projectYear'] : '';
$project_type = isset($_POST['projectType']) ? $_POST['projectType'] : '';
$thesis_submission_date = isset($_POST['thesisSubmissionDate']) ? $_POST['thesisSubmissionDate'] : '';
$current_status_of_work = isset($_POST['currentStatusOfWork']) ? $_POST['currentStatusOfWork'] : '';

global $conn;

$pbasScore = 0;

if ($degree == 'Ph.D') {
    if ($current_status_of_work == 'Completed') {
        $mainSupervisorScore = 15;
        $jointSupervisorScore = 8;
        $pbasScore = ($mainSupervisorScore + $jointSupervisorScore);
    } elseif ($current_status_of_work == 'In Progress') {
        $mainSupervisorScore = 10;
        $jointSupervisorScore = 5;
        $pbasScore = ($mainSupervisorScore + $jointSupervisorScore);
    }
} elseif ($degree != '' && $current_status_of_work == 'Completed') {
    $mainSupervisorScore = 5;
    $jointSupervisorScore = 3;
    $pbasScore = ($mainSupervisorScore + $jointSupervisorScore);
}
$sql = "INSERT INTO guidance (cat3_id,subcat_3, employee_id, name_of_university, degree, degree_award_date, student_name, enrollment_no, project_title, project_year, project_type, thesis_submission_date, current_status_of_work, pbas_score) 
        VALUES ('$category','$subcategory_id', '$employee_id', '$name_of_university', '$degree', '$degree_award_date', '$student_name', '$enrollment_no', '$project_title', '$project_year', '$project_type', '$thesis_submission_date', '$current_status_of_work', '$pbasScore')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
    // echo "Data stored successfully. PBAS Score: $pbasScore";
}

mysqli_close($conn);
?>