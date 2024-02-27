<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM mentoring WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $entryData = mysqli_fetch_assoc($result);
        echo json_encode($entryData);
    } else {
        echo "No data found for the given entry ID.";
    }
}

// Updating data
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Collect form data and sanitize inputs
//     $entryId = $_POST["entry_id"];
//     $pbasYear = mysqli_real_escape_string($conn, $_POST["editPbasYear"]);
//     $mentorName = mysqli_real_escape_string($conn, $_POST["editmentorName"]);
//     $studentNames = mysqli_real_escape_string($conn, $_POST["editstudentNames"]);
//     $outcomeMentoring = mysqli_real_escape_string($conn, $_POST["editoutcomeMentoring"]);
//     $hoursSpent = mysqli_real_escape_string($conn, $_POST["edithoursSpent"]);

//     $hours = intval($hoursSpent); // Convert hours to integer
//     $points = 0; // Initialize points
//     if ($hours >= 10) {
//         // Calculate points: 1 point for every 10 hours
//         $points = floor($hours / 10);
//     }
//     $sql = "UPDATE mentoring SET pbasYear = '$pbasYear', mentorName='$mentorName', studentNames='$studentNames', outcomeMentoring='$outcomeMentoring', hoursSpent='$hoursSpent', points='$points' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
//     echo $sql;

//     if (mysqli_query($conn, $sql)) {
//         echo "Entry updated successfully.";
//     } else {
//         echo "Error updating entry: " . mysqli_error($conn);
//     }
// }

// Updating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $entryId = $_POST["entry_id"];
    $pbasYear = mysqli_real_escape_string($conn, $_POST["editPbasYear"]);
    $mentorName = mysqli_real_escape_string($conn, $_POST["editmentorName"]);
    $studentNames = mysqli_real_escape_string($conn, $_POST["editstudentNames"]);
    $outcomeMentoring = mysqli_real_escape_string($conn, $_POST["editoutcomeMentoring"]);
    $hoursSpent = mysqli_real_escape_string($conn, $_POST["edithoursSpent"]);
    echo $pbasYear;
    $hours = intval($hoursSpent); // Convert hours to integer
    $points = 0; // Initialize points
    if ($hours >= 10) {
        // Calculate points: 1 point for every 10 hours
        $points = floor($hours / 10);
    }
    $sql = "UPDATE mentoring SET pbasYear = '$pbasYear', mentorName='$mentorName', studentNames='$studentNames', outcomeMentoring='$outcomeMentoring', hoursSpent='$hoursSpent', points='$points' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>