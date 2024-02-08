<?php
    session_start();
    include("db_connect.php");
    global $conn;
    if (isset($_GET['employee_id'])) {
        $employee_id = $_GET['employee_id'];
        // Update the database table with the employee_id
        $query = "UPDATE `cat3` SET `employee_id` = $employee_id ";
    
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

    /* Add your CSS styles here */
    .body {
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

    .category a {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Use the default text color */
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

    /* Add your CSS styles here */
    .body {
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

    .category a,
    .subcategory a {
        text-decoration: none;
        /* Remove underline */
        color: inherit;
        /* Use the default text color */
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

        <h1>CATEGORY : III - Research and academic contributions</h1>

        <div class="category">
            <div class="tick-circle-icon"></div>
            <strong>
                <a href="publication.php">
                    Category : III-A - Research Papers Publication in
                </a>

            </strong>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="publication.php?category_id=Category III-A&category_title=Category_III-A - Research Papers Publication in&subcategory_id=Category III-A(a)&subcategory_title=Refereed Journal's as notified by the UGC / Cases published in Harvard Business
                Publishing or IVEY Publishing">
                Category III-A(a) - Refereed Journal's as notified by the UGC / Cases published in Harvard Business
                Publishing or IVEY Publishing
            </a>

        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="publication.php?category_id=Category III-A&category_title=Category_III-A - Research Papers Publication in&subcategory_id=Category III-A(b)&subcategory_title=Other Reputed Journals as notified by the UGC / cases published by reputed publisher
                such as ECCH / registered moot cases">
                Category III-A(b) - Other Reputed Journals as notified by the UGC / cases published by reputed publisher
                such as ECCH / registered moot cases
            </a>
        </div>

        <div class="category">
            <div class="tick-circle-icon"></div>
            <a href="publication.php">
                <strong>Category : III-B - Publications other than journal articles (books, chapters in books)</strong>
            </a>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Text/ Reference, Books published by International Publishers, with ISBN / ISSN
                number as approved by the University and posted on its website. The list will be intimated to UGC.">
                Category III-B(a) - Text/ Reference, Books published by International Publishers, with ISBN / ISSN
                number as approved by the University and posted on its website. The list will be intimated to UGC.
            </a>
        </div>

        <div class=" subcategory">
            <div class="tick-circle-icon"></div>
            <a href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Subject Books, published by National level publishers, with ISBN/ISSN number or
                State/Central Govt. Publications as approved by the University and posted on its website. The List
                will
                be intimated to UGC.">
                Category III-B(b) - Subject Books, published by National level publishers, with ISBN/ISSN number or
                State/Central Govt. Publications as approved by the University and posted on its website. The List
                will
                be intimated to UGC.
            </a>
        </div>

        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Text/ Reference, Books published by International Publishers, with ISBN / ISSN
                number as approved by the University and posted on its website. The list will be intimated to UGC.">
                Category III-B(c) - Subject Books, published by National level publishers, with ISBN/ISSN number or
                State/Central Govt. Publications as approved by the University and posted on its website. The List will
                be intimated to UGC.
            </a>
        </div>

        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="publication.php?category_id=Category III-B&category_title=Publications other than journal articles (books, chapters in books)&subcategory_id=Category III-B(a)&subcategory_title=Chapters in Books, published by National and International level publishers, with
                ISBN/ISSN number as approved by the University and posted on its website. The list will be intimated to
                UGC.">
                Category III-B(d) - Chapters in Books, published by National and International level publishers, with
                ISBN/ISSN number as approved by the University and posted on its website. The list will be intimated to
                UGC.
            </a>
        </div>

        <div class="category">
            <div class="tick-circle-icon"></div><a href="research.php">
                <strong>Category : III-C(i) - Research Projects</strong>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div>
            <a href="research.php?category_id=Category III-C(i)&category_title=Research Projects&subcategory_id=Category III-C(i-a)&subcategory_title=Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology
                and
                Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty
                of
                Law, Commerce, Management and Management & Humanities)">
                Category III-C(i-a) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology
                and
                Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty
                of
                Law, Commerce, Management and Management & Humanities)
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div><a href="research.php?category_id=Category III-C(i)&category_title=Research Projects&subcategory_id=Category III-C(i-b)&subcategory_title=Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology
                and
                Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty
                of
                Law, Commerce, Management and Management & Humanities)">
                Category III-C(i-b) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology
                and
                Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty
                of
                Law, Commerce, Management and Management & Humanities)
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div><a href="research.php?category_id=Category III-C(i)&category_title=Research Projects&subcategory_id=Category III-C(i-c)&subcategory_title=Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology
                and
                Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty
                of
                Law, Commerce, Management and Management & Humanities)">
                Category III-C(i-c) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology
                and
                Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty
                of
                Law, Commerce, Management and Management & Humanities)
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div><a
                href="research.php?category_id=Category III-C(ii)&category_title=Consultancy Projects/ Testing/Training">
                <strong> Category III-C(ii) - Consultancy Projects/ Testing/Training</strong>
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div><a
                href="project_output.php?category_id=Category III-C(iii)&category_title=Projects Outcome/Outputs">
                <strong> Category III-C(iii) - Projects Outcome/Outputs</strong>
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div><a
                href="guidance_to_student.php?category_id=Category III-D&category_title=Research Guidance: PhD. programme">
                <strong> Category III-D - Research Guidance: PhD. programme</strong>
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div>
            <strong> Category III-E - Fellowships, Awards and Invited lectures delivered in
                conferences/seminars</strong>
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div><a href="fellowship.php?category_id=Category III-E&category_title=Fellowships, Awards and Invited lectures delivered in
                conferences/seminars&subcategory_id=Category III-E(i)&subcategory_title=Fellowships / Awards">
                Category III-E(i) - Fellowships / Awards
        </div>
        <div class="subcategory">
            <div class="tick-circle-icon"></div><a href="expert.php?category_id=Category III-E&category_title=Fellowships, Awards and Invited lectures delivered in
                conferences/seminars&subcategory_id=Category III-E(ii)&subcategory_title=Invited Lectures / papers">
                Category III-E(ii) -Invited Lectures / papers
        </div>
        <div class="category">
            <div class="tick-circle-icon"></div><a
                href="development.php?category_id=Category III-F&category_title=Development of e-learning delivery process / material">
                <strong> Category III-F - Development of e-learning delivery process / material</strong>
        </div>
    </div>
</body>

</html>