<?php
session_start();

// Sample data (replace this with your data)
$data = array(
    array("1", "2021", "A", "90", '<a href="dashboard.php?employee_id=1">Go to Dashboard</a>'),
    array("2", "2022", "B", "85", '<a href="dashboard.php?employee_id=2">Go to Dashboard</a>'),
    // Add more rows as needed
);
?>

<!DOCTYPE html>
<html>

<head>
    <style>
    <?php include 'css/ipr_output.css';
    ?>
    </style>
    <title>Faculty Details</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,100&display=swap"
        rel="stylesheet">
    <style>
    /* Add custom styles for table borders */
    #details_table {
        border-collapse: collapse;
        width: 100%;
    }

    #details_table th,
    #details_table td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    #details_table th {
        background-color: #21c8de;
        color: white;
    }

    .dashboard-button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        display: inline-block;
        border-radius: 5px;
        margin-top: 10px;
        /* Adjust margin as needed */
    }

    .dashboard-button:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <header class="header_container">
        <img class="mulogo_header" src="images/mu-logo-2.png" alt="MU logo">
        <h1 class="title">Faculty Details</h1>
        <img class="ictlogo_header" src="images/ICT_logo_text.png" alt="MU logo">
    </header>

    <div class="nav_div" style="background-color: lightblue; text-align: center;">
        <h2>PBAS(Performance Based Appraisal System)</h2>
    </div>

    <a href="dashboard.php" class="dashboard-button">Dashboard</a>

    <div class="main_div">
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
    // JavaScript to handle click events on the dashboard links
    $(document).ready(function() {
        $('a.dashboard-link').click(function(event) {
            event.preventDefault();
            var employeeId = $(this).data('employee-id');

            // Perform any necessary actions with the employeeId
            // For example, you can make an AJAX request to add data to the database

            // After processing, you can redirect to the dashboard page
            window.location.href = 'dashboard.php?employee_id=' + employeeId;
        });
    });
    </script>

</body>

</html>