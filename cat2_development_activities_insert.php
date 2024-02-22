<?php
session_start();
include("db_connection.php");
$cat2_id = $_SESSION['cat2_id']; 
$employee_id = $_SESSION['employee_id']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pbasYear = $_POST['pbasYear'];
    $mainActivity = $_POST['mainActivity'];
    $subActivity = $_POST['subActivity'];
    $activityTitle = $_POST['activityTitle'];
    $briefRole = $_POST['briefRole'];
    $semester = $_POST['semester'];
    $hoursSpentAnswerBook = $_POST['hoursSpentAnswerBook'];
    $attachment = $_FILES['attachment']['name'];
    $description = $_POST['description'];
    $points = 0;
    if ($hoursSpentAnswerBook >= 10) {
        $points = floor($hoursSpentAnswerBook / 10);
    }
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        // File uploaded successfully

    $sql = "INSERT INTO development_activities (cat2_id, employee_id, pbasYear, mainActivity, subActivity, activityTitle, briefRole, semester, hoursSpentAnswerBook, attachment, description,points)
            VALUES ('$cat2_id', '$employee_id', '$pbasYear', '$mainActivity', '$subActivity', '$activityTitle', '$briefRole', '$semester', '$hoursSpentAnswerBook', '$attachment', '$description','$points')";

    mysqli_query($conn, $sql);

    if (mysqli_error($conn)) {
        echo "Error: " . mysqli_error($conn);
    } else {
        echo "Data inserted into discipline table successfully.";
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}

mysqli_close($conn);
} else {
echo "Invalid request method.";
}
?>