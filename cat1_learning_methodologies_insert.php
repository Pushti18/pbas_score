<?php
// session_start();
// include("db_connection.php");

// $employee_id = $_SESSION['employee_id'];
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     $pbasYear = $_POST['pbasYear'];
//     $courseName = $_POST['courseName'];
//     $natureOfInnovation = $_POST['natureOfInnovation'];
//     $hoursSpentInnovation = $_POST['hoursSpentInnovation'];
//     $documentInnovation = $_FILES['documentInnovation']['name'];
//     $documentInnovation_temp = $_FILES['documentInnovation']['tmp_name'];

//     $target_dir = "uploads/";
//     $target_file = $target_dir . basename($documentInnovation);
//     move_uploaded_file($documentInnovation_temp, $target_file);

//     $sql = "INSERT INTO learning_methodologies (employee_id, pbasYear, courseName, natureOfInnovation, hoursSpentInnovation, documentInnovation) 
//             VALUES (?, ?, ?, ?, ?, ?)";

//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("iisiss", $employee_id, $pbasYear, $courseName, $natureOfInnovation, $hoursSpentInnovation, $documentInnovation);

//     if ($stmt->execute()) {
//         echo "Data inserted successfully.";
//     } else {
//         echo "Error: " . $stmt->error;
//     }

//     $stmt->close();
//     $conn->close();
// }


session_start();
include("db_connection.php");

// Handle form data
$employee_id = $_POST['employee_id'];
$pbasYear = $_POST['pbasYear'];
$courseName = $_POST['courseName'];
$natureOfInnovation = $_POST['natureOfInnovation'];
$hoursSpentInnovation = $_POST['hoursSpentInnovation'];

// Handle file upload
// $targetDirectory = "uploads/"; // Specify the directory where you want to store uploaded files
// $targetFile = $targetDirectory . basename($_FILES["documentInnovation"]["name"]);
// $uploadOk = 1;
// $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

// // Check file size
// if ($_FILES["documentInnovation"]["size"] > 5000000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }

// // Allow certain file formats
// if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
//     echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
//     $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//     echo "Sorry, your file was not uploaded.";
// // If everything is ok, try to upload file
// } else {
//     if (move_uploaded_file($_FILES["documentInnovation"]["tmp_name"], $targetFile)) {
//         echo "The file ". htmlspecialchars( basename( $_FILES["documentInnovation"]["name"])). " has been uploaded.";
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }
// }
// Calculate points based on hours spent in innovation
// Calculate points based on hours spent in innovation
$hours = intval($hoursSpentInnovation); // Convert hours to integer
$points = 0; // Initialize points
if ($hours >= 10) {
    // Calculate points: 1 point for every 10 hours
    $points = floor($hours / 10);
}
// Insert data into the database
$sql = "INSERT INTO learning_methodologies (employee_id, pbasYear, courseName, natureOfInnovation, hoursSpentInnovation, documentInnovation, points) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isisssi", $employee_id, $pbasYear, $courseName, $natureOfInnovation, $hoursSpentInnovation, $targetFile, $points);
$stmt->execute();
$stmt->close();


// Insert data into the database
// $sql = "INSERT INTO learning_methodologies (employee_id, pbasYear, courseName, natureOfInnovation, hoursSpentInnovation, documentInnovation, points) 
//         VALUES (?, ?, ?, ?, ?, ?)";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("isisss", $employee_id, $pbasYear, $courseName, $natureOfInnovation, $hoursSpentInnovation, $targetFile,$points);
// $stmt->execute();
// $stmt->close();

$conn->close();
?>


