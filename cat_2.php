<?php
session_start();
include("db_connection.php");
global $conn;
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    $query = "UPDATE `cat2` SET `employee_id` = $employee_id ";

    if (mysqli_query($conn, $query)) {
        // echo "Employee ID updated successfully in the database.";
    } else {
        // echo "Error updating record: " . mysqli_error($conn);
    }
    $_SESSION['employee_id'] = $employee_id;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Categories - II</title>
    <?php require "./components/category-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="category-div main_div">
        <div class="category-container">
            <h1>CATEGORY : II - Professional development, Co-curricular and extension activities</h1>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="">
                    <strong>Category : II-A - Student related co-curricular, extension and field based
                        activities</strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="discipline.php?category_id=Category II-A&category_title=Student related co-curricular, extension and field based activities&subcategory_id=Category II-A(i)&subcategory_title=Discipline related co-curricular activities (e.g. remedial classes, carrer counseling,study visimt, student seminar and other events)">
                    Category II-A(i) - Discipline related co-curricular activities (e.g. remedial classes, carrer
                    counseling, study visit, student seminar and other events)
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="othercocurricular.php?category_id=Category II-A&category_title=Student related co-curricular, extension and field based activities&subcategory_id=Category II-A(ii)&subcategory_title=Other co-curricular activities (Cultural, Sports, NSS, NCC etc. - please specify)">
                    Category II-A(ii) - Other co-curricular activities (Cultural, Sports, NSS, NCC etc. - please
                    specify)
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="extension.php?category_id=Category II-A&category_title=Student related co-curricular, extension and field based activities&subcategory_id=Category II-A(iii)&subcategory_title=Extension and dissemination activities (public / popular lectures / talks / seminars etc)">
                    Category II-A(iii) - Extension and dissemination activities (public / popular lectures / talks /
                    seminars etc)
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="">
                    <strong>Category : II-B - Contribution to Corporate life and management of the department and
                        institution through participation in academic and administrative committees and
                        responsibilities. </strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="administrative.php?category_id=Category II-B&category_title=Contribution to Corporate life and management of the department and institution through participation in academic and administrative committees and responsibilities.&subcategory_id=Category II-B(i)&subcategory_title=Administrative responsibility (including as Dean/ Principal/ Chairperson /Convener/Teache-in-charge/ similar other duties that require regular office hrs of its discharge), please specify">
                    Category II-B(i) - Administrative responsibility (including as Dean/ Principal/ Chairperson
                    /Convener/ Teache-in-charge/ similar other duties that require regular office hrs of its discharge),
                    please specify
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="participation.php?category_id=Category II-B&category_title=Contribution to Corporate life and management of the department and institution through participation in academic and administrative committees and responsibilities.&subcategory_id=Category II-B(ii)&subcategory_title=Participation in Board of Studies, Academic and Administrative Committees">
                    Category II-B(ii) - Participation in Board of Studies, Academic and Administrative Committees
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="others.php?category_id=Category II-B&category_title=Contribution to Corporate life and management of the department and institution through participation in academic and administrative committees and responsibilities.&subcategory_id=Category II-B(iii)&subcategory_title=Others">
                    Category II-B(iii) - Others
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a
                    href="developmentactivities.php?category_id=Category III-C&category_title=Professional Development activities (such as participation in seminars, conferences, short term,training courses,industrial experience, talks, lectures in refresher/ faculty development courses,dissemination and general articles and any other Contribution) please specify">
                    <strong>Category : III-C - Professional Development activities (such as participation in seminars,
                        conferences, short term,training courses,industrial experience, talks, lectures in refresher/
                        faculty development courses, dissemination and general articles and any other Contribution)
                        please specify</strong>
                </a>
            </div>
        </div>
    </div>
</body>

</html>