<?php
session_start();
include ("db_connection.php");
$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM development WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat3'];

$query = "UPDATE `cat3` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
echo $query;
if (mysqli_query($conn, $query)) {
    // echo "Employee ID updated successfully in the database.";
} else {
    // echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Research Development Detail</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h3>Research Development Detail</h3>
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
                            <th>TITLE</th>
                            <th>RESEARCH TYPE</th>
                            <th>SPONSER TYPE</th>
                            <th>PBAS YEAR</th>
                            <th>REMARKS</th>

                            <th>APPROVAL STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['title']}</td>";
                            echo "<td>{$row['research_type']}</td>";
                            echo "<td>{$row['sponsor_type']}</td>";
                            echo "<td>{$row['pbas_year']}</td>";
                            echo "<td>{$row['remarks']}</td>";
                            echo "<td>{$row['pbas_year']}</td>";
                            echo "<td>
                            <button class='btn btn-info btn-edit' data-id='{$row['id']}' data-toggle='modal' data-target='#editModal'>Edit</button>
                            <button class='btn btn-danger btn-delete' data-id='{$row['id']}'>Delete</button>
                        </td>";
                            echo "</tr>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Research Development Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="myForm" action="cat3_development_insert.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                        <!-- Additional Fields -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="researchType">Type Research:</label>
                                <select class="form-control" id="researchType" name="researchType">
                                    <option value="Please Select">Please Select</option>
                                    <option value="RND">RND</option>
                                    <option value="Consultancy">Consultancy</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="sponserType">Sponsor Type:</label>
                                <select class="form-control" id="sponserType" name="sponserType">
                                    <option value="Please Select">Please Select</option>
                                    <option value="Sponsored">Sponsored</option>
                                    <option value="In-House">In-House</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="remarks">Remarks:</label>
                                <input type="text" class="form-control" id="remarks" name="remarks">
                            </div>
                        </div>

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
                                <label for="attachment">Upload Documents:</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    accept=".pdf, .doc, .docx">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="executiveSummary">Upload Executive Summary:</label>
                                <input type="file" class="form-control" id="executiveSummary" name="executiveSummary"
                                    accept=".pdf">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST["name"];
            $email = $_POST["email"];
            echo "Form submitted successfully!";
        }
        ?>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Add Research Development Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="myForm" action="cat3_development_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <!-- Additional Fields -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edittitle">Title:</label>
                                <input type="text" class="form-control" id="edittitle" name="edittitle" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editresearchType">Type Research:</label>
                                <select class="form-control" id="editresearchType" name="editresearchType">
                                    <option value="Please Select">Please Select</option>
                                    <option value="RND">RND</option>
                                    <option value="Consultancy">Consultancy</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editsponserType">Sponsor Type:</label>
                                <select class="form-control" id="editsponserType" name="editsponserType">
                                    <option value="Please Select">Please Select</option>
                                    <option value="Sponsored">Sponsored</option>
                                    <option value="In-House">In-House</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="editremarks">Remarks:</label>
                                <input type="text" class="form-control" id="editremarks" name="editremarks" value="">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editpbasYear">PBAS Year:</label>
                                <select class="form-control" id="editpbasYear" name="editpbasYear">
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
                                <label for="editAttachment">Upload Documents:</label>
                                <input type="file" class="form-control" id="editAttachment" name="editAttachment"
                                    accept=".pdf, .doc, .docx">
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="editexecutiveSummary">Upload Executive Summary:</label>
                                <input type="file" class="form-control" id="editexecutiveSummary"
                                    name="editexecutiveSummary" accept=".pdf">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.btn-edit').click(function () {
                var entryId = $(this).data('id');

                $.ajax({
                    type: "GET",
                    url: "cat3_development_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var entryData = JSON.parse(response);
                        $('#editEntryId').val(entryId);

                        $('#editpbasYear').val(entryData.pbas_year);
                        $('#editsponserType').val(entryData.sponsor_type);
                        $('#editremarks').val(entryData.remarks);
                        $('#editresearchType').val(entryData.research_type);
                        $('#edittitle').val(entryData.title);
                        $('#editAttachment').val(entryData.attachment)
                        $('#editexecutiveSummary').val(entryData.executiveSummary)
                        $('#editModal').modal('show');
                    }
                });
            });
        });
    </script>
    <?php require "./components/category-table-top-script.php" ?>
    <script>
        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const documentInput = document.getElementById('attachment');
            const file = documentInput.files[0];

            // if (!file) {
            //     alert('Please select a file to upload.');
            //     return;
            // }

            // Create a FormData object to hold the file data
            const formData = new FormData(this); // 'this' refers to the form element

            // Send an AJAX request to the server using Fetch API
            fetch('cat3_development_insert.php', {
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
    <script>
        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            const documentInput = document.getElementById('executiveSummary');
            const file = documentInput.files[0];

            // if (!file) {
            //     alert('Please select a file to upload.');
            //     return;
            // }

            // Create a FormData object to hold the file data
            const formData = new FormData(this); // 'this' refers to the form element

            // Send an AJAX request to the server using Fetch API
            fetch('cat3_development_insert.php', {
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
        $(document).ready(function () {
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
        $(document).ready(function () {
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "cat3_development_insert.php",
                    data: formData,
                    success: function (response) {
                        location.reload();
                        // alert(response);
                    }
                });
            });
        });
    </script>
    <div id="deleteConfirmationModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this entry?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                $('#deleteConfirmationModal').modal('show');
                $('#confirmDeleteBtn').click(function () {
                    $.ajax({
                        type: "POST",
                        url: "development_delete_entry.php",
                        data: {
                            id: id
                        },
                        success: function (response) {
                            location.reload();
                            // alert(response);
                        },
                        error: function (xhr, status, error) {
                        }
                    });
                    $('#deleteConfirmationModal').modal('hide');
                });
            });
        });

    </script>
</body>

</html>