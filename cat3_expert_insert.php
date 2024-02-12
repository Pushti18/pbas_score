<?php
session_start();
include("db_connection.php");

$topic = isset($_POST['topic']) ? $_POST['topic'] : '';
$lecture_detail = isset($_POST['lectureDetail']) ? $_POST['lectureDetail'] : '';
$institute_name = isset($_POST['instituteName']) ? $_POST['instituteName'] : '';
$date_to_talk = isset($_POST['dateToTalk']) ? $_POST['dateToTalk'] : '';
$talk_level = isset($_POST['talkLevel']) ? $_POST['talkLevel'] : '';
$type = isset($_POST['type']) ? $_POST['type'] : '';
$talk_proof = isset($_FILES['talkProof']['name']) ? $_FILES['talkProof']['name'] : '';
$pbas_year = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';

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

$stmt = $conn->prepare("INSERT INTO expert (topic, lecture_detail, institute_name, date_to_talk, talk_level, type, talk_proof, pbas_year, pbas_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssi", $topic, $lecture_detail, $institute_name, $date_to_talk, $talk_level, $type, $talk_proof, $pbas_year, $pbasScore);
if ($stmt->execute()) {
    echo "Data stored successfully.";
} else {
    echo "Error: " . $stmt->error;
}

mysqli_close($conn);
?>