<?php
session_start();
?>

<html>

<head>
    <title>Company Details</title>
    <style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .header_container {
        width: 100%;
        display: flex;
    }

    .mulogo_header {
        width: 13%;
        align-content: left;
    }

    .title {
        margin-left: 24.3%;
    }

    .ictlogo_header {
        width: 15%;
        float: right;
        padding-top: 0.5%;
        padding-right: 1%;
        margin-left: 24.3%;
    }


    .container button {
        background-color: #21c8de;
        border-color: #21c8de;
        margin-top: 1%;
        margin-left: 85%;
        margin-bottom: 1%;
        width: 10%;
        height: 35px;
        border-radius: 10px;
    }

    .rp_div {
        background-color: #c9e9f4;
        align-items: flex-start;
        padding: 50px;
        position: center;
        width: 90%;
        border: 1px solid;
        box-sizing: border-box;
        border-radius: 10px;
        margin-left: 5%;
        font-size: 20px;
        text-align: justify;
        line-height: 1.5;
    }

    .download_btn button {
        background-color: #21c8de;
        text-align: center;
        text-decoration: none;
        margin-left: 2%;
        font-size: 15px;
        border-radius: 10%;
        border-color: #21c8de;
    }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
    <header class="header_container">
        <img class="mulogo_header" src="../images/MU_Logo.png" alt="MU logo">
        <h1 class="title">Company Details</h1>
        <img class="ictlogo_header" src="../images/ICT_logo_text.png" alt="MU logo">
    </header>
    <div class="container">
        <a href="ipr_output.php"><button class="back_btn">Back</button></a>
    </div>

    <div class="rp_div">
        <?php 

    // session_start();

    include("../db_connect.php");
    $id = $_POST['id'];
    $sql = "SELECT * FROM company_info_details WHERE id='".$id."'";
    /*WHERE id=".$_SESSION['id'];
    --echo $sql;
    --exit(0);*/
    $result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {	
            // echo "<h4>Research Paper Id: ".$row['id']."</h4>";	
            echo "<li><b>Company Name:</b>&nbsp;&nbsp;".$row['company_name']."<br></li>";
			echo "<li><b>Location: </b>&nbsp;&nbsp;".$row['location']."<br></li>";
            echo "<li><b>Type of Company: </b>&nbsp;&nbsp;".$row['type_of_company']."<br></li>";
			echo "<li><b>Job Description: </b>&nbsp;&nbsp;".$row['job_description']."<br></li>";
			echo "<li><b>Skills Required: </b>&nbsp;&nbsp;".$row['skills_required']."<br></li>";	
			echo "<li><b>Website: </b>&nbsp;&nbsp;".$row['website']."<br></li>";
			echo "<li><b>Linkedln: </b>&nbsp;&nbsp;".$row['linkedln']."<br></li>";
			echo "<li><b>Students Reference: </b>&nbsp;&nbsp;".$row['students_reference']."<br></li>";	
			echo "<li><b>Salary: </b>&nbsp;&nbsp;".$row['salary']."<br></li>";
			echo "<li><b>Reviews: </b>&nbsp;&nbsp;".$row['reviews']."<br></li>";
			echo "<li><b>Students Reviews: </b>&nbsp;&nbsp;".$row['students_reviews']."<br></li>";
			echo "<li><b>Terms and Conditions: </b>&nbsp;&nbsp;".$row['terms_and_conditions']."<br></li>";
			echo "<li><b>Stipend: </b>&nbsp;&nbsp;".$row['stipend']."<br></li>";
			echo "<li><b>Company Size: </b>&nbsp;&nbsp;".$row['company_size']."<br></li>";
			
		}
	}
	?>

    </div><br>
</body>

</html>