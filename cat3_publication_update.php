<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM publication WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);
    // echo ($sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $entryData = mysqli_fetch_assoc($result);
        echo json_encode($entryData);
    } else {
        echo "No data found for the given entry ID.";
    }
}


// Updating data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entryId = $_POST["entry_id"];
    $region = mysqli_real_escape_string($conn, $_POST["editregion"] ? $_POST["editregion"] : '');
    $type = mysqli_real_escape_string($conn, $_POST["edittype"] ? $_POST["edittype"] : '');
    $title = mysqli_real_escape_string($conn, $_POST["edittitle"] ? $_POST["edittitle"] : '');
    $author = mysqli_real_escape_string($conn, $_POST["editauthor"] ? $_POST["editauthor"] : '');
    $role = mysqli_real_escape_string($conn, $_POST["editrole"] ? $_POST["editrole"] : '');
    $publication_group = mysqli_real_escape_string($conn, $_POST["editpublication_group"] ? $_POST["editpublication_group"] : '');
    $journalTitle = mysqli_real_escape_string($conn, $_POST["editjournalTitle"] ? $_POST["editjournalTitle"] : '');
    $coAuthor = mysqli_real_escape_string($conn, $_POST["editcoAuthor"] ? $_POST["editcoAuthor"] : '');
    $month = mysqli_real_escape_string($conn, $_POST["editmonth"] ? $_POST["editmonth"] : '');
    $year = mysqli_real_escape_string($conn, $_POST["edityear"] ? $_POST["edityear"] : '');
    $publisher = mysqli_real_escape_string($conn, $_POST["editpublisher"] ? $_POST["editpublisher"] : '');
    $pubDate = mysqli_real_escape_string($conn, $_POST["editpubDate"] ? $_POST["editpubDate"] : '');
    $volume = mysqli_real_escape_string($conn, $_POST["editvolume"] ? $_POST["editvolume"] : '');
    $page = mysqli_real_escape_string($conn, $_POST["editpage"] ? $_POST["editpage"] : '');
    $current_status_of_work = mysqli_real_escape_string($conn, $_POST["editcurrent_status_of_work"] ? $_POST["editcurrent_status_of_work"] : '');
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

    $sql = "UPDATE publication SET  region='$region', type='$type', title='$title', author='$author', role='$role', publication_group='$publication_group', 
    journal_title='$journalTitle', co_author='$coAuthor', month_of_publication='$month', year_of_publication='$year', publisher='$publisher', publication_date='$pubDate', 
    volume_no='$volume', page_no='$page',current_status_of_work='$current_status_of_work'";
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