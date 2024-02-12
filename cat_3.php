<?php
session_start();
include("db_connection.php");
global $conn;
if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
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
                <a href="publication.php">
                    <strong> Category : III-A - Research Papers Publication in </strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="publication.php?category_id=Category III-A&category_title=Category_III-A - Research Papers Publication in&subcategory_id=Category III-A(a)&subcategory_title=Refereed Journal's as notified by the UGC / Cases published in Harvard Business Publishing or IVEY Publishing">
                    Category III-A(a) - Refereed Journal's as notified by the UGC / Cases published in Harvard Business
                    Publishing or IVEY Publishing
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="publication.php?category_id=Category III-A&category_title=Category_III-A - Research Papers Publication in&subcategory_id=Category III-A(b)&subcategory_title=Other Reputed Journals as notified by the UGC / cases published by reputed publisher such as ECCH / registered moot cases">
                    Category III-A(b) - Other Reputed Journals as notified by the UGC / cases published by reputed
                    publisher such as ECCH / registered moot cases
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="publication.php">
                    <strong>Category : III-B - Publications other than journal articles (books, chapters in
                        books)</strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Text/ Reference, Books published by International Publishers, with ISBN / ISSN number as approved by the University and posted on its website. The list will be intimated to UGC.">
                    Category III-B(a) - Text/ Reference, Books published by International Publishers, with ISBN / ISSN
                    number as approved by the University and posted on its website. The list will be intimated to UGC.
                </a>
            </div>

            <div class=" subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Subject Books, published by National level publishers, with ISBN/ISSN number or State/Central Govt. Publications as approved by the University and posted on its website. The List will be intimated to UGC.">
                    Category III-B(b) - Subject Books, published by National level publishers, with ISBN/ISSN number or
                    State/Central Govt. Publications as approved by the University and posted on its website. The List
                    will be intimated to UGC.
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Text/ Reference, Books published by International Publishers, with ISBN / ISSN
                    number as approved by the University and posted on its website. The list will be intimated to UGC.">
                    Category III-B(c) - Subject Books, published by National level publishers, with ISBN/ISSN number or
                    State/Central Govt. Publications as approved by the University and posted on its website. The List
                    will be intimated to UGC.
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Chapters in Books, published by National and International level publishers, with ISBN/ISSN number as approved by the University and posted on its website. The list will be intimated to UGC.">
                    Category III-B(d) - Chapters in Books, published by National and International level publishers,
                    with ISBN/ISSN number as approved by the University and posted on its website. The list will be
                    intimated to UGC.
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="research.php">
                    <strong>Category : III-C(i) - Research Projects</strong>
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="research.php?category_id=Category III-C(i)&category_title=Research Projects&subcategory_id=Category III-C(i-a)&subcategory_title=Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)">
                    Category III-C(i-a) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of
                    Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5
                    lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="research.php?category_id=Category III-C(i)&category_title=Research Projects&subcategory_id=Category III-C(i-b)&subcategory_title=Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)">
                    Category III-C(i-b) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of
                    Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5
                    lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="research.php?category_id=Category III-C(i)&category_title=Research Projects&subcategory_id=Category III-C(i-c)&subcategory_title=Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)">
                    Category III-C(i-c) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of
                    Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5
                    lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a
                    href="research.php?category_id=Category III-C(ii)&category_title=Consultancy Projects/ Testing/Training">
                    <strong> Category III-C(ii) - Consultancy Projects/ Testing/Training</strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a href="project_output.php?category_id=Category III-C(iii)&category_title=Projects Outcome/Outputs">
                    <strong> Category III-C(iii) - Projects Outcome/Outputs</strong>
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a
                    href="guidance_to_student.php?category_id=Category III-D&category_title=Research Guidance: PhD. programme">
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
                <a
                    href="fellowship.php?category_id=Category III-E&category_title=Fellowships, Awards and Invited lectures delivered in conferences/seminars&subcategory_id=Category III-E(i)&subcategory_title=Fellowships / Awards">
                    Category III-E(i) - Fellowships / Awards
                </a>
            </div>

            <div class="subcategory">
                <div class="tick-circle-icon"></div>
                <a
                    href="expert.php?category_id=Category III-E&category_title=Fellowships, Awards and Invited lectures delivered in conferences/seminars&subcategory_id=Category III-E(ii)&subcategory_title=Invited Lectures / papers">
                    Category III-E(ii) -Invited Lectures / papers
                </a>
            </div>

            <div class="category">
                <div class="tick-circle-icon"></div>
                <a
                    href="development.php?category_id=Category III-F&category_title=Development of e-learning delivery process / material">
                    <strong> Category III-F - Development of e-learning delivery process / material</strong>
                </a>
            </div>
        </div>
    </div>
</body>

</html>