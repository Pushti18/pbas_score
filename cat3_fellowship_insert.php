<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat3'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];

$title = isset($_POST['title']) ? $_POST['title'] : '';
$associated_organization = isset($_POST['associatedOrganization']) ? $_POST['associatedOrganization'] : '';
$fellowship_awards = isset($_POST['fellowshipAwards']) ? $_POST['fellowshipAwards'] : '';
$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';
$award_fellowship_copy = isset($_FILES['awardFellowshipCopy']['name']) ? $_FILES['awardFellowshipCopy']['name'] : '';
// $attachment = $_FILES['attachment']['name'];
global $conn;

$pbasScore = 0;

if (strpos($fellowship_awards, 'International') !== false) {
    $pbasScore = 15;
} elseif (strpos($fellowship_awards, 'National') !== false) {
    $pbasScore = 10;
} elseif (strpos($fellowship_awards, 'StateUniversity') !== false) {
    $pbasScore = 5;
}
// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
// $uploadOk = true;
// $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
//     // File uploaded successfully

$sql = "INSERT INTO fellowship (cat3_id,subcat_3, employee_id, title, associated_organization, fellowship_awards, pbas_year, pbas_score) 
        VALUES ('$category','$subcategory_id','$employee_id', '$title', '$associated_organization', '$fellowship_awards', '$pbas_year',  '$pbasScore')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data stored successfully. PBAS Score: $pbasScore";
}
// } else {
//     echo "Invalid request method.";
// }
mysqli_close($conn);
?>