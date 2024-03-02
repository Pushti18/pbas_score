<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM development WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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
    $research_type = mysqli_real_escape_string($conn, isset($_POST['editresearchType']) ? $_POST['editresearchType'] : '');
    $sponsor_type = mysqli_real_escape_string($conn, isset($_POST['editsponserType']) ? $_POST['editsponserType'] : '');
    $remarks = mysqli_real_escape_string($conn, isset($_POST['editremarks']) ? $_POST['editremarks'] : '');
    $pbas_year = mysqli_real_escape_string($conn, isset($_POST['editpbasYear']) ? $_POST['editpbasYear'] : '');
    $pbasScore = 0;
    if ($research_type === "RND") {
        $pbasScore += 10;
    }
    if ($research_type === "Consultancy") {
        $pbasScore += 5;
    }

    // $sql = "UPDATE development SET  title='$title', research_type='$research_type', sponsor_type='$sponsor_type', remarks='$remarks', pbas_year='$pbas_year', pbas_score'$pbasScore'
    // WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $sql = "UPDATE development SET  title='$title', research_type='$research_type', sponsor_type='$sponsor_type', remarks='$remarks', pbas_year='$pbas_year', pbas_score='$pbasScore' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";

    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>