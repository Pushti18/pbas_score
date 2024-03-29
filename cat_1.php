<?php
session_start();
include("db_connection.php");
global $conn;

if (isset($_GET['employee_id']) && isset($_SESSION['cat1'])) {
    $employee_id = $_GET['employee_id'];
    $category = $_SESSION["cat1"];
    echo ($category);
    // $query = "UPDATE `cat1` SET `employee_id` = $employee_id and `category_id` =  $category";
    // echo $query;
    // if (mysqli_query($conn, $query)) {
    //     // echo "Employee ID updated successfully in the database.";
    // } else {
    //     // echo "Error updating record: " . mysqli_error($conn);
    // }
    $_SESSION['employee_id'] = $employee_id;
    // $_SESSION['category_id'] = $category;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Categories - I</title>
    <?php require "./components/category-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="category-div main_div">
        <div class="category-container">
            <h1>CATEGORY : I - Teaching, Learning and Evaluation related activities</h1>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a
                    href="direct_teaching.php?category_title=Direct Teaching (Learning / Tutorial / Practical / Project Supervision / Field Work) - To give Semesterwise / Termwise details wherever necessary">
                    <strong>Category : I-A - Direct Teaching (Learning / Tutorial / Practical / Project Supervision /
                        Field Work) - To give Semesterwise / Termwise details wherever necessary </strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a
                    href="exam_duties.php?category_title=Examination duties (Invigilation, question paper setting, evaluation/assessment of answer scripts) as per allotment">
                    <strong>Category : II-B - Examination duties (Invigilation, question paper setting,
                        evaluation/assessment of answer scripts) as per allotment </strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <strong>Category : III-C - Innovative Teaching - Learning methodologies, Updating of subject contents /
                    courses, meentoring etc</strong>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="learning_methodologies.php?&subcategory_id=cat1_c1">
                    Category I-C(i) - Innovation Teaching - Learning methodologies
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="courses.php?&subcategory_id=cat1_c2">
                    Category I-C(ii) - Updating of subject contents /courses
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="mentoring.php?&subcategory_id=cat1_c3">
                    Category I-C(iii) - Mentoring
                </a>
            </div>
        </div>
    </div>
</body>

</html>