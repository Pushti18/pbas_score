<?php
    session_start();
    include("db_connect.php");
    global $conn;
    if (isset($_GET['employee_id'])) {
        $employee_id = $_GET['employee_id'];
        // Update the database table with the employee_id
        $query = "UPDATE `cat1` SET `employee_id` = $employee_id ";
    
        if (mysqli_query($conn, $query)) {
            echo "Employee ID updated successfully in the database.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    
        $_SESSION['employee_id'] = $employee_id;
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    <?php include 'css/ipr_output.css';
    ?>
    </style>
    <title>Faculty Details</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,100&display=swap"
        rel="stylesheet">
    <style>
    /* Add your CSS styles here */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .header_container {
        background-color: #21c8de;
        padding: 10px;
        text-align: center;
        color: white;
        margin-bottom: 20px;
    }

    .header_container img {
        max-width: 100%;
        height: auto;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        border: 2px solid #21c8de;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
    }

    h1 {
        color: #21c8de;
    }

    .category {
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
        display: flex;
        align-items: center;
    }

    .tick-circle-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #21c8de;
        /* Filled circle color */
        position: relative;
        margin-right: 10px;
        border: 2px solid #21c8de;
        /* Border color */
    }

    .tick-circle-icon::before {
        content: '\2713';
        /* Unicode character for a checkmark */
        font-size: 14px;
        /* Adjust the font size as needed */
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        /* Tick color */
    }

    .subcategory {
        border-bottom: 1px dashed #ccc;
        padding-left: 30px;
        padding-top: 10px;
        padding-bottom: 10px;
        display: flex;
        align-items: center;
    }
    </style>
    <title>Categories</title>
</head>

<body>
    <!-- <header class="header_container">
        <img class="mulogo_header" src="images/mu-logo-2.png" alt="MU logo">
        <h1 class="title">Faculty Details</h1>
        <img class="ictlogo_header" src="images/ICT_logo_text.png" alt="MU logo">
    </header> -->

    <div class="nav_div" style="background-color: lightblue; text-align: center;">
        <h2>PBAS(Performance Based Appraisal System)</h2>
    </div>

    <div class="container">

        <h1>CATEGORY : I - Teaching, Learning and Evaluation related activities</h1>

        <div class="category">
            <div class="tick-circle-icon"></div>
            <a href="direct_teaching.php?category_id=Category I-A&category_title=Direct Teaching (Learning / Tutorial / Practical / Project Supervision /
                    Field Work) - To give Semesterwise / Termwise details wherever necessary">
                <strong>Category : I-A - Direct Teaching (Learning / Tutorial / Practical / Project Supervision /
                    Field Work) - To give Semesterwise / Termwise details wherever necessary </strong>

            </a>
        </div>

        <div class="category">
            <div class="tick-circle-icon"></div>
            <a href="exam_duties.php?category_id=Category II-B&category_title=Examination duties (Invigilation, question
                    paper setting, evaluation/assessment of
                    answer scripts) as per allotment">
                <strong>Category : II-B - Examination duties (Invigilation, question
                    paper setting, evaluation/assessment of
                    answer scripts) as per allotment </strong>
            </a>
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div>
            <strong>Category : III-C - Innovative Teaching - Learning methodologies, Updating of subject
                contents / courses, meentoring etc</strong>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a
                href="learning_methodologies.php?category_id=Category III-C&category_title=Innovative Teaching - Learning methodologies, Updating of subject
                contents / courses, meentoring etc&subcategory_id=Category I-C(i)&subcategory_title=Innovation Teaching - Learning methodologies">
                Category I-C(i) - Innovation Teaching - Learning methodologies
            </a>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a
                href="courses.php?category_id=Category III-C&category_title=Innovative Teaching - Learning methodologies, Updating of subject
                contents / courses, meentoring etc&subcategory_id=Category I-C(ii)&subcategory_title=Updating of subject contents /courses">
                Category I-C(ii) - Updating of subject contents /courses
            </a>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="mentoring.php?category_id=Category III-C&category_title=Innovative Teaching - Learning methodologies, Updating of subject
                contents / courses, meentoring etc&subcategory_id=Category I-C(iii)&subcategory_title=Mentoring">
                Category I-C(iii) - Mentoring
            </a>
        </div>
    </div>
</body>

</html>