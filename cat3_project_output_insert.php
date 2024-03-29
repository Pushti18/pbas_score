<?php
session_start();
include ("db_connection.php");
$category = $_SESSION['cat3'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];

$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';
$project_outcome = isset($_POST['projectOutcome']) ? $_POST['projectOutcome'] : '';
$region = isset($_POST['region']) ? $_POST['region'] : '';
$details_of_outcome = isset($_POST['detailsOfOutcome']) ? $_POST['detailsOfOutcome'] : '';
$patent_register = isset($_POST['patentRegister']) ? $_POST['patentRegister'] : '';

global $conn;

$pbasScore = 0;

if ($patent_register == 'Yes') {
    switch ($region) {
        case 'International':
            $pbasScore = 30;
            break;
        case 'National':
            $pbasScore = 20;
            break;
        case 'International Bodies':
            $pbasScore = 30;
            break;
        case 'Central Government Bodies':
            $pbasScore = 20;
            break;
        case 'State Government Bodies':
            $pbasScore = 10;
            break;
        case 'Local':
            $pbasScore = 5;
            break;
        default:
            break;
    }
} elseif ($project_outcome == 'Major Policy document') {
    switch ($region) {
        case 'International Bodies':
            $pbasScore = 30;
            break;
        case 'Central Government Bodies':
            $pbasScore = 20;
            break;
        case 'State Government Bodies':
            $pbasScore = 10;
            break;
        case 'Local':
            $pbasScore = 5;
            break;
        default:
            break;
    }
}

$sql = "INSERT INTO project_output (cat3_id,subcat_3, employee_id, pbas_year, title, project_outcome, region, details_of_outcome, patent_register, pbas_score) 
        VALUES ('$category','$subcategory_id', '$employee_id', '$pbas_year', '$title', '$project_outcome', '$region', '$details_of_outcome', '$patent_register', '$pbasScore')";
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