<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;


$sql = "SELECT * FROM exam_duties WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}


$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat1'];

$query = "UPDATE `cat1` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
echo $query;
if (mysqli_query($conn, $query)) {
    // echo "Employee ID updated successfully in the database.";
} else {
    // echo "Error updating record: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> Examination Duties</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Examination Duties</h4>
    </div>

    <div class="parent-container">
        <div class="child-container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <!-- <th>TITLE</th> -->
                            <th>ACADEMIC YEAR</th>
                            <th>SEM</th>
                            <th>STREAM NAME</th>
                            <th>COURSE NAME</th>
                            <th>PBAS SCORE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['pbas_year']}</td>";
                                    echo "<td>{$row['semester']}</td>";
                                    echo "<td>{$row['stream_name']}</td>";
                                    echo "<td>{$row['course_name']}</td>";
                                    echo "<td>{$row['points']}</tr>";
                                }
                                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Examination Duties</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" action="cat1_exam_duties_insert.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="pbasYear">PBAS Year:</label>
                                <select class="form-control" id="pbasYear" name="pbasYear">
                                    <?php
                                    $startYear = 1990;
                                    $endYear = 2050;

                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        echo "<option value='{$i}'>{$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="semester">Semester:</label>
                                <select class="form-control" id="semester" name="semester">
                                    <?php
                                    for ($i = 1; $i <= 8; $i++) {
                                        echo "<option value='Sem {$i}'>Sem {$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="streamName">Stream Name:</label>
                                <input type="text" class="form-control" id="streamName" name="streamName">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="courseName">Course Name:</label>
                                <select class="form-control" id="courseName" name="courseName">
                                    <option value="Select Course">Select Course</option>
                                    <option value="Course A">Course A</option>
                                    <option value="Course B">Course B</option>
                                </select>
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="questionPaper">No of Question Paper:</label>
                                <input type="text" class="form-control" id="questionPaper" name="questionPaper">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="hoursSpentQuestion">Hours Spent (Question Paper):</label>
                                <input type="number" class="form-control" id="hoursSpentQuestion"
                                    name="hoursSpentQuestion" min="0">
                            </div>


                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="numExaminations">No's of Examinations (Supervisor's Duties):</label>
                                <input type="text" class="form-control" id="numExaminations" name="numExaminations">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="hoursSpentExaminations">Hours Spent (Examinations):</label>
                                <input type="number" class="form-control" id="hoursSpentExaminations"
                                    name="hoursSpentExaminations" min="0">
                            </div>


                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="numAnswerBook">No of Answer Book:</label>
                                <input type="text" class="form-control" id="numAnswerBook" name="numAnswerBook">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="hoursSpentAnswerBook">Hours Spent (Answer Book):</label>
                                <input type="number" class="form-control" id="hoursSpentAnswerBook"
                                    name="hoursSpentAnswerBook" min="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require "./components/category-table-top-script.php" ?>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#details_table').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [5, 10, 25, 50],
                ['5 Files', '10 Files', '25 Files', '50 Files']
            ],

        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
    </script>
    <!-- <script>
    $(document).ready(function() {
        $("#myForm").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "cat1_exam_duties_insert.php",
                data: formData,
                success: function(response) {
                    alert(response);
                }
            });
        });
    });
    </script> -->
    <script>
    $(document).ready(function() {
        $("#myForm").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "cat1_exam_duties_insert.php",
                data: formData,
                success: function(response) {
                    alert(response); // Show success message or handle response accordingly
                    $('#myModal').modal('hide'); // Close modal popup
                    refreshTable(); // Refresh table data
                }
            });
        });

        // Function to refresh table data
        function refreshTable() {
            $.ajax({
                type: "GET",
                url: "cat1_exam_duties_insert.php", // Replace with actual URL to fetch table data
                success: function(data) {
                    $('#details_table tbody').html(data); // Update table body with new data
                }
            });
        }
    });
    </script>

</body>

</html>