<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM discipline WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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

    $pbasYear = mysqli_real_escape_string($conn, $_POST["editpbasYear"]);
    $mainActivity = mysqli_real_escape_string($conn, $_POST["editmainActivity"]);
    $subActivity = mysqli_real_escape_string($conn, $_POST["editsubActivity"]);
    $activityTitle = mysqli_real_escape_string($conn, $_POST["editactivityTitle"]);
    $briefRole = mysqli_real_escape_string($conn, $_POST["editbriefRole"]);
    $semester = mysqli_real_escape_string($conn, $_POST["editsemester"]);
    $hoursSpentAnswerBook = mysqli_real_escape_string($conn, $_POST["edithoursSpentAnswerBook"]);
    $description = mysqli_real_escape_string($conn, $_POST["editdescription"]);

    $points = 0;
    if ($hoursSpentAnswerBook >= 10) {
        $points = floor($hoursSpentAnswerBook / 10);
    }
    $sql = "UPDATE discipline SET pbasYear='$pbasYear', mainActivity='$mainActivity', subActivity='$subActivity', activityTitle='$activityTitle', briefRole='$briefRole', semester='$semester', hoursSpentAnswerBook='$hoursSpentAnswerBook', description='$description', points='$points' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";


    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>