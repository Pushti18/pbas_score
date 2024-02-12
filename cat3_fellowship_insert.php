<?php
session_start();
include("db_connection.php");
$cat3_id = $_SESSION['cat3_id']; 
$employee_id = $_SESSION['employee_id']; 

$title = isset($_POST['title']) ? $_POST['title'] : '';
$associated_organization = isset($_POST['associatedOrganization']) ? $_POST['associatedOrganization'] : '';
$fellowship_awards = isset($_POST['fellowshipAwards']) ? $_POST['fellowshipAwards'] : '';
$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';
$award_fellowship_copy = isset($_FILES['awardFellowshipCopy']['name']) ? $_FILES['awardFellowshipCopy']['name'] : '';

global $conn;

$pbasScore = 0;

if (strpos($fellowship_awards, 'International') !== false) {
    $pbasScore = 15;
} elseif (strpos($fellowship_awards, 'National') !== false) {
    $pbasScore = 10;
} elseif (strpos($fellowship_awards, 'StateUniversity') !== false) {
    $pbasScore = 5;
}

$sql = "INSERT INTO fellowship (cat3_id, employee_id, title, associated_organization, fellowship_awards, pbas_year, award_fellowship_copy, pbas_score) 
        VALUES ('$cat3_id', '$employee_id', '$title', '$associated_organization', '$fellowship_awards', '$pbas_year', '$award_fellowship_copy', '$pbasScore')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data stored successfully. PBAS Score: $pbasScore";
}

mysqli_close($conn);
?>