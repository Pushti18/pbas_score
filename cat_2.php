<?php
    session_start();
    include("db_connect.php");
    global $conn;
    if (isset($_GET['employee_id'])) {
        $employee_id = $_GET['employee_id'];
        // Update the database table with the employee_id
        $query = "UPDATE `cat2` SET `employee_id` = $employee_id ";
    
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

        <h1>CATEGORY : II - Professional development, Co-curricular and extension activities</h1>

        <div class="category">
            <div class="tick-circle-icon"></div>
            <strong>Category : II-A - Student related co-curricular, extension and field based activities</strong>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a
                href="discipline.php?category_id=Category II-A&category_title=Student related co-curricular, extension and field based activities&subcategory_id=Category II-A(i)&subcategory_title=Discipline related co-curricular activities (e.g. remedial classes, carrer counseling,study visimt, student seminar and other events)">
                Category II-A(i) - Discipline related co-curricular activities (e.g. remedial classes, carrer
                counseling,
                study visimt, student seminar and other events)
            </a>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="othercocurricular.php?category_id=Category II-A&category_title=Student related co-curricular, extension and field based activities&subcategory_id=Category II-A(ii)&subcategory_title=Other co-curricular activities (Cultural, Sports, NSS, NCC etc. - please
                specify)">
                Category II-A(ii) - Other co-curricular activities (Cultural, Sports, NSS, NCC etc. - please
                specify)
            </a>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="extension.php?category_id=Category II-A&category_title=Student related co-curricular, extension and field based activities&subcategory_id=Category II-A(iii)&subcategory_title=Extension and dissemination activities (public / popular lectures / talks /
                seminars etc)">
                Category II-A(iii) - Extension and dissemination activities (public / popular lectures / talks /
                seminars
                etc)
            </a>
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div>
            <strong>Category : II-B - Contribution to Corporate life and management of the
                department and institution through participation in
                academic and administrative committees and
                responsibilities. </strong>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="administrative.php?category_id=Category II-B&category_title=Contribution to Corporate life and management of the
                department and institution through participation in academic and administrative committees and
                responsibilities.&subcategory_id=Category II-B(i)&subcategory_title=Administrative responsibility (including as Dean/ Principal/ Chairperson
                /Convener/Teache-in-charge/ similar other duties that require regular office hrs of its discharge), please
                specify">
                Category II-B(i) - Administrative responsibility (including as Dean/ Principal/ Chairperson
                /Convener/
                Teache-in-charge/ similar other duties that require regular office hrs of its discharge), please
                specify
            </a>
        </div>

        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a
                href="participation.php?category_id=Category II-B&category_title=Contribution to Corporate life and management of the
                department and institution through participation in academic and administrative committees and responsibilities.&subcategory_id=Category II-B(ii)&subcategory_title=Participation in Board of Studies, Academic and Administrative Committees">
                Category II-B(ii) - Participation in Board of Studies, Academic and Administrative Committees
            </a>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a
                href="others.php?category_id=Category II-B&category_title=Contribution to Corporate life and management of the
                department and institution through participation in academic and administrative committees and responsibilities.&subcategory_id=Category II-B(iii)&subcategory_title=Others">
                Category II-B(iii) - Others
            </a>
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div>
            <a href="developmentactivities.php?category_id=Category III-C&category_title=Professional Development activities (such as
                    participation in seminars, conferences, short term,training courses,industrial experience, talks, lectures in refresher/ faculty development
                    courses,dissemination and general articles and any other Contribution) please specify">

                <strong>Category : III-C - Professional Development activities (such as
                    participation in seminars, conferences, short term,
                    training courses,industrial experience, talks, lectures in refresher/ faculty development
                    courses,
                    dissemination and general articles and any other Contribution) please specify</strong>
            </a>
        </div>
    </div>
</body>

</html>