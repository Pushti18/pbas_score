<?php
session_start();
include("db_connection.php");
$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM project_output WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$sql = "INSERT INTO cat3 (category_id,category_title,subcategory_id, subcategory_title) VALUES ('$category_id','$category_title','$subcategory_id', '$subcategory_title')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    // echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Projects Outcome/Outputs</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Projects Outcome/Outputs</h4>
    </div>

    <div class="parent-container">
        <div class="child-container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add Detail
            </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>TITLE</th>
                            <th>PROJECT OUTCOME</th>
                            <th>DETAILS OF OUTCOME</th>
                            <th>PBAS YEAR</th>
                            <th>PATENT REGISTERED</th>
                            <!-- <th></th> -->
                            <th>APPROVAL STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['title']}</td>";
                            echo "<td>{$row['project_outcome']}</td>";
                            echo "<td>{$row['details_of_outcome']}</td>";
                            echo "<td>{$row['pbas_year']}</td>";
                            echo "<td>{$row['patent_register']}</td>";

                            // echo "<td>{$row['approval_status']}</td>";
                            // echo "<td><a href='edit_research.php?id={$row['id']}'>Edit</a> | <a href='delete_research.php?id={$row['id']}'>Delete</a></td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Projects Outcome/Outputs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat3_project_output_insert.php" method="POST">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
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
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="projectOutcome">Project Outcome:</label>
                                <textarea class="form-control" id="projectOutcome" name="projectOutcome"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="region">Region:</label>
                                <select class="form-control" id="region" name="region">
                                    <option value="Please Select">Please Select</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                    <option value="International Bodies">International Bodies</option>
                                    <option value="Central Government Bodies">Central Government Bodies</option>
                                    <option value="State Government Bodies">State Government Bodies</option>
                                    <option value="Local">Local</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="detailsOfOutcome">Details of Outcome:</label>
                                <textarea class="form-control" id="detailsOfOutcome" name="detailsOfOutcome"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Patent Register:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="patentRegister" id="patentYes"
                                        value="Yes">
                                    <label class="form-check-label" for="patentYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="patentRegister" id="patentNo"
                                        value="No">
                                    <label class="form-check-label" for="patentNo">No</label>
                                </div>
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
                url: "cat3_project_output_insert.php",
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