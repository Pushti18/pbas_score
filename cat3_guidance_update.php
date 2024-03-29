<?php
session_start();
include ("db_connection.php");

// Fetching data for editing
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $entryId = $_GET["entry_id"];

    $sql = "SELECT * FROM guidance WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $entryData = mysqli_fetch_assoc($result);
        echo json_encode($entryData);
    } else {
        echo "No data found for the given entry ID.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entryId = $_POST["entry_id"];

    $name_of_university = isset($_POST['editnameOfUniversity']) ? $_POST['editnameOfUniversity'] : '';
    $degree = isset($_POST['editdegree']) ? $_POST['editdegree'] : '';
    $degree_award_date = isset($_POST['editdegreeAwardDate']) ? $_POST['editdegreeAwardDate'] : '';
    $student_name = isset($_POST['editstudentName']) ? $_POST['editstudentName'] : '';
    $enrollment_no = isset($_POST['editenrollmentNo']) ? $_POST['editenrollmentNo'] : '';
    $project_title = isset($_POST['editprojectTitle']) ? $_POST['editprojectTitle'] : '';
    $project_year = isset($_POST['editprojectYear']) ? $_POST['editprojectYear'] : '';
    $project_type = isset($_POST['editprojectType']) ? $_POST['editprojectType'] : '';
    $thesis_submission_date = isset($_POST['editthesisSubmissionDate']) ? $_POST['editthesisSubmissionDate'] : '';
    $current_status_of_work = isset($_POST['editcurrentStatusOfWork']) ? $_POST['editcurrentStatusOfWork'] : '';


    $pbasScore = 0;

    if ($degree == 'Ph.D') {
        if ($current_status_of_work == 'Completed') {
            $mainSupervisorScore = 15;
            $jointSupervisorScore = 8;
            $pbasScore = ($mainSupervisorScore + $jointSupervisorScore);
        } elseif ($current_status_of_work == 'In Progress') {
            $mainSupervisorScore = 10;
            $jointSupervisorScore = 5;
            $pbasScore = ($mainSupervisorScore + $jointSupervisorScore);
        }
    } elseif ($degree != '' && $current_status_of_work == 'Completed') {
        $mainSupervisorScore = 5;
        $jointSupervisorScore = 3;
        $pbasScore = ($mainSupervisorScore + $jointSupervisorScore);
    }



    $sql = "UPDATE guidance SET  name_of_university='$name_of_university', degree= '$degree', degree_award_date='$degree_award_date', student_name='$student_name', enrollment_no='$enrollment_no', project_title='$project_title', project_year='$project_year', project_type='$project_type', thesis_submission_date='$thesis_submission_date', current_status_of_work='$current_status_of_work',  pbas_score='$pbasScore'
    WHERE employee_id = '{$_SESSION['employee_id']}' AND id = '$entryId'";





    echo $sql;

    if (mysqli_query($conn, $sql)) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
        // echo "Entry updated successfully.";
    } else {
        echo "Error updating entry: " . mysqli_error($conn);
    }
}
?>