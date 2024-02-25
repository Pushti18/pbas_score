<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat1'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];
// Check if the ID parameter is passed through the URL
if (isset($_GET['id'])) {
    $record_id = $_GET['id'];

    // Retrieve the record from the database based on the ID
    $sql = "SELECT * FROM direct_teaching WHERE id = '$record_id' AND employee_id='$employee_id' and cat1_id = '$category' AND subcat_1='$subcategory_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Store the retrieved data in variables
        $university = $row['university'];
        $year = $row['year'];
        $enroll = $row['enroll'];
        $pbasYear = $row['pbasYear'];
        $subDate = $row['submissionDate'];
        $hoursSpent = $row['hoursSpent'];
        $degree = $row['degree'];
        $studentName = $row['studentName'];
        $projectTitle = $row['projectTitle'];
        $projectType = $row['projectType'];
        $statusofwork = $row['statusofwork'];
        $attachment = $row['attachment'];

        // Generate HTML content for the form with fetched data
        $htmlContent = "
            <form id='myForm' action='direct_teaching_update.php' method='POST' enctype='multipart/form-data'>
                <input type='hidden' name='record_id' value='$record_id'>
                <div class='form-row'>
                    <div class='form-group col-md-6'>
                        <label for='university'>Fill below details to add Guidance To Student in Project Name of the University</label>
                        <input type='text' class='form-control' id='university' name='university' value='$university'>
                    </div>
                    
</div>
<button type='submit' class='btn btn-primary' id='submitButton'>Submit</button>
</form>
";
        // Return the HTML content
        echo $htmlContent;
    } else {
        echo "Record not found.";
        exit(); // Stop execution if record not found
    }
} else {
    echo "ID parameter not specified.";
    exit(); // Stop execution if ID parameter not specified
}
?>