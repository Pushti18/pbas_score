<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];
    $sql = "SELECT * FROM othercocurricular WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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

    // $editattachment = handleFileUpload('editattachment', $entryData['attachment']);
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
    $points = 0;
    if ($hoursSpentAnswerBook >= 10) {
        $points = floor($hoursSpentAnswerBook / 10);
    }

    $sql = "UPDATE othercocurricular SET 
        pbasYear='$pbasYear', 
        mainActivity='$mainActivity', 
        subActivity='$subActivity', 
        activityTitle='$activityTitle', 
        briefRole='$briefRole', 
        semester='$semester', 
        hoursSpentAnswerBook='$hoursSpentAnswerBook', 
        description='$description', 
        points='$points'";

    // if ($editattachment !== '') {
    //     $sql .= ", attachment = '$editattachment'";
    // } else if (!empty($entryData['attachment'])) {
    //     // Explicitly retain the existing attachment if no new file is uploaded
    //     $sql .= ", attachment = '{$entryData['attachment']}'";
    // }

    if ($newFileName) {
        $sql .= ", attachment = '$attachment'";
    }

    // if ($editattachment !== '') {
    //     $sql .= ", attachment = '$editattachment'";
    // }

    $sql .= " WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";

    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
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
?>