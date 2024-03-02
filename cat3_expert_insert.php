<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat3'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];

$topic = isset($_POST['topic']) ? $_POST['topic'] : '';
$lecture_detail = isset($_POST['lectureDetail']) ? $_POST['lectureDetail'] : '';
$institute_name = isset($_POST['instituteName']) ? $_POST['instituteName'] : '';
$date_to_talk = isset($_POST['dateToTalk']) ? $_POST['dateToTalk'] : '';
$talk_level = isset($_POST['talkLevel']) ? $_POST['talkLevel'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$attachment = isset($_FILES['attachment']['name']) ? $_FILES['attachment']['name'] : '';
$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';

// $attachment = $_FILES['attachment']['name'];
global $conn;

echo "Talk Level: $talk_level, Type: $type";

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

echo "Calculated PBAS Score: $pbasScore";

print_r($pbasScore);
// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
// $uploadOk = true;
// $target_dir = "uploads/";
// $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
// $uploadOk = true;
// $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
//     // File uploaded successfully

$stmt = $conn->prepare("INSERT INTO expert (cat3_id,subcat_3, employee_id,topic, lecture_detail, institute_name, date_to_talk, talk_level, type,  pbas_year, pbas_score) VALUES (?,?,?,?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssi", $category, $subcategory_id, $employee_id, $topic, $lecture_detail, $institute_name, $date_to_talk, $talk_level, $type, $pbas_year, $pbasScore);
if ($stmt->execute()) {
    echo "Data stored successfully.";
} else {
    echo "Error: " . $stmt->error;
}
mysqli_close($conn);
// } else {
//     echo "Invalid request method.";
// }
?>