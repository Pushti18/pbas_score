<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM mentoring WHERE employee_id = '{$_SESSION['employee_id']}'";
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
    <title>Montoring</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h3>Mentoring</h3>
    </div>

    <div class="parent-container">
        <div class="child-container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add
            </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>pbasYear</th>
                            <th>mentorName</th>
                            <th>studentNames</th>
                            <th>outcomeMentoring</th>
                            <th>hoursSpent</th>
                            <th>APPROVAL STATUS</th>
                            <th>ACTION</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['pbasYear']}</td>";
                                    echo "<td>{$row['mentorName']}</td>";
                                    echo "<td>{$row['studentNames']}</td>";
                                    echo "<td>{$row['outcomeMentoring']}</td>";
                                    echo "<td>{$row['hoursSpent']}</td>";
                                    echo "</tr>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Mentoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat1_mentoring_insert.php" method="POST">
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
                                <label for="mentorName">Name of Mentor:</label>
                                <input type="text" class="form-control" id="mentorName" name="mentorName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="studentNames">Name of Students:</label>
                                <input type="text" class="form-control" id="studentNames" name="studentNames">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="outcomeMentoring">Outcome Mentoring:</label>
                                <input type="text" class="form-control" id="outcomeMentoring" name="outcomeMentoring">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hoursSpent">Hours Spent:</label>
                                <input type="number" class="form-control" id="hoursSpent" name="hoursSpent" min="0">
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
    <script>
    $(document).ready(function() {
        $("#myForm").submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "cat1_mentoring_insert.php",
                data: formData,
                success: function(response) {
                    alert(response);
                }
            });
        });
    });
    </script>
</body>

</html>