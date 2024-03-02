<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM fellowship WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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


    $title = mysqli_real_escape_string($conn, isset($_POST['edittitle']) ? $_POST['edittitle'] : '');
    $associated_organization = mysqli_real_escape_string($conn, isset($_POST['editassociatedOrganization']) ? $_POST['editassociatedOrganization'] : '');
    $fellowship_awards = mysqli_real_escape_string($conn, isset($_POST['editfellowshipAwards']) ? $_POST['editfellowshipAwards'] : '');
    $pbas_year = mysqli_real_escape_string($conn, isset($_POST['editpbasYear']) ? $_POST['editpbasYear'] : '');

    $pbasScore = 0;

    if (strpos($fellowship_awards, 'International') !== false) {
        $pbasScore = 15;
    } elseif (strpos($fellowship_awards, 'National') !== false) {
        $pbasScore = 10;
    } elseif (strpos($fellowship_awards, 'StateUniversity') !== false) {
        $pbasScore = 5;
    }
    $sql = "UPDATE fellowship SET  title='$title', associated_organization='$associated_organization', fellowship_awards='$fellowship_awards', pbas_year='$pbas_year', pbas_score='$pbasScore' 

    WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";




    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>