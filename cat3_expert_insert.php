<?php
session_start();
include ("db_connection.php");
$category = $_SESSION['cat3'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic = isset($_POST['topic']) ? $_POST['topic'] : '';
    $lecture_detail = isset($_POST['lectureDetail']) ? $_POST['lectureDetail'] : '';
    $institute_name = isset($_POST['instituteName']) ? $_POST['instituteName'] : '';
    $date_to_talk = isset($_POST['dateToTalk']) ? $_POST['dateToTalk'] : '';
    $talk_level = isset($_POST['talkLevel']) ? $_POST['talkLevel'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $attachment = isset($_FILES['attachment']['name']) ? $_FILES['attachment']['name'] : '';
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

    $sql = "INSERT INTO expert (cat3_id,subcat_3, employee_id,topic, lecture_detail, institute_name, date_to_talk, talk_level, type,  pbas_year, pbas_score)VALUES ('$category', '$subcategory_id', '$employee_id', '$topic', '$lecture_detail','$institute_name', '$date_to_talk', '$talk_level', '$type', '$pbas_year', '$pbasScore')";
    mysqli_query($conn, $sql);
    echo ($sql);
    if (mysqli_error($conn)) {
        echo "Error: " . mysqli_error($conn);
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
        // echo "Data stored successfully.";
    }
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>