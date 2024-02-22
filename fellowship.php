<?php
session_start();
include("db_connection.php");

$category_title = isset($_GET['category_title']) ? $_GET['category_title'] : '';
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$subcategory_title = isset($_GET['subcategory_title']) ? $_GET['subcategory_title'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
global $conn;

$sql = "SELECT * FROM fellowship WHERE employee_id = '{$_SESSION['employee_id']}'";
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
    <title>Fellowships / Awards</title>
    <?php require "./components/category-table-script.php" ?>
</head>

<body>
    <?php require "./components/header.php" ?>

    <div class="main_div center">
        <h4>Fellowships / Awards</h4>
    </div>

    <div class='parent-container'>
        <div class="child-container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Add
            </button>

            <div class="table-container">
                <table id="details_table" class="display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>TITLE</th>
                            <th>ASSOCIATED ORGANIZATION</th>
                            <th>FELLOWSHIP AWARDS</th>
                            <th>PBAS YEAR</th>
                            <th>APPROVAL STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['title']}</td>";
                            echo "<td>{$row['associated_organization']}</td>";
                            echo "<td>{$row['fellowship_awards']}</td>";
                            echo "<td>{$row['pbas_year']}</td>";
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Fellowships / Awards</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <form id="myForm" action="cat3_fellowship_insert.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="associatedOrganization">Associated Organization:</label>
                                <input type="text" class="form-control" id="associatedOrganization"
                                    name="associatedOrganization">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fellowshipAwards">Fellowship/Awards:</label>
                                <select class="form-control" id="fellowshipAwards" name="fellowshipAwards">
                                    <option value="International">International Award/Fellowship</option>
                                    <option value="National">National Award</option>
                                    <option value="StateUniversity">State/University level</option>
                                </select>
                            </div>

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
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="attachment">Award/Fellowship Copy:</label>
                                <input type="file" class="form-control" id="attachment" name="attachment" accept=".pdf">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $associatedOrganization = isset($_POST['associatedOrganization']) ? $_POST['associatedOrganization'] : '';
            $fellowshipAwards = isset($_POST['fellowshipAwards']) ? $_POST['fellowshipAwards'] : '';
            $pbasYear = isset($_POST['pbasYear']) ? $_POST['pbasYear'] : '';
            $awardFellowshipCopy = isset($_FILES['awardFellowshipCopy']['name']) ? $_FILES['awardFellowshipCopy']['name'] : '';

            $pbasScore = 0;
            if (strpos($fellowshipAwards, 'International') !== false) {
                $pbasScore = 15;
            } elseif (strpos($fellowshipAwards, 'National') !== false) {
                $pbasScore = 10;
            } elseif (strpos($fellowshipAwards, 'StateUniversity') !== false) {
                $pbasScore = 5;
            }
            echo "Calculated PBAS Score: $pbasScore";
            move_uploaded_file($_FILES['awardFellowshipCopy']['tmp_name'], 'uploads/' . $awardFellowshipCopy);
        }
        ?>
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
        fetch('cat3_fellowship_insert.php', {
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
                url: "cat3_fellowship_insert.php",
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