<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat2'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';


$employee_id = $_SESSION['employee_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $pbasYear = $_POST['pbasYear'];
    $mainActivity = $_POST['mainActivity'];
    $subActivity = $_POST['subActivity'];
    $activityTitle = $_POST['activityTitle'];
    $briefRole = $_POST['briefRole'];
    $semester = $_POST['semester'];
    $hoursSpentAnswerBook = $_POST['hoursSpentAnswerBook'];
    $attachment = $_POST['attachment'];
    $description = $_POST['description'];
    $attachment = $_FILES['attachment']['name'];
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

        $sql = "INSERT INTO othercocurricular (cat2_id,subcat_2, employee_id, pbasYear, mainActivity, subActivity, activityTitle, briefRole, semester, hoursSpentAnswerBook, attachment, description,points)
            VALUES ('$category','$subcategory_id','$employee_id', '$pbasYear', '$mainActivity', '$subActivity', '$activityTitle', '$briefRole', '$semester', '$hoursSpentAnswerBook', '$attachment', '$description','$points')";

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