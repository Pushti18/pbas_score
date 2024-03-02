<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM publication WHERE employee_id = '{$_SESSION['employee_id']}'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$employee_id = $_SESSION['employee_id'];
$category = $_SESSION['cat3'];

// $query = "UPDATE `cat3` SET `employee_id` = $employee_id and `category_id` = $category and `subcategory_id`=$subcategory_id";
// echo $query;
// if (mysqli_query($conn, $query)) {
//     // echo "Employee ID updated successfully in the database.";
// } else {
//     // echo "Error updating record: " . mysqli_error($conn);
// }
// $publication_details = isset($_SESSION['publication_details']) ? $_SESSION['publication_details'] : null;

// unset($_SESSION['publication_details']);
// mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<head>
    <title>PBAS(Performance Based Appraisal System)</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Publication</h4>
    </div>

    <div class='parent-container'>
        <div class='child-container'>
            <button type="button" class="btn btn-primary btn-bg" data-toggle="modal" data-target="#myModal">
                Add
            </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>TITLE</th>
                            <th>ACADEMIC YEAR</th>

                            <th>TYPE</th>
                            <th>journal_title</th>
                            <th>ACTION</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['title']}</td>";
                            echo "<td>{$row['year_of_publication']}</td>";
                            echo "<td>{$row['type']}</td>";
                            echo "<td>{$row['journal_title']}</td>";

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
                    <h5 class="modal-title" id="exampleModalLabel">Add Publication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="myForm" action="cat3_publication_insert.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <input type="hidden" name="subcategory_id" value="<?php echo $subcategory_id; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="region">Region:</label>
                                <select class="form-control" id="region" name="region">
                                    <option value="Please Select">Please Select</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                    <option value="Local">Local</option>
                                    <option value="National & International">National & International</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="type">Type:</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="Select Type">Select Type</option>
                                    <option value="Book">Book</option>
                                    <option value="Article">Article</option>
                                    <option value="Journal/Magazine Article">Journal/Magazine Article</option>
                                    <option value="Conference Paper Presentation">Conference Paper Presentation</option>
                                    <option value="Conference Poster Presentation">Conference Poster Presentation
                                    </option>
                                    <option value="Referral Journal">Referral Journal</option>
                                    <option value="Reputed Journal">Reputed Journal</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="author">Author:</label>
                                <input type="text" class="form-control" id="author" name="author">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role">
                                    <option value="Select Role">Select Role</option>
                                    <option value="Principal Author">Principal Author</option>
                                    <option value="Corresponding Author">Corresponding Author</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Mentor">Mentor</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="publication_group">Group:</label>
                                <select class="form-control" id="publication_group" name="publication_group">
                                    <option value="Select Group">Select Group</option>
                                    <option value="SCI">SCI</option>
                                    <option value="Non-SCI">Non-SCI</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="journalTitle">Journal/Magazine Title:</label>
                                <input type="text" class="form-control" id="journalTitle" name="journalTitle">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="coAuthor">Co-Author:</label>
                                <input type="text" class="form-control" id="coAuthor" name="coAuthor">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="month">Month of Publication:</label>
                                <select class="form-control" id="month" name="month">
                                    <?php
                                    $months = [
                                        "01" => "January",
                                        "02" => "February",
                                        "03" => "March",
                                        "04" => "April",
                                        "05" => "May",
                                        "06" => "June",
                                        "07" => "July",
                                        "08" => "August",
                                        "09" => "September",
                                        "10" => "October",
                                        "11" => "November",
                                        "12" => "December"
                                    ];

                                    foreach ($months as $key => $value) {
                                        echo "<option value='{$key}'>{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="year">Year of Publication:</label>
                                <select class="form-control" id="year" name="year">
                                    <?php
                                    $startYear = 1990;
                                    $endYear = 2050;

                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        echo "<option value='{$i}'>{$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="publisher">Publisher:</label>
                                <input type="text" class="form-control" id="publisher" name="publisher">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pubDate">Publication Date:</label>
                                <input type="date" class="form-control datepicker" id="pubDate" name="pubDate">
                            </div>
                            <script>
                                $(document).ready(function () {
                                    $("#pubDate").datepicker();
                                });
                            </script>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="volume">Volume No:</label>
                                <input type="text" class="form-control" id="volume" name="volume">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="page">Page No:</label>
                                <input type="text" class="form-control" id="page" name="page">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="attachment">Publication Front Image:</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="current_status_of_work">Current Status of Work:</label>
                                <select class="form-control" id="current_status_of_work" name="current_status_of_work">
                                    <option value="Select Group">Select Group</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Add Publication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="editForm" action="cat3_publication_update.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="entry_id" id="editEntryId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editregion">Region:</label>
                                <select class="form-control" id="editregion" name="editregion">
                                    <option value="Please Select">Please Select</option>
                                    <option value="National">National</option>
                                    <option value="International">International</option>
                                    <option value="Local">Local</option>
                                    <option value="National & International">National & International</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edittype">Type:</label>
                                <select class="form-control" id="edittype" name="edittype">
                                    <option value="Select Type">Select Type</option>
                                    <option value="Book">Book</option>
                                    <option value="Article">Article</option>
                                    <option value="Journal/Magazine Article">Journal/Magazine Article</option>
                                    <option value="Conference Paper Presentation">Conference Paper Presentation</option>
                                    <option value="Conference Poster Presentation">Conference Poster Presentation
                                    </option>
                                    <option value="Referral Journal">Referral Journal</option>
                                    <option value="Reputed Journal">Reputed Journal</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edittitle">Title:</label>
                                <input type="text" class="form-control" id="edittitle" name="edittitle">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editauthor">Author:</label>
                                <input type="text" class="form-control" id="editauthor" name="editauthor">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editrole">Role:</label>
                                <select class="form-control" id="editrole" name="editrole">
                                    <option value="Select Role">Select Role</option>
                                    <option value="Principal Author">Principal Author</option>
                                    <option value="Corresponding Author">Corresponding Author</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Mentor">Mentor</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editpublication_group">Group:</label>
                                <select class="form-control" id="editpublication_group" name="editpublication_group">
                                    <option value="Select Group">Select Group</option>
                                    <option value="SCI">SCI</option>
                                    <option value="Non-SCI">Non-SCI</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editjournalTitle">Journal/Magazine Title:</label>
                                <input type="text" class="form-control" id="editjournalTitle" name="editjournalTitle">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editcoAuthor">Co-Author:</label>
                                <input type="text" class="form-control" id="editcoAuthor" name="editcoAuthor">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editmonth">Month of Publication:</label>
                                <select class="form-control" id="editmonth" name="editmonth">
                                    <?php
                                    $months = [
                                        "01" => "January",
                                        "02" => "February",
                                        "03" => "March",
                                        "04" => "April",
                                        "05" => "May",
                                        "06" => "June",
                                        "07" => "July",
                                        "08" => "August",
                                        "09" => "September",
                                        "10" => "October",
                                        "11" => "November",
                                        "12" => "December"
                                    ];

                                    foreach ($months as $key => $value) {
                                        echo "<option value='{$key}'>{$value}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edityear">Year of Publication:</label>
                                <select class="form-control" id="edityear" name="edityear">
                                    <?php
                                    $startYear = 1990;
                                    $endYear = 2050;

                                    for ($i = $startYear; $i <= $endYear; $i++) {
                                        echo "<option value='{$i}'>{$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editpublisher">Publisher:</label>
                                <input type="text" class="form-control" id="editpublisher" name="editpublisher">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editpubDate">Publication Date:</label>
                                <input type="date" class="form-control datepicker" id="editpubDate" name="editpubDate">
                            </div>
                            <script>
                                $(document).ready(function () {
                                    $("#pubDate").datepicker();
                                });
                            </script>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="editvolume">Volume No:</label>
                                <input type="text" class="form-control" id="editvolume" name="editvolume">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editpage">Page No:</label>
                                <input type="text" class="form-control" id="editpage" name="editpage">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="attachment">Publication Front Image:</label>
                                <input type="file" class="form-control" id="attachment" name="attachment"
                                    accept=".jpg, .jpeg, .png, .gif">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="editcurrent_status_of_work">Current Status of Work:</label>
                                <select class="form-control" id="editcurrent_status_of_work"
                                    name="editcurrent_status_of_work">
                                    <option value="Select Group">Select Group</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>

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
                    url: "cat3_publication_update.php",
                    data: {
                        entry_id: entryId
                    },
                    success: function (response) {
                        // Parse the JSON response
                        var entryData = JSON.parse(response);
                        $('#editEntryId').val(entryId);
                        $('#editregion').val(entryData.region);
                        $('#edittype').val(entryData.type);
                        $('#edittitle').val(entryData.title);
                        $('#editauthor').val(entryData.author);
                        $('#editrole').val(entryData.role);
                        $('#editpublication_group').val(entryData.publication_group);
                        $('#editjournalTitle').val(entryData.journalTitle);
                        $('#editcoAuthor').val(entryData.coAuthor);
                        $('#editmonth').val(entryData.month);
                        $('#edityear').val(entryData.year);
                        $('#editpublisher').val(entryData.publisher);
                        $('#editpubDate').val(entryData.pubDate);
                        $('#editvolume').val(entryData.volume);
                        $('#editpage').val(entryData.page);
                        $('#editcurrent_status_of_work').val(entryData.current_status_of_work);

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

            if (!file) {
                alert('Please select a file to upload.');
                return;
            }

            // Create a FormData object to hold the file data
            const formData = new FormData(this); // 'this' refers to the form element

            // Send an AJAX request to the server using Fetch API
            fetch('cat3_publication_insert.php', {
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
            $("#myForm").submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "cat3_publication_insert.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        try {
                            var data = JSON.parse(response);
                            var table = $('#details_table').DataTable();

                            table.row.add([
                                data.title,
                                data.academic_year,
                                data.status,
                                data.type,
                                data.region,
                                data.approval_status,
                                '<button onclick="showDetails(\'' + data.title +
                                '\', \'' + data.current_status_of_work + '\', \'' +
                                data.type + '\', \'' + data.region + '\', \'' + data
                                    .pbas_score + '\')">Show Details</button>'
                            ]).draw();

                            // Clear the form
                            $("#myForm")[0].reset();
                        } catch (error) {
                            console.error("Error parsing JSON response: " + error);
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.error("AJAX request failed: " + errorThrown);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
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
                        url: "publication_delete_entry.php",
                        data: {
                            id: id
                        },
                        success: function (response) {
                            alert(response);
                        },
                        error: function (xhr, status, error) {
                        }
                    });
                    $('#deleteConfirmationModal').modal('hide');
                });
            });
        });
        // $(document).ready(function () {
        //     $('.btn-delete').click(function () {
        //         var id = $(this).data('id');
        //         $('#deleteConfirmationModal').modal('show');
        //         $('#confirmDeleteBtn').click(function () {
        //             $.ajax({
        //                 type: "POST",
        //                 url: "publication_delete_entry.php",
        //                 data: {
        //                     id: id
        //                 },
        //                 success: function (response) {
        //                     alert(response);
        //                 },
        //                 error: function (xhr, status, error) { }
        //             });
        //             $('#deleteConfirmationModal').modal('hide');
        //         });
        //     });
        // });
    </script>
</body>

</html>