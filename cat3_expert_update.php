<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM expert WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
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

    $topic = mysqli_real_escape_string($conn, isset($_POST['edittopic']) ? $_POST['edittopic'] : '');
    $lecture_detail = mysqli_real_escape_string($conn, isset($_POST['editlectureDetail']) ? $_POST['editlectureDetail'] : '');
    $institute_name = mysqli_real_escape_string($conn, isset($_POST['editinstituteName']) ? $_POST['editinstituteName'] : '');
    $date_to_talk = mysqli_real_escape_string($conn, isset($_POST['editdateToTalk']) ? $_POST['editdateToTalk'] : '');
    $talk_level = mysqli_real_escape_string($conn, isset($_POST['edittalkLevel']) ? $_POST['edittalkLevel'] : '');
    $type = mysqli_real_escape_string($conn, isset($_POST['edittype']) ? $_POST['edittype'] : '');
    $pbas_year = mysqli_real_escape_string($conn, isset($_POST['editpbasYear']) ? $_POST['editpbasYear'] : '');

    if ($talk_level === "International" && $type === "Lecture") {
        $pbasScore = 7;
    } elseif ($talk_level === "International" && $type === "Paper") {
        $pbasScore = 5;
    } elseif ($talk_level === "National" && $type === "Lecture") {
        $pbasScore = 5;
    } elseif ($talk_level === "National" && $type === "Paper") {
        $pbasScore = 3;
    } elseif ($talk_level === "State" && $type === "Lecture") {
        $pbasScore = 3;
    } elseif ($talk_level === "State" && $type === "Paper") {
        $pbasScore = 2;
    } else {
        $pbasScore = 0;
    }

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
    $sql = "UPDATE expert SET  topic='$topic', lecture_detail='$lecture_detail', institute_name='$institute_name', date_to_talk='$date_to_talk', talk_level='$talk_level', type='$type',  pbas_year='$pbas_year', pbas_score ='$pbasScore'
    ";

    if ($newFileName) {
        $sql .= ", talk_proof = '$attachment'";
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