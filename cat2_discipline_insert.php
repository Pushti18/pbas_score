<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';

global $conn;

// Function to fetch category and subcategory IDs from cat2 table
function fetch_ids($conn, $category_title, $subcategory_title)
{
    $sql_fetch_ids = "SELECT category_id, subcategory_id FROM cat2 WHERE category_title = '$category_title' AND subcategory_title = '$subcategory_title'";
    $result_ids = mysqli_query($conn, $sql_fetch_ids);

    if (!$result_ids) {
        die("Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_ids) > 0) {
        $row = mysqli_fetch_assoc($result_ids);
        return [
            'category_id' => $row['category_id'],
            'subcategory_id' => $row['subcategory_id'],
        ];
    } else {
        return false;
    }
}
$category = $_SESSION['cat2'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $employee_id = $_SESSION['employee_id'];
    $pbasYear = $_POST['pbasYear'];
    $mainActivity = $_POST['mainActivity'];
    $subActivity = $_POST['subActivity'];
    $activityTitle = $_POST['activityTitle'];
    $briefRole = $_POST['briefRole'];
    $semester = $_POST['semester'];
    $hoursSpentAnswerBook = $_POST['hoursSpentAnswerBook'];
    $description = $_POST['description'];
    $attachment = $_FILES['attachment']['name'];
    // Handle file upload
    // $targetDirectory = "uploads/";
    // $attachment = $_FILES['attachment']['name']; // Updated this line
    // $attachment_tmp = $_FILES['attachment']['tmp_name'];
    // $targetFile = $targetDirectory . basename($attachment);
    $points = 0;
    if ($hoursSpentAnswerBook >= 10) {
        $points = floor($hoursSpentAnswerBook / 10);
    }
    // Move uploaded file to target directory
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        // File uploaded successfully

        // if (move_uploaded_file($attachment_tmp, $targetFile)) {
        // File uploaded successfully, now insert data into the database
        // $sql = "INSERT INTO discipline (employee_id, pbasYear, mainActivity, subActivity, activityTitle, briefRole, semester, hoursSpentAnswerBook, attachment, description,points)
        //         VALUES ('$employee_id', '$pbasYear', '$mainActivity', '$subActivity', '$activityTitle', '$briefRole','$semester', '$hoursSpentAnswerBook', '$attachment', '$description','$points')";
        //         mysqli_query($conn, $sql);
        $sql = "INSERT INTO discipline (cat2_id,subcat_2,employee_id, pbasYear, mainActivity, subActivity, activityTitle, briefRole, semester, hoursSpentAnswerBook, attachment, description, points, category_id, subcategory_id)
                VALUES ('$category','$subcategory_id','{$_SESSION['employee_id']}', '$pbasYear', '$mainActivity', '$subActivity', '$activityTitle', '$briefRole','$semester', '$hoursSpentAnswerBook', '$attachment', '$description','$points', '$fetched_category_id', '$fetched_subcategory_id')";
        mysqli_query($conn, $sql);

        if (mysqli_error($conn)) {
            echo "Error: " . mysqli_error($conn);
        } else {
            echo "Data stored successfully. PBAS Score: $pbasScore";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>