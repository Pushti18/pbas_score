<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat2'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];


    $sql = "DELETE FROM othercocurricular WHERE id = '$id' AND employee_id='$employee_id' and cat2_id = '$category'";
    echo $sql;
    if (mysqli_query($conn, $sql)) {
        echo "Entry deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>