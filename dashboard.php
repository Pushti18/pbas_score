<?php
    session_start();
    // Sample data (replace this with your data)
    
?>
<!DOCTYPE html>
<html>

<head>
    <style>
    h2 {
        text-align: center;
        padding-right: 60px;

    }

    <?php include 'css/ipr_output.css';
    ?>
    </style>
    <title>Faculty Details</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,100&display=swap"
        rel="stylesheet">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
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

    <div class="container">
        <br><br><br>
        <h1>Dashboard</h1>

        <div class="row">
            <div class="col-md-6">
                <canvas id="myChart"></canvas>
                <?php
                    $dataPoints = array(
                        array("label" => "Cat 1", "value" => 20),
                        array("label" => "Cat 2", "value" => 10),
                        array("label" => "Cat 3", "value" => 20),
                        array("label" => "Total Points", "value" => 50),
                    );
                    $totalPoints = array_sum(array_column($dataPoints, 'value'));
                    ?>
                <script>
                // JavaScript code to create the pie chart
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: <?php echo json_encode(array_column($dataPoints, 'label')); ?>,
                        datasets: [{
                            label: 'Total Points: <?php echo $totalPoints; ?>',
                            data: <?php echo json_encode(array_column($dataPoints, 'value')); ?>,
                            backgroundColor: ['#FF6384', '#36A2EB',
                                '#FFCE56'
                            ], // Custom colors for each slice
                        }]
                    },
                    options: {
                        responsive: true, // Make the chart responsive to window resizing
                        legend: {
                            position: 'right', // Change 'right' to 'top', 'bottom', or 'left' as needed
                        },
                    }
                });
                </script>
            </div>

            <!-- ... (previous HTML code) ... -->

            <div class="col-md-6">
                <h2>Planner</h2>
                <form id="myForm" action="process.php" method="POST">

                    <div class="form-row">
                        <div class="col-md">
                            <label for="year">Year:</label>
                            <select id="year" name="year" class="form-control">
                                <option value="">Select Year</option>
                                <?php
                                $currentYear = date('Y');
                                // Generate year options for the next 5 years
                                for ($i = 0; $i < 5; $i++) {
                                    $yearOption = $currentYear . '-' . ($currentYear + 1);
                                    echo '<option value="' . $yearOption . '">' . $yearOption . '</option>';
                                    $currentYear++;
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="target">Target:</label>
                                <input type="text" class="form-control" id="target" name="target">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="category">Category:</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="Category 1">Category 1</option>
                                    <option value="Category 2">Category 2</option>
                                    <option value="Category 3">Category 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <!-- ... (remaining HTML code) ... -->

        </div>
    </div>

    </div>

    <script>
    $(document).ready(function() {
        $("#myForm").submit(function(e) {
            e.preventDefault();

            // Serialize form data
            var formData = $(this).serialize();

            // Get the selected category value
            var selectedCategory = $("#category").val();

            // Determine the redirect URL based on the category
            var redirectUrl = '';
            switch (selectedCategory) {
                case 'Category 1':
                    redirectUrl = 'cat1.php?category=' + category + '&employee_id=' + employeeId;
                    break;
                case 'Category 2':
                    redirectUrl = 'cat2.php?category=' + category + '&employee_id=' + employeeId;
                    break;
                case 'Category 3':
                    redirectUrl = 'cat3.php?category=' + category + '&employee_id=' + employeeId;
                    break;
                default:
                    // Handle cases where no category or an invalid category is selected
                    alert("Please select a valid category.");
                    return false; // Prevent form submission
            }

            // Send an AJAX request to the PHP script
            $.ajax({
                type: "POST",
                url: "process.php",
                data: formData,
                success: function(response) {
                    // Display a popup or handle the response as needed
                    alert(response);

                    // Redirect to the selected category page
                    window.location.href = redirectUrl;
                }
            });
        });

        // ... (remaining code)
    });



    // When a year is selected
    $('#year').on('change', function() {
        // Enable the target input and category dropdown
        $('#target').prop('disabled', false);
        $('#category').prop('disabled', false);
        // Optionally, clear any previous values
        $('#target').val('');
        $('#category').val('');
    });

    $('#target').on('input', function() {
        // Enable the "Cat" dropdown if target is not empty
        if ($(this).val().length > 0) {
            $('#category').prop('disabled', false);
        } else {
            $('#category').prop('disabled', true);
        }
    });
    var redirectUrl = '';
    switch (selectedCategory) {
        case 'Category 1':
            redirectUrl = 'cat_1.php';
            break;
        case 'Category 2':
            redirectUrl = 'cat_2.php'; // Replace with the appropriate file for Cat 2
            break;
        case 'Category 3':
            redirectUrl = 'cat_3.php'; // Replace with the appropriate file for Cat 3
            break;
        default:
            // Handle cases where no category or an invalid category is selected
            alert("Please select a valid category.");
            return false; // Prevent form submission
    }
    success: function(response) {
        // Display a popup
        alert(response);

        // Redirect to the next page
        window.location.href =
            redirectUrl; // You should define redirectUrl based on the selected category
    }
    </script>

</body>

</html>