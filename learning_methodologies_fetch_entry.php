<?php
session_start();
include ("db_connection.php");

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

    // Calculate points
    $points = 0; // Initialize points
    if ($hours >= 10) {
        // Calculate points: 1 point for every 10 hours
        $points = floor($hours / 10);
    }

    // Update the database
    $sql = "UPDATE learning_methodologies SET 
        pbasYear = '$pbasYear', 
        courseName = '$courseName', 
        natureOfInnovation = '$natureOfInnovation', 
        hoursSpentInnovation = '$hoursSpentInnovation', 
        points = '$points'";

    // Only update the attachment field if a new file was uploaded
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