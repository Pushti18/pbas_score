<?php
session_start();
include("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM publication WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);
    echo ($sql);
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
    $region = mysqli_real_escape_string($conn, $_POST["editregion"]);
    $type = mysqli_real_escape_string($conn, $_POST["edittype"]);
    $title = mysqli_real_escape_string($conn, $_POST["edittitle"]);
    $author = mysqli_real_escape_string($conn, $_POST["editauthor"]);
    $role = mysqli_real_escape_string($conn, $_POST["editrole"]);
    $publication_group = mysqli_real_escape_string($conn, $_POST["editpublication_group"]);
    $journalTitle = mysqli_real_escape_string($conn, $_POST["editjournalTitle"]);
    $coAuthor = mysqli_real_escape_string($conn, $_POST["editcoAuthor"]);
    $month = mysqli_real_escape_string($conn, $_POST["editmonth"]);
    $year = mysqli_real_escape_string($conn, $_POST["edityear"]);
    $publisher = mysqli_real_escape_string($conn, $_POST["editpublisher"]);
    $pubDate = mysqli_real_escape_string($conn, $_POST["editpubDate"]);
    $volume = mysqli_real_escape_string($conn, $_POST["editvolume"]);
    $page = mysqli_real_escape_string($conn, $_POST["editpage"]);
    $current_status_of_work = mysqli_real_escape_string($conn, $_POST["editcurrent_status_of_work"]);




    $sql = "UPDATE publication SET pbasYear = '$pbasYear', mentorName='$mentorName', studentNames='$studentNames', outcomeMentoring='$outcomeMentoring', hoursSpent='$hoursSpent', points='$points' WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    echo $sql;

    if (mysqli_query($conn, $sql)) {
        echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>