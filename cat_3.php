<?php
session_start();
include ("db_connection.php");
global $conn;
if (isset($_GET['employee_id']) && isset($_GET['category'])) {
    $employee_id = $_GET['employee_id'];
    $category = $_GET['category'];

    echo $category;

    $query = "UPDATE `cat3` SET `employee_id` = $employee_id ";

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
    <title>Categories - III</title>
    <?php require "./components/category-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="category-div main_div">
        <div class="category-container">
            <h1>CATEGORY : III - Research and academic contributions</h1>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="">
                    <strong> Category : III-A - Research Papers Publication in </strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="publication.php?&subcategory_id=cat3_a1">
                    Category III-A(a) - Refereed Journal's as notified by the UGC / Cases published in Harvard Business
                    Publishing or IVEY Publishing
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="publication.php?&subcategory_id=cat3_a2">
                    Category III-A(b) - Other Reputed Journals as notified by the UGC / cases published by reputed
                    publisher such as ECCH / registered moot cases
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="#">
                    <strong>Category : III-B - Publications other than journal articles (books, chapters in
                        books)</strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="publication.php?&subcategory_id=cat3_b1">
                    Category III-B(a) - Text/ Reference, Books published by International Publishers, with ISBN / ISSN
                    number as approved by the University and posted on its website. The list will be intimated to UGC.
                </a>
            </div>

            <div class=" subcategory">
                <div class="tick-circle-icon"></div>
                <a href="publication.php?&subcategory_id=cat3_b2">
                    Category III-B(b) - Subject Books, published by National level publishers, with ISBN/ISSN number or
                    State/Central Govt. Publications as approved by the University and posted on its website. The List
                    will be intimated to UGC.
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="publication.php?&subcategory_id=cat3_b3">
                    Category III-B(c) - Subject Books by Other local
                    publishers with ISBN/ISSN
                    numbers.
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="publication.php?&subcategory_id=cat3_b4">
                    Category III-B(d) - Chapters in Books, published by National and International level publishers,
                    with ISBN/ISSN number as approved by the University and posted on its website. The list will be
                    intimated to UGC.
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="">
                    <strong>Category : III-C(i) - Research Projects</strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="research.php?&subcategory_id=cat3_c1_1">
                    Category III-C(i-a) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of
                    Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5
                    lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="research.php?&subcategory_id=cat3_c1_2">
                    Category III-C(i-b) - Sponsored Major project with grants above Rs.
                    50,000 up to Rs. 5 lakhs ( For Faculty of
                    Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5
                    lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="research.php?&subcategory_id=cat3_c1_3">
                    Category III-C(i-c) - Sponsored Major project with grants above 5 lakhs up to 30 lakhs ( For Faculty
                    of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs
                    5
                    lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="research.php?&subcategory_id=cat3_c2">
                    <strong> Category III-C(ii) - Consultancy Projects/ Testing/Training</strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="project_output.php?&subcategory_id=cat3_c3">
                    <strong> Category III-C(iii) - Projects Outcome/Outputs</strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="guidance_to_student.php">
                    <strong> Category III-D - Research Guidance: PhD. programme</strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="">
                    <strong> Category III-E - Fellowships, Awards and Invited lectures delivered in
                        conferences/seminars</strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="fellowship.php?&subcategory_id=cat3_e1">
                    Category III-E(i) - Fellowships / Awards
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a href="expert.php?&subcategory_id=cat3_e2">
                    Category III-E(ii) -Invited Lectures / papers
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="development.php">
                    <strong> Category III-F - Development of e-learning delivery process / material</strong>
                </a>
            </div>
        </div>
    </div>
</body>

</html>