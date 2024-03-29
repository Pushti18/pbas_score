<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM courses WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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
    $courseName = mysqli_real_escape_string($conn, $_POST["editcourseName"]);
    $detailofuploadedsubject = mysqli_real_escape_string($conn, $_POST["editdetailofuploadedsubject"]);
    $hoursSpentInnovation = mysqli_real_escape_string($conn, $_POST["edithoursSpentInnovation"]);

    // Check if files are uploaded and handle them if necessary
    $documentInnovation = handleFileUpload('editdocumentInnovation', $entryData['documentInnovation']);
    $uploadexecutive = handleFileUpload('edituploadexecutive', $entryData['uploadexecutive']);

    // Convert hours to integer
    $hours = intval($hoursSpentInnovation);
    // Initialize points
    $points = 0;
    if ($hours >= 10) {
        // Calculate points: 1 point for every 10 hours
        $points = floor($hours / 10);
    }

    // Prepare the SQL update query
    $sql = "UPDATE courses SET 
        pbasYear = '$pbasYear', 
        courseName = '$courseName', 
        detailofuploadedsubject = '$detailofuploadedsubject', 
        hoursSpentInnovation = '$hoursSpentInnovation', 
        points = '$points'";

    // Add file names to the SQL query if they are not empty
    if ($documentInnovation !== '') {
        $sql .= ", documentInnovation = '$documentInnovation'";
    }
    if ($uploadexecutive !== '') {
        $sql .= ", uploadexecutive = '$uploadexecutive'";
    }

    // Add the WHERE clause
    $sql .= " WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
function handleFileUpload($fieldName, $existingFileName)
{
    if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        // File uploaded successfully
        $targetDir = "uploads/"; // Replace with your desired upload directory
        $targetFile = $targetDir . basename($_FILES[$fieldName]["name"]);

        // Check if file already exists
        if (file_exists($targetFile)) {
            // Generate a unique file name if necessary
            $targetFile = $targetDir . uniqid() . "_" . basename($_FILES[$fieldName]["name"]);
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES[$fieldName]["tmp_name"], $targetFile)) {
            // File uploaded successfully, return the new file name
            return $targetFile;
        } else {
            // Error uploading file
            echo "Sorry, there was an error uploading your file.";
            return '';
        }
    } else {
        // No file uploaded, return the existing file name
        return $existingFileName;
    }
}
// Function to handle file uploads
// function handleFileUpload($fieldName, $existingFileName)
// {
//     if ($_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
//         // File uploaded successfully
//         $targetDir = "uploads/"; // Replace with your desired upload directory
//         $targetFile = $targetDir . basename($_FILES[$fieldName]["name"]);

//         // Check if file already exists
//         if (file_exists($targetFile)) {
//             // Generate a unique file name if necessary
//             $targetFile = $targetDir . uniqid() . "_" . basename($_FILES[$fieldName]["name"]);
//         }

//         // Move uploaded file to the target directory
//         if (move_uploaded_file($_FILES[$fieldName]["tmp_name"], $targetFile)) {
//             // File uploaded successfully, return the new file name
//             return $targetFile;
//         } else {
//             // Error uploading file
//             echo "Sorry, there was an error uploading your file.";
//             return '';
//         }
//     } else {
//         // No file uploaded, retain the existing value from the database
//         return $existingFileName;
//     }
// }
?>