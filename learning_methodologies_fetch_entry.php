<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM learning_methodologies WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $entryData = mysqli_fetch_assoc($result);
        echo json_encode($entryData);
    } else {
        echo "No data found for the given entry ID.";
    }
}

// Updating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $entryId = $_POST["entry_id"];
    $pbasYear = mysqli_real_escape_string($conn, $_POST["editPbasYear"]);
    $courseName = mysqli_real_escape_string($conn, $_POST["editCourseName"]);
    $natureOfInnovation = mysqli_real_escape_string($conn, $_POST["editNatureOfInnovation"]);
    $hoursSpentInnovation = mysqli_real_escape_string($conn, $_POST["editHoursSpentInnovation"]);
    $hours = intval($hoursSpentInnovation); // Convert hours to integer
    $points = 0; // Initialize points
    if ($hours >= 10) {
        // Calculate points: 1 point for every 10 hours
        $points = floor($hours / 10);
    }
    $sql = "UPDATE learning_methodologies SET pbasYear = '$pbasYear', courseName = '$courseName', natureOfInnovation = '$natureOfInnovation', hoursSpentInnovation = '$hoursSpentInnovation', points='$points' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    echo $sql;
    // if (isset($_FILES["editAttachment"]) && $_FILES["editAttachment"]["error"] == UPLOAD_ERR_OK) {
    //     $file = file_get_contents($_FILES["editAttachment"]["tmp_name"]);
    //     $file_name = basename($_FILES["editAttachment"]["name"]);

    //     // Update the entry with the new file
    // } else {
    //     // Update the entry without changing the file
    //     $sql = "UPDATE learning_methodologies SET pbasYear = '$pbasYear', courseName = '$courseName', natureOfInnovation = '$natureOfInnovation', hoursSpentInnovation = '$hoursSpentInnovation', attachment = '$file', points='$points' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    // }
    // $sql = "UPDATE learning_methodologies SET pbasYear = '$pbasYear', courseName = '$courseName', natureOfInnovation = '$natureOfInnovation', hoursSpentInnovation = '$hoursSpentInnovation' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>