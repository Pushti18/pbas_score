<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <style>
    <?php include 'css/ipr_output.css';
    ?>
    </style>
    <title>Company Details</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,100&display=swap"
        rel="stylesheet">
</head>

<body>
    <header class="header_container">
        <img class="mulogo_header" src="../images/MU_Logo.png" alt="MU logo">
        <h1 class="title">Student Corner</h1>
        <img class="ictlogo_header" src="../images/ICT_logo_text.png" alt="MU logo">
    </header>
    <a href="../dashboard.php" style="margin-left:0%;"><button>Home</button></a><br><br>

    <div class="nav_div" style="background-color:lightblue;">
        <h2 style="margin-left:42%;">Company Details</h2>
    </div>

    <a href="ipr_patent.php" style="margin-left:2.5%;"><button>Add New Data</button></a><br><br>

    <div class="main_div">
        <table id="details_table" class="display" cellspacing="0">
            <thead>
                <tr bgcolor='#21c8de'>
                    <th>Sr No.</th>
                    <th>Company Name</th>
                    <th>Location</th>
                    <th>Type of Company</th>
                    <th>Job Description</th>
                    <th>Skills Required</th>
                    <th>Website</th>
                    <th>Linkedln</th>
                    <th>Students Reference</th>
                    <th>Salary</th>
                    <th>Reviews</th>
                    <th>Students Reviews</th>
                    <th>Terms and Conditions</th>
                    <th>Stipend</th>
                    <th>Company Size</th>
                    <!-- <th>Date of Renew</th> -->
                    <th></th>


                </tr>
            </thead>
        </table>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript">
        </script>

        <script type="text/javascript">
        let session_id;
        $.ajax({
                method: "POST",
                url: "./get_session_id.php",
            })
            .done(function(response) {
                session_id = response;
            });
        $(document).ready(function() {
            $('#details_table').dataTable({
                scrollX: true,
                "processing": true,
                "ajax": "ipr_datatable_fetch.php",
                "columns": [{
                        data: 'id'
                    },
                    {
                        data: 'company_name'
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'type_of_company'
                    },
                    {
                        data: 'job_description'
                    },
                    {
                        data: 'skills_required'
                    },
                    {
                        data: 'website'
                    },
                    {
                        data: 'linkedln'
                    },
                    {
                        data: 'students_reference'
                    },
                    {
                        data: 'salary'
                    },
                    {
                        data: 'reviews'
                    },
                    {
                        data: 'students_reviews'
                    },
                    {
                        data: 'terms_and_conditions'
                    },
                    {
                        data: 'stipend'
                    },
                    {
                        data: 'company_size'
                    },
                    // {
                    //     data: 'date_of_renew'
                    // },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            if (session_id == "1327") {
                                return '<td><form action="ipr_view.php" method="POST"><input type="hidden"  style="width:30px;" name="id" value=' +
                                    data +
                                    '></input><input type="submit" value="View"></form></td><td><form action="ipr_edit.php" method="POST"><input type="hidden"  style="width:30px;" name="id" value=' +
                                    data +
                                    '></input><input type="submit" value="Edit"></form></td> <td><form action="ipr_delete.php" method="POST"><input type="hidden"  style="width:30px;" name="id" value=' +
                                    data +
                                    '></input><input type="submit" value="Delete"></form></td>';
                            } else {
                                return '<td><form action="ipr_view.php" method="POST"><input type="hidden"  style="width:30px;" name="id" value=' +
                                    data +
                                    '></input><input type="submit" value="View"></form></td>';
                            }


                        }
                    }
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [5, 10, 25, 50],
                    ['5 Files', '10 Files', '25 Files', '50 Files']
                ],
                buttons: [{
                        extend: 'copy',
                        text: 'Copy'
                    },
                    {
                        extend: 'print',
                        text: 'Print'
                    },
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                        filename: 'Company Details'
                    },
                    'pageLength'
                ],
            });
        });
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    </div>
</body>

</html>