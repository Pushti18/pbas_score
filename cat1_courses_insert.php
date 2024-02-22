<?php
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $pbasYear = $_POST['pbasYear'];
    $courseName = $_POST['courseName'];
    $detailofuploadedsubject = $_POST['detailofuploadedsubject'];
    $hoursSpentInnovation = $_POST['hoursSpentInnovation'];
    $documentInnovation = $_FILES['documentInnovation']['name']; // Store only the filename

    // Calculate points
    $points = 0;
    if ($hoursSpentInnovation >= 10) {
        $points = floor($hoursSpentInnovation / 10);
    }
    
    $target_dir = "uploads/";  // Adjust this directory as needed
    $target_file = $target_dir . basename($_FILES["documentInnovation"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Perform file validation checks (similar to previous code)

    // Check if $uploadOk is set to false by an error
    if ($uploadOk === false) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["documentInnovation"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["documentInnovation"]["name"]) . " has been uploaded.";

            $sql = "INSERT INTO courses (employee_id, pbasYear, courseName, detailofuploadedsubject, hoursSpentInnovation, documentInnovation, points) 
                    VALUES ('$employee_id', '$pbasYear', '$courseName', '$detailofuploadedsubject', '$hoursSpentInnovation', '$documentInnovation', '$points')";

            if (mysqli_query($conn, $sql)) {
                echo "Data inserted into courses table successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}

mysqli_close($conn);
?>