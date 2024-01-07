<?php
session_start();
include("db_connect.php");
$cat3_id = $_SESSION['cat3_id']; 
$employee_id = $_SESSION['employee_id']; 

$title = isset($_POST['title']) ? $_POST['title'] : '';
$research_type = isset($_POST['researchType']) ? $_POST['researchType'] : '';
$sponsor_type = isset($_POST['sponserType']) ? $_POST['sponserType'] : '';
$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';
$upload_documents = isset($_FILES['uploadDocuments']['name']) ? $_FILES['uploadDocuments']['name'] : '';
$executive_summary = isset($_FILES['executiveSummary']['name']) ? $_FILES['executiveSummary']['name'] : '';

if ($researchType === "R&D") {
    $pbasScore += 10;
}
if ($sponserType === "Sponsored") {
    $pbasScore += 5;
}
$sql = "INSERT INTO development (cat3_id, employee_id, title, research_type, sponsor_type, remarks, pbas_year, upload_documents, executive_summary,pbas_score) 
        VALUES ('$cat3_id', '$employee_id', '$title', '$research_type', '$sponsor_type', '$remarks', '$pbas_year', '$upload_documents', '$executive_summary','$pbasScore')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data stored successfully.";
}

mysqli_close($conn);

?>