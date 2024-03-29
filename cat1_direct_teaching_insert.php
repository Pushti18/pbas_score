<?php
session_start();
include ("db_connection.php");
$category = $_SESSION['cat1'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['employee_id'];
    $university = $_POST['university'];
    $year = $_POST['year'];
    $enroll = $_POST['enroll'];
    $pbasYear = $_POST['pbasYear'];
    $subDate = $_POST['submissionDate'];
    $hoursSpent = $_POST['hoursSpent'];
    $degree = $_POST['degree'];
    $studentName = $_POST['studentName'];
    $projectTitle = $_POST['projectTitle'];
    $projectType = $_POST['projectType'];
    $statusofwork = $_POST['statusofwork'];
    $attachment = $_FILES['attachment'];

    $points = 0;
    if ($hoursSpent >= 10) {
        $points = floor($hoursSpent / 10);
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        // File uploaded successfully

        // SQL query to insert data
        $sql = "INSERT INTO direct_teaching (cat1_id,subcat_1,employee_id, university, year, enroll, pbasYear, submissionDate, hoursSpent, degree, studentName, projectTitle, projectType, statusofwork, points, attachment) 
                VALUES ('$category','$subcategory_id','$employee_id', '$university', '$year', '$enroll', '$pbasYear', '$subDate', '$hoursSpent', '$degree', '$studentName', '$projectTitle', '$projectType', '$statusofwork', '$points', '$target_file')";

        if (mysqli_query($conn, $sql)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
            // echo "Data inserted into direct_teaching table successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>