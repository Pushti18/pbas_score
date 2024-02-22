<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;


$sql = "SELECT * FROM learning_methodologies WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
$sql = "INSERT INTO cat1 (category_id,category_title,subcategory_id, subcategory_title) VALUES ('$category_id','$category_title','$subcategory_id', '$subcategory_title')";
mysqli_query($conn, $sql);

if (mysqli_error($conn)) {
    // echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Learning Methodology</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Learning Methodology</h4>
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
                            <!--  <th>TITLE</th>-->
                            <th>ACADEMIC YEAR</th>
                            <th>course Name</th>
                            <th>natureOfInnovation</th>
                            <th>hoursSpentInnovation</th>
                            <th>APPROVAL STATUS</th>
                            <th>ACTION</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['pbasYear']}</td>";
                                    echo "<td>{$row['courseName']}</td>";
                                    echo "<td>{$row['natureOfInnovation']}</td>";
                                    echo "<td>{$row['hoursSpentInnovation']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Learning Methodology</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat1_learning_methodologies_insert.php" method="POST"
                        enctype="multipart/form-data">
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
                                <label for="courseName">Course Name:</label>
                                <input type="text" class="form-control" id="courseName" name="courseName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="natureOfInnovation">Nature of Innovation:</label>
                                <input type="text" class="form-control" id="natureOfInnovation"
                                    name="natureOfInnovation">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hoursSpentInnovation">Hours Spent:</label>
                                <input type="number" class="form-control" id="hoursSpentInnovation"
                                    name="hoursSpentInnovation" min="0">
                            </div>
                        </div>
                        <!-- <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="documentInnovation">Upload Document Justifying Your Innovation:</label>
                                <input type="file" class="form-control" id="documentInnovation"
                                    name="documentInnovation" accept=".pdf, .doc, .docx">
                            </div>
                        </div> -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="attachment">Upload Document Justifying Your Innovation:</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    accept=".pdf, .doc, .docx">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require "./components/category-table-top-script.php" ?>
    <script>
    document.getElementById('myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const documentInput = document.getElementById('attachment');
        const file = documentInput.files[0];

        if (!file) {
            alert('Please select a file to upload.');
            return;
        }

        // Create a FormData object to hold the file data
        const formData = new FormData(this); // 'this' refers to the form element

        // Send an AJAX request to the server using Fetch API
        fetch('cat1_learning_methodologies_insert.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Display server response (e.g., success message)
            })
            .catch(error => {
                console.error(error); // Handle errors
            });
    });
    </script>
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
                url: "cat1_learning_methodologies_insert.php",
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