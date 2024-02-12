<?php
session_start();
$data = array(
    array("1", "2021", "A", "90", '<a href="dashboard.php?employee_id=1">Go to Dashboard</a>'),
    array("2", "2022", "B", "85", '<a href="dashboard.php?employee_id=2">Go to Dashboard</a>'),
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Faculty Details</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="stylesheet" href="./css/common.css" />
    <style>
    .dataTables_filter input[type="search"] {
        width: 300px;
        padding: 8px 15px;
        box-shadow: none;
        margin-bottom: 10px;
    }

    .dataTables_filter label {
        margin-right: 15px;
    }
    </style>
</head>

<body>
    <?php require "./components/header.php" ?>
    <div class="main_div center ">
        <h2>PBAS Score List</h2>
    </div>

    <div class="parent-container">
        <div class="child-container">
            <table id="details_table" class="display" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Year</th>
                        <th>PBAS</th>
                        <th>Score</th>
                        <th>Dashboard</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $row) {
                        echo "<tr>";
                        foreach ($row as $cell) {
                            echo "<td>$cell</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript">
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
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    </div>

    <script>
    $(document).ready(function() {
        $('a.dashboard-link').click(function(event) {
            event.preventDefault();
            var employeeId = $(this).data('employee-id');
            window.location.href = 'dashboard.php?employee_id=' + employeeId;
        });
    });
    </script>
</body>

</html>