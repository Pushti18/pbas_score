<?php
session_start();
include ("db_connection.php");

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
    // echo ($grant_amount);
    $existingFileName = $_POST['editAttachment'];
    $newFileName = $_FILES['editAttachment']['name'];

    // Check if a new file is uploaded
    if ($newFileName) {
        // New file has been uploaded; handle the file upload and store the new file name
        $newFilePath = "uploads/" . $newFileName;
        // Move the uploaded file to the target location
        move_uploaded_file($_FILES['editAttachment']['tmp_name'], $newFilePath);
        $attachment = $newFileName; // Use the new file name
    } else {
        // No new file has been uploaded; keep the existing file
        $attachment = $existingFileName;
    }
    $sql = "UPDATE research SET  project_category = '$project_category',title =  '$title', project_for = '$project_for', pbas_year ='$pbas_year', project_duration ='$project_duration', funding_agency='$funding_agency', grant_amount='$grant_amount' ";


    if ($newFileName) {
        $sql .= ", attachment = '$attachment'";
    }
    $sql .= " WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";


    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
        // echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>