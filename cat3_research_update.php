<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM research WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $entryData = mysqli_fetch_assoc($result);
        echo json_encode($entryData);
    } else {
        echo "No data found for the given entry ID.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entryId = $_POST["entry_id"];

    $project_category = mysqli_real_escape_string($conn, isset($_POST["editprojectCategory"]) ? $_POST["editprojectCategory"] : '');

    $project_for = mysqli_real_escape_string($conn, isset($_POST["editprojectFor"]) ? $_POST["editprojectFor"] : '');
    $pbas_year = mysqli_real_escape_string($conn, isset($_POST["editpbasYear"]) ? $_POST["editpbasYear"] : '');
    $project_duration = mysqli_real_escape_string($conn, $_POST["editprojectDuration"]);
    $funding_agency = mysqli_real_escape_string($conn, $_POST["editfundingAgency"]);
    // $grant_amount = mysqli_real_escape_string($conn, isset($_POST["editgrantAmount"]) ? $_POST["editgrantAmount"] : '');
    $title = mysqli_real_escape_string($conn, $_POST["edittitle"]);
    // $grant_amount = mysqli_real_escape_string($conn, isset($_GET["editgrantAmount"]) ? $_GET["editgrantAmount"] : '');
    $grant_amount = mysqli_real_escape_string($conn, isset($_POST["editgrantAmount"]) ? $_POST["editgrantAmount"] : '');
    // var_dump($_POST["editgrantAmount"]);
    echo ($grant_amount);
    $sql = "UPDATE research SET  project_category = '$project_category',title =  '$title', project_for = '$project_for', pbas_year ='$pbas_year', project_duration ='$project_duration', funding_agency='$funding_agency', grant_amount='$grant_amount' 
    WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";



    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>