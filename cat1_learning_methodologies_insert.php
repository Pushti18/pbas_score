<?php
session_start();
include("db_connection.php");

$category = $_SESSION['cat1'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

// Handle form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['employee_id'];

    $pbasYear = $_POST['pbasYear'];
    $courseName = $_POST['courseName'];
    $natureOfInnovation = $_POST['natureOfInnovation'];
    $hoursSpentInnovation = $_POST['hoursSpentInnovation'];
    $attachment = $_FILES['attachment']['name']; // Store only the filename

    $hours = intval($hoursSpentInnovation); // Convert hours to integer
    $points = 0; // Initialize points
    if ($hours >= 10) {
        // Calculate points: 1 point for every 10 hours
        $points = floor($hours / 10);
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        // File uploaded successfully

        // Insert data into the database
        $sql = "INSERT INTO learning_methodologies (cat1_id,subcat_1,employee_id, pbasYear, courseName, natureOfInnovation, hoursSpentInnovation, attachment, points) 
                VALUES ('$category','$subcategory_id','$employee_id', '$pbasYear', '$courseName', '$natureOfInnovation', '$hoursSpentInnovation', '$attachment', '$points')";
        echo $sql;
        if (mysqli_query($conn, $sql)) {
            echo "Data inserted into learning_methodologies table successfully.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>