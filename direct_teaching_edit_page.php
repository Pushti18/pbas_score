<?php
session_start();
include("db_connection.php");
$category = $_SESSION['cat1'];
$subcategory_id = isset($_POST['subcategory_id']) ? $_POST['subcategory_id'] : '';

$employee_id = $_SESSION['employee_id'];
if (isset($_GET['id'])) {
    $record_id = $_GET['id'];
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

        $htmlContent = "
        <form id='myForm' action='direct_teaching_update.php' method='POST' enctype='multipart/form-data'>
            <input type='hidden' name='record_id' value='$record_id'>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='university'>University:</label>
                    <input type='text' class='form-control' id='university' name='university' value='$university'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='year'>Year:</label>
                    <input type='text' class='form-control' id='year' name='year' value='$year'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='enroll'>Enrollment No.:</label>
                    <input type='text' class='form-control' id='enroll' name='enroll' value='$enroll'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='pbasYear'>PBAS Year:</label>
                    <input type='text' class='form-control' id='pbasYear' name='pbasYear' value='$pbasYear'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='submissionDate'>Thesis/Project Submission Date:</label>
                    <input type='date' class='form-control' id='submissionDate' name='submissionDate' value='$subDate'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='hoursSpent'>Hours Spent:</label>
                    <input type='text' class='form-control' id='hoursSpent' name='hoursSpent' value='$hoursSpent'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='degree'>Degree:</label>
                    <input type='text' class='form-control' id='degree' name='degree' value='$degree'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='studentName'>Student Name:</label>
                    <input type='text' class='form-control' id='studentName' name='studentName' value='$studentName'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='projectTitle'>Project Title:</label>
                    <input type='text' class='form-control' id='projectTitle' name='projectTitle' value='$projectTitle'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='projectType'>Project Type:</label>
                    <input type='text' class='form-control' id='projectType' name='projectType' value='$projectType'>
                </div>
            </div>
            <div class='form-row'>
                <div class='form-group col-md-6'>
                    <label for='statusofwork'>Current Status Of Work:</label>
                    <input type='text' class='form-control' id='statusofwork' name='statusofwork' value='$statusofwork'>
                </div>
                <div class='form-group col-md-6'>
                    <label for='attachment'>Attachment:</label>
                    <input type='text' class='form-control' id='attachment' name='attachment' value='$attachment'>
                </div>
            </div>
            <button type='submit' class='btn btn-primary' id='submitButton'>Submit</button>
        </form>
        ";
        echo $htmlContent;
    } else {
        echo "Record not found.";
        exit();
    }
} else {
    echo "ID parameter not specified.";
    exit();
}
?>

<script>
    $(document).ready(function () {
        $('#myForm').submit(function (event) {
            console.log("clicked");
            event.preventDefault();

            const formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "direct_teaching_update.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.trim() === "Record updated successfully") {
                        location.reload();
                    } else {
                        alert("Error: " + response);
                    }
                },
                error: function (xhr, status, error) {
                    alert("Error: " + error);
                }
            });
        });
    });
</script>