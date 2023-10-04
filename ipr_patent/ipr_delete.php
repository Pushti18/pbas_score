<?php
//including the database connection file
// include("db_connect.php");

// //getting id of the data from url
// $id = $_POST['id'];

// //deleting the row from table
// $result = mysqli_query($mysqli, "DELETE FROM research_paper_details WHERE id=$id");

// //redirecting to the display page (index.php in our case)
// header("Location:rp_output.php");



require('db_connect.php');
$id=$_REQUEST['id'];
$query = "UPDATE company_info_details SET status=0 WHERE id=$id"; 
$result = mysqli_query($conn,$query) or die ( mysqli_error());
header("Location: ipr_output.php"); 
?>