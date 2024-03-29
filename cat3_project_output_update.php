<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM project_output WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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

    $pbas_year = mysqli_real_escape_string($conn, isset($_POST['editpbasYear']) ? $_POST['editpbasYear'] : '');
    $title = mysqli_real_escape_string($conn, isset($_POST['edittitle']) ? $_POST['edittitle'] : '');
    $project_outcome = mysqli_real_escape_string($conn, isset($_POST['editprojectOutcome']) ? $_POST['editprojectOutcome'] : '');
    $region = mysqli_real_escape_string($conn, isset($_POST['editregion']) ? $_POST['editregion'] : '');
    $details_of_outcome = mysqli_real_escape_string($conn, isset($_POST['editdetailsOfOutcome']) ? $_POST['editdetailsOfOutcome'] : '');
    $patent_register = mysqli_real_escape_string($conn, isset($_POST['editpatentRegister']) ? $_POST['editpatentRegister'] : '');

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



    $sql = "UPDATE project_output SET  pbas_year='$pbas_year', title='$title', project_outcome='$project_outcome', region='$region', details_of_outcome='$details_of_outcome', patent_register='$patent_register', pbas_score='$pbasScore' 
    WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";

    echo $sql;

    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
        // echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>