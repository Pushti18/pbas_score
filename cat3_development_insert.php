<?php
session_start();
include("db_connection.php");
$cat3_id = $_SESSION['cat3_id']; 
$employee_id = $_SESSION['employee_id']; 

$title = isset($_POST['title']) ? $_POST['title'] : '';
$research_type = isset($_POST['researchType']) ? $_POST['researchType'] : '';
$sponsor_type = isset($_POST['sponserType']) ? $_POST['sponserType'] : '';
$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';
$attachment = isset($_FILES['attachment']['name']) ? $_FILES['attachment']['name'] : '';
$executive_summary = isset($_FILES['executiveSummary']['name']) ? $_FILES['executiveSummary']['name'] : '';

if ($researchType === "R&D") {
    $pbasScore += 10;
}
if ($sponserType === "Consultancy") {
    $pbasScore += 5;
}
$target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        // File uploaded successfully

$sql = "INSERT INTO development (cat3_id, employee_id, title, research_type, sponsor_type, remarks, pbas_year, upload_documents, executive_summary,pbas_score) 
        VALUES ('$cat3_id', '$employee_id', '$title', '$research_type', '$sponsor_type', '$remarks', '$pbas_year', '$attachment', '$executive_summary','$pbasScore')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data stored successfully.";
}
mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>