<?php

session_start();
include ("db_connection.php");
global $connection;
if (!isset($_SESSION['employee_id'])) {
    header("Location: ./login.php");
    exit();
}

$employee_id = $_SESSION['employee_id'];

// Retrieving employee_id from URL parameter
if (isset($_GET['employee_id'])) {
    $employee_id_from_url = $_GET['employee_id'];
    // You can compare this with the logged-in employee_id if needed
}
$sql = "SELECT id, name FROM employee";

$result = $conn->query($sql);
// echo ($sql);
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
    // Fetch Category 1 data for current employee
    $cat1_sql = "SELECT SUM(total_points) as total_points FROM (
        SELECT SUM(points) as total_points FROM direct_teaching WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM exam_duties WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM learning_methodologies WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM courses WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'
        UNION ALL
        SELECT SUM(points) as total_points FROM mentoring WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'
    ) as total_points_table";
    // echo ($cat1_sql);
    $cat1_result = $conn->query($cat1_sql);
    $cat1_row = $cat1_result->fetch_assoc();
    $data[count($data) - 1]['cat1_total_points'] = $cat1_row['total_points'];


    $cat2_sql = "SELECT 
    (SELECT SUM(points) FROM discipline WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') +
    (SELECT SUM(points) FROM othercocurricular WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') +
    (SELECT SUM(points) FROM extension WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') +
    (SELECT SUM(points) FROM administrative WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') +
    (SELECT SUM(points) FROM others WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') +
    (SELECT SUM(points) FROM development_activities WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') +
    (SELECT SUM(points) FROM participation WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2') as total_points";

    $cat2_result = $conn->query($cat2_sql);
    $cat2_row = $cat2_result->fetch_assoc();
    $data[count($data) - 1]['cat2_total_points'] = $cat2_row['total_points'];

    $cat3_sql = "SELECT 
        (SELECT SUM(pbas_score) FROM research WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM project_output WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM guidance WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM fellowship WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM expert WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3') +
        (SELECT SUM(pbas_score) FROM development WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3') as total_points";

    $cat3_result = $conn->query($cat3_sql);
    $cat3_row = $cat3_result->fetch_assoc();
    $data[count($data) - 1]['cat3_total_points'] = $cat3_row['total_points'];

    $data[count($data) - 1]['total_achieved'] =
        $cat1_row['total_points'] + $cat2_row['total_points'] + $cat3_row['total_points'];

    $target_sql = "SELECT target FROM pbas_score WHERE employee_id = " . $row['id'];
    $target_result = $conn->query($target_sql);
    $target_row = $target_result->fetch_assoc();
    $data[count($data) - 1]['target_score'] = $target_row['target'];

    $year_sql = "SELECT year FROM pbas_score WHERE employee_id = " . $row['id'];
    $year_result = $conn->query($year_sql);
    $year_row = $year_result->fetch_assoc();
    $data[count($data) - 1]['year'] = $year_row['year'];


    // $discipline = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity 
    //            FROM discipline 
    //            WHERE employee_id = " . $_SESSION['employee_id'] . " AND cat2_id = 'cat2'";

    // $cat2_result = $conn->query($discipline);

    // if ($cat2_result->num_rows > 0) {
    //     // Initialize an empty array to store the fetched data
    //     $data_sql = array();

    //     // Loop through each row of the result set
    //     while ($cat2_row = $cat2_result->fetch_assoc()) {
    //         // Add each row to the data array
    //         $data_sql[] = array(
    //             'points' => $cat2_row['points'],
    //             'hoursSpentAnswerBook' => $cat2_row['hoursSpentAnswerBook'],
    //             'mainActivity' => $cat2_row['mainActivity'],
    //             'subActivity' => $cat2_row['subActivity']
    //         );
    //     }

    //     // Encode the data array to JSON and echo it
    //     echo json_encode($data_sql);
    $discipline = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM discipline
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($discipline);

    // Structure Discipline Data
    $disciplineData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $disciplineData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['disciplineData'] = $disciplineData;



    $othercocurricular = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM othercocurricular
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($othercocurricular);

    // Structure Discipline Data
    $othercocurricularData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $othercocurricularData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['othercocurricularData'] = $othercocurricularData;


    $extension = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM extension
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($extension);

    // Structure Discipline Data
    $extensionData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $extensionData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['extensionData'] = $extensionData;


    $administrative = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM administrative
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($administrative);

    // Structure Discipline Data
    $administrativeData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $administrativeData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['administrativeData'] = $administrativeData;

    $participation = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM participation
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($participation);

    // Structure Discipline Data
    $participationData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $participationData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['participationData'] = $participationData;


    $others = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM others
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($others);

    // Structure Discipline Data
    $othersData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $particothersDataipationData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['othersData'] = $othersData;


    $development_activities = "SELECT points, hoursSpentAnswerBook, mainActivity, subActivity
                    FROM development_activities
                    WHERE employee_id = " . $row['id'] . " AND cat2_id = 'cat2'";
    // echo ($discipline);
    $cat2_result = $conn->query($development_activities);

    // Structure Discipline Data
    $development_activitiesData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $development_activitiesData[] = [
                $cat2_row['points'],
                $cat2_row['hoursSpentAnswerBook'],
                $cat2_row['mainActivity'],
                $cat2_row['subActivity']
            ];
        }
    }

    $data[count($data) - 1]['development_activitiesData'] = $development_activitiesData;


    $publication = "SELECT region, type, role, publication_group,current_status_of_work,co_author
                    FROM publication
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    // echo ($discipline);
    $cat2_result = $conn->query($publication);

    // Structure Discipline Data
    $publicationData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $publicationData[] = [
                $cat2_row['region'],
                $cat2_row['type'],
                $cat2_row['role'],
                $cat2_row['publication_group'],
                $cat2_row['current_status_of_work'],
                $cat2_row['co_author'],

            ];
        }
    }

    $data[count($data) - 1]['publicationData'] = $publicationData;


    $research = "SELECT project_category, project_for, funding_agency, grant_amount,project_duration,pbas_score
                    FROM research
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    // echo ($discipline);
    $cat2_result = $conn->query($research);

    // Structure Discipline Data
    $researchData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $researchData[] = [
                $cat2_row['project_category'],
                $cat2_row['project_for'],
                $cat2_row['funding_agency'],
                $cat2_row['project_duration'],
                $cat2_row['grant_amount'],
                $cat2_row['pbas_score'],

            ];
        }
    }

    $data[count($data) - 1]['researchData'] = $researchData;


    $project_output = "SELECT title, region, patent_register,pbas_score
                    FROM project_output
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    // echo ($discipline);
    $cat2_result = $conn->query($project_output);

    // Structure Discipline Data
    $project_outputData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $project_outputData[] = [
                $cat2_row['title'],
                $cat2_row['region'],
                $cat2_row['patent_register'],
                $cat2_row['pbas_score'],

            ];
        }
    }

    $data[count($data) - 1]['project_outputData'] = $project_outputData;


    $guidance = "SELECT name_of_university, degree, project_type,current_status_of_work,pbas_score
                    FROM guidance
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    $cat2_result = $conn->query($guidance);
    $guidanceData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $guidanceData[] = [
                $cat2_row['name_of_university'],
                $cat2_row['degree'],
                $cat2_row['project_type'],
                $cat2_row['current_status_of_work'],
                $cat2_row['pbas_score'],


            ];
        }
    }
    $data[count($data) - 1]['guidanceData'] = $guidanceData;


    $fellowship = "SELECT title, associated_organization, fellowship_awards,pbas_score
                    FROM fellowship
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    $cat2_result = $conn->query($fellowship);
    $fellowshipData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $fellowshipData[] = [
                $cat2_row['title'],
                $cat2_row['associated_organization'],
                $cat2_row['fellowship_awards'],
                $cat2_row['pbas_score'],


            ];
        }
    }
    $data[count($data) - 1]['fellowshipData'] = $fellowshipData;


    $expert = "SELECT topic, talk_level, type,pbas_score
                    FROM expert
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    $cat2_result = $conn->query($expert);
    $expertData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $expertData[] = [
                $cat2_row['topic'],
                $cat2_row['talk_level'],
                $cat2_row['type'],
                $cat2_row['pbas_score'],


            ];
        }
    }
    $data[count($data) - 1]['expertData'] = $expertData;

    $development = "SELECT title, research_type, sponsor_type,pbas_score
                    FROM development
                    WHERE employee_id = " . $row['id'] . " AND cat3_id = 'cat3'";
    $cat2_result = $conn->query($development);
    $developmentData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $developmentData[] = [
                $cat2_row['title'],
                $cat2_row['research_type'],
                $cat2_row['sponsor_type'],
                $cat2_row['pbas_score'],


            ];
        }
    }
    $data[count($data) - 1]['developmentData'] = $developmentData;

    $direct_teaching = "SELECT university,degree,projectType,statusofwork,points
                    FROM direct_teaching
                    WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'";
    $cat2_result = $conn->query($direct_teaching);
    $direct_teachingData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $direct_teachingData[] = [
                $cat2_row['university'],
                $cat2_row['degree'],
                $cat2_row['projectType'],
                $cat2_row['statusofwork'],
                $cat2_row['points'],

            ];
        }
    }
    $data[count($data) - 1]['direct_teachingData'] = $direct_teachingData;


    $exam_duties = "SELECT stream_name,	course_name, question_paper_count, examinations_count,answer_book_count,points
                    FROM exam_duties
                    WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'";
    $cat2_result = $conn->query($exam_duties);
    $exam_dutiesData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $exam_dutiesData[] = [
                $cat2_row['stream_name'],
                $cat2_row['course_name'],
                $cat2_row['question_paper_count'],
                $cat2_row['answer_book_count'],
                $cat2_row['points'],

            ];
        }
    }
    $data[count($data) - 1]['exam_dutiesData'] = $exam_dutiesData;


    $learning_methodologies = "SELECT 	courseName,	natureOfInnovation, hoursSpentInnovation, points
                    FROM learning_methodologies
                    WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'";
    $cat2_result = $conn->query($learning_methodologies);
    $learning_methodologiesData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $learning_methodologiesData[] = [
                $cat2_row['courseName'],
                $cat2_row['natureOfInnovation'],
                $cat2_row['hoursSpentInnovation'],
                $cat2_row['points'],

            ];
        }
    }
    $data[count($data) - 1]['learning_methodologiesData'] = $learning_methodologiesData;


    $courses = "SELECT courseName, hoursSpentInnovation, points
                                FROM courses
                                WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'";
    $cat2_result = $conn->query($courses);
    $coursesData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $coursesData[] = [
                $cat2_row['courseName'],
                $cat2_row['hoursSpentInnovation'],
                $cat2_row['points'],

            ];
        }
    }
    $data[count($data) - 1]['coursesData'] = $coursesData;


    $mentoring = "SELECT mentorName, hoursSpent, points
                                FROM mentoring
                                WHERE employee_id = " . $row['id'] . " AND cat1_id = 'cat1'";
    $cat2_result = $conn->query($mentoring);
    $mentoringData = array();
    if ($cat2_result->num_rows > 0) {
        while ($cat2_row = $cat2_result->fetch_assoc()) {
            $mentoringData[] = [
                $cat2_row['mentorName'],
                $cat2_row['hoursSpent'],
                $cat2_row['points'],

            ];
        }
    }
    $data[count($data) - 1]['mentoringData'] = $mentoringData;

}
// echo json_encode($data);

?>

<!DOCTYPE html>
<html>

<head>
    <style>
    </style>
    <title>Student Participation</title>
    <?php require "./components/category-table-script.php" ?>
    <!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;1,100&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/common.css" /> -->
</head>

<body>
    <?php require "./components/header.php" ?>
    <div class="main_div center">
        <h3>Faculty Details of PBAS</h3>
        <a href="./dashboard.php?id=<?php echo $employee_id; ?>" style="float: right;">
            <button id="myButton">Add PBAS</button>
        </a>
        <!-- <canvas id="pie-chart" width="400" height="400"></canvas> -->
        <!-- <p>Your ID: <?php echo $employee_id; ?></p> -->
    </div>
    </div>
    <div class="main_div" style="text-align: center;">
        <table id="details_table" class="display" cellspacing="0">
            <thead>
                <tr bgcolor='#21c8de'>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Year</th>
                    <th>Target Set</th>
                    <th>Target Achieved</th>
                    <th>Category 1</th>
                    <th>Category 2</th>
                    <th>Category 3</th>
                    <th>Summary</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td>
                            <?= $row['id'] ?>
                        </td>
                        <td>
                            <?= $row['name'] ?>
                        </td>
                        <td>
                            <?= $row['year'] ?>
                        </td>
                        <td>
                            <?= $row['target_score'] ?>
                        </td>
                        <td>
                            <?= $row['total_achieved'] ?>
                        </td>
                        <td>
                            <?= $row['cat1_total_points'] ?>
                        </td>
                        <td>
                            <?= $row['cat2_total_points'] ?>
                        </td>
                        <td>
                            <?= $row['cat3_total_points'] ?>
                        </td>
                        <td>
                            <button id="btn-generate" data-sr-no="<?= $row['id'] ?>">Generate PDF</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js" charset="utf8" type="text/javascript">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#details_table').dataTable({
                    // scrollX: true,
                    // "processing": true,
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [5, 10, 25, 50],
                        ['5 Files', '10 Files', '25 Files', '50 Files']
                    ],
                });


            });
        </script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {
                // var buttonElement = document.querySelectorAll("#btn-generate");
                // buttonElement.addEventListener('click', function () {
                var buttons = document.querySelectorAll("#btn-generate");
                buttons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        var srNo = this.dataset.srNo;
                        console.log(srNo);


                        var tableData = [];

                        var table = document.getElementById('details_table');
                        var rows = table.getElementsByTagName('tr');
                        for (var i = 1; i < rows.length; i++) {
                            var cells = rows[i].getElementsByTagName('td');
                            if (cells[0].innerText == srNo) {
                                var rowData = [];
                                for (var j = 0; j < cells.length - 1; j++) {
                                    rowData.push(cells[j].innerText);
                                }
                                tableData.push(rowData);
                                break;
                            }
                        }

                        var data = <?php echo json_encode($data); ?>;
                        var findRecord = data.find((d) => d.id === srNo);
                        console.log("Data : ", findRecord);
                        var disciplineData = findRecord.disciplineData;
                        var othercocurricularData = findRecord.othercocurricularData;
                        var extensionData = findRecord.extensionData;
                        var administrativeData = findRecord.administrativeData;
                        var participationData = findRecord.participationData;
                        var othersData = findRecord.othersData;
                        var development_activitiesData = findRecord.development_activitiesData;
                        var publicationData = findRecord.publicationData;

                        var tableBody = [];
                        var tableBody_cat2 = [];
                        var tableBody_cat2_c = [];
                        tableBody_cat2_c.push([
                            { text: 'Points', style: 'tableHeader' },
                            { text: 'Hours Spent', style: 'tableHeader' },
                            { text: 'Main Activity', style: 'tableHeader' },
                            { text: 'Sub Activity', style: 'tableHeader' }
                        ]);
                        tableBody_cat2.push([
                            { text: 'Points', style: 'tableHeader' },
                            { text: 'Hours Spent', style: 'tableHeader' },
                            { text: 'Main Activity', style: 'tableHeader' },
                            { text: 'Sub Activity', style: 'tableHeader' }
                        ]);
                        tableBody.push([
                            { text: 'Points', style: 'tableHeader' },
                            { text: 'Hours Spent', style: 'tableHeader' },
                            { text: 'Main Activity', style: 'tableHeader' },
                            { text: 'Sub Activity', style: 'tableHeader' }
                        ]);
                        disciplineData.forEach(function (row) {
                            tableBody.push(row);
                        });

                        othercocurricularData.forEach(function (row) {
                            tableBody.push(row);
                        });
                        extensionData.forEach(function (row) {
                            tableBody.push(row);
                        });

                        administrativeData.forEach(function (row) {
                            tableBody_cat2.push(row);
                        });
                        participationData.forEach(function (row) {
                            tableBody_cat2.push(row);
                        });
                        othersData.forEach(function (row) {
                            tableBody_cat2.push(row);
                        });
                        development_activitiesData.forEach(function (row) {
                            tableBody_cat2_c.push(row);
                        });

                        var tableBody_cat3_a = [];
                        tableBody_cat3_a.push([
                            { text: 'Region', style: 'tableHeader' },
                            { text: 'Type', style: 'tableHeader' },
                            { text: 'Role', style: 'tableHeader' },
                            { text: 'Publication Group', style: 'tableHeader' },
                            { text: 'Current Status Of work', style: 'tableHeader' },
                            { text: 'Co Author', style: 'tableHeader' }
                        ]);
                        publicationData.forEach(function (row) {
                            tableBody_cat3_a.push(row);
                        });

                        var researchData = findRecord.researchData;

                        var tableBody_cat3_b = [];
                        tableBody_cat3_b.push([
                            { text: 'Project Category', style: 'tableHeader' },
                            { text: 'Project For', style: 'tableHeader' },
                            { text: 'Funding Agency', style: 'tableHeader' },
                            { text: 'Project Duration', style: 'tableHeader' },
                            { text: 'Grant Amount', style: 'tableHeader' },
                            { text: 'PBAS Score', style: 'tableHeader' }

                        ]);
                        researchData.forEach(function (row) {
                            tableBody_cat3_b.push(row);
                        });


                        var project_outputData = findRecord.project_outputData;

                        var tableBody_cat3_c = [];
                        tableBody_cat3_c.push([
                            { text: 'Title', style: 'tableHeader' },
                            { text: 'Region', style: 'tableHeader' },
                            { text: 'Patent Register', style: 'tableHeader' },
                            { text: 'PBAS Score', style: 'tableHeader' },


                        ]);
                        project_outputData.forEach(function (row) {
                            tableBody_cat3_c.push(row);
                        });

                        var guidanceData = findRecord.guidanceData;

                        var tableBody_cat3_d = [];
                        tableBody_cat3_d.push([
                            { text: 'Name Of University', style: 'tableHeader' },
                            { text: 'Degree', style: 'tableHeader' },
                            { text: 'Project Type', style: 'tableHeader' },
                            { text: 'Current Status of Work', style: 'tableHeader' },
                            { text: 'PBAS Score', style: 'tableHeader' },

                        ]);
                        guidanceData.forEach(function (row) {
                            tableBody_cat3_d.push(row);
                        });



                        var fellowshipData = findRecord.fellowshipData;

                        var tableBody_cat3_e = [];
                        tableBody_cat3_e.push([
                            { text: 'Title', style: 'tableHeader' },
                            { text: 'Associated Organization', style: 'tableHeader' },
                            { text: 'Fellowship Awards', style: 'tableHeader' },
                            { text: 'PBAS Score', style: 'tableHeader' },

                        ]);
                        fellowshipData.forEach(function (row) {
                            tableBody_cat3_e.push(row);
                        });


                        var expertData = findRecord.expertData;

                        var tableBody_cat3_e_2 = [];
                        tableBody_cat3_e_2.push([
                            { text: 'Topic', style: 'tableHeader' },
                            { text: 'Talk Level', style: 'tableHeader' },
                            { text: 'Type', style: 'tableHeader' },
                            { text: 'PBAS Score', style: 'tableHeader' },

                        ]);
                        expertData.forEach(function (row) {
                            tableBody_cat3_e_2.push(row);
                        });



                        var developmentData = findRecord.developmentData;
                        var tableBody_cat3_f = [];
                        tableBody_cat3_f.push([
                            { text: 'Title', style: 'tableHeader' },
                            { text: 'Research Type', style: 'tableHeader' },
                            { text: 'Sponsor Type', style: 'tableHeader' },
                            { text: 'PBAS Score', style: 'tableHeader' },


                        ]);
                        developmentData.forEach(function (row) {
                            tableBody_cat3_f.push(row);
                        });


                        var direct_teachingData = findRecord.direct_teachingData;
                        var tableBody_cat1_a = [];
                        tableBody_cat1_a.push([
                            { text: 'University', style: 'tableHeader' },
                            { text: 'Degree', style: 'tableHeader' },
                            { text: 'Project Type', style: 'tableHeader' },
                            { text: 'Status of Work', style: 'tableHeader' },
                            { text: 'Points', style: 'tableHeader' },
                        ]);
                        direct_teachingData.forEach(function (row) {
                            tableBody_cat1_a.push(row);
                        });

                        var exam_dutiesData = findRecord.exam_dutiesData;
                        var tableBody_cat1_b = [];
                        tableBody_cat1_b.push([
                            { text: 'Stream Name', style: 'tableHeader' },
                            { text: 'Course Name', style: 'tableHeader' },
                            { text: 'Question Paper Count', style: 'tableHeader' },
                            { text: 'Answer Book Count', style: 'tableHeader' },
                            { text: 'Points', style: 'tableHeader' },


                        ]);
                        exam_dutiesData.forEach(function (row) {
                            tableBody_cat1_b.push(row);
                        });

                        var learning_methodologiesData = findRecord.learning_methodologiesData;
                        var tableBody_cat1_c = [];
                        tableBody_cat1_c.push([
                            { text: 'Course Name', style: 'tableHeader' },
                            { text: 'Nature Of Innovation', style: 'tableHeader' },
                            { text: 'Hours Spent Innovation', style: 'tableHeader' },
                            { text: 'Points', style: 'tableHeader' },
                        ]);
                        learning_methodologiesData.forEach(function (row) {
                            tableBody_cat1_c.push(row);
                        });


                        var coursesData = findRecord.coursesData;
                        var tableBody_cat1_c_b = [];
                        tableBody_cat1_c_b.push([
                            { text: 'Course Name', style: 'tableHeader' },
                            { text: 'Hours Spent Innovation', style: 'tableHeader' },
                            { text: 'Points', style: 'tableHeader' },

                        ]);
                        coursesData.forEach(function (row) {
                            tableBody_cat1_c_b.push(row);
                        });


                        var mentoringData = findRecord.mentoringData;
                        var tableBody_cat1_c_c = [];
                        tableBody_cat1_c_c.push([
                            { text: 'Mentor Name', style: 'tableHeader' },
                            { text: 'Hours Spent', style: 'tableHeader' },
                            { text: 'Points', style: 'tableHeader' },

                        ]);
                        mentoringData.forEach(function (row) {
                            tableBody_cat1_c_c.push(row);
                        });
                        // var totalAchieved = findRecord.total_achieved;
                        // console.log(totalAchieved);
                        // var targetScore = findRecord.target_score;
                        // var cat1Performance = findRecord.cat1_total_points;
                        // var cat2Performance = findRecord.cat2_total_points;
                        // var cat3Performance = findRecord.cat3_total_points;
                        // var remainingPoints = targetScore - totalAchieved;
                        // var pieChartData = [totalAchieved, remainingPoints, cat1Performance, cat2Performance, cat3Performance];
                        // var pieChartLabels = ['Total Achieved', 'Remaining', 'Category 1', 'Category 2', 'Category 3'];
                        // var backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#FF5733', '#6EFF33']; // Adjust colors as needed

                        // var canvas = document.createElement('canvas');
                        // canvas.width = 600; // Adjust canvas size as needed for better clarity
                        // canvas.height = 400;

                        // // Create a bar chart
                        // var ctx = canvas.getContext('2d');
                        // var myChart = new Chart(ctx, {
                        //     type: 'pie',
                        //     data: {
                        //         labels: pieChartLabels,
                        //         datasets: [{
                        //             data: pieChartData,
                        //             backgroundColor: backgroundColors,
                        //             borderWidth: 1
                        //         }]
                        //     },
                        //     options: {
                        //         responsive: false,
                        //         legend: {
                        //             display: false
                        //         },
                        //         scales: {
                        //             y: {
                        //                 beginAtZero: true // Start y-axis from zero
                        //             }
                        //         },
                        //         plugins: {
                        //             datalabels: {
                        //                 anchor: 'end',
                        //                 align: 'end',
                        //                 color: '#fff', // Set color for the labels
                        //                 formatter: (value, ctx) => {
                        //                     return value; // Return the value of each bar
                        //                 }
                        //             }
                        //         }
                        //     }
                        // });
                        var totalAchieved = findRecord.total_achieved;
                        var targetScore = findRecord.target_score;
                        var cat1Performance = findRecord.cat1_total_points;
                        var cat2Performance = findRecord.cat2_total_points;
                        var cat3Performance = findRecord.cat3_total_points;
                        var remainingPoints = targetScore - totalAchieved;
                        var pieChartData = [totalAchieved, remainingPoints, cat1Performance, cat2Performance, cat3Performance];
                        var pieChartLabels = ['Total Achieved', 'Remaining', 'Category 1', 'Category 2', 'Category 3'];
                        var backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#FF5733', '#6EFF33']; // Adjust colors as needed

                        var canvas = document.createElement('canvas');
                        canvas.width = 600; // Adjust canvas size as needed for better clarity
                        canvas.height = 400;

                        // Create a bar chart
                        var ctx = canvas.getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: pieChartLabels,
                                datasets: [{
                                    data: pieChartData,
                                    backgroundColor: backgroundColors,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: false,
                                legend: {
                                    display: false
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true // Start y-axis from zero
                                    }
                                },
                                plugins: {
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'end',
                                        color: '#000', // Set color for the labels
                                        formatter: function (value, context) {
                                            return value; // Return the value of each bar
                                        }
                                    }
                                }
                            }
                        });

                        // var totalAchieved = findRecord.total_achieved;
                        // var targetScore = findRecord.target_score;
                        // var cat1Performance = findRecord.cat1_total_points;
                        // var cat2Performance = findRecord.cat2_total_points;
                        // var cat3Performance = findRecord.cat3_total_points;
                        // var remainingPoints = targetScore - totalAchieved;
                        // var pieChartData = [totalAchieved, remainingPoints, cat1Performance, cat2Performance, cat3Performance];
                        // var pieChartLabels = ['Total Achieved', 'Remaining', 'Category 1', 'Category 2', 'Category 3'];
                        // var backgroundColors = ['#FF6384', '#36A2EB', '#FFCE56', '#FF5733', '#6EFF33']; // Adjust colors as needed

                        // var canvas = document.createElement('canvas');
                        // canvas.width = 600; // Adjust canvas size as needed for better clarity
                        // canvas.height = 400;

                        // // Create a bar chart
                        // var ctx = canvas.getContext('2d');
                        // var myChart = new Chart(ctx, {
                        //     type: 'pie',
                        //     data: {
                        //         labels: pieChartLabels,
                        //         datasets: [{
                        //             data: pieChartData,
                        //             backgroundColor: backgroundColors,
                        //             borderWidth: 1
                        //         }]
                        //     },
                        //     options: {
                        //         responsive: false,
                        //         legend: {
                        //             display: false
                        //         },
                        //         scales: {
                        //             y: {
                        //                 beginAtZero: true // Start y-axis from zero
                        //             }
                        //         },
                        //         plugins: {
                        //             datalabels: {
                        //                 anchor: 'end',
                        //                 align: 'end',
                        //                 color: '#fff', // Set color for the labels
                        //                 formatter: (value, ctx) => {
                        //                     return value; // Return the value of each bar
                        //                 }
                        //             }
                        //         }
                        //     }
                        // });

                        setTimeout(function () {
                            // Convert the chart to an image
                            var chartImage = canvas.toDataURL();

                            var docDefinition = {
                                content: [
                                    { text: 'PBAS Report - Sr. No. ' + srNo, style: 'header' },
                                    { text: 'This report provides an overview of employee progress within the Performance-Based Bonus Scheme (PBAS) for Categories 1, 2, and 3. It offers insights into individual and overall performance, allowing for informed decision-making and targeted support', style: 'pdfContent' },
                                    { text: 'Performance Summary:', style: 'subheader' },
                                    { text: 'The total points achieved are ' + findRecord.total_achieved + ' out of a target of ' + findRecord.target_score + '.', style: 'pdfContent' },
                                    { text: 'Category 1 Performance: ' + findRecord.cat1_total_points, style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category 2 Performance: ' + findRecord.cat2_total_points, style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category 3 Performance: ' + findRecord.cat3_total_points, style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    {
                                        canvas: [
                                            { type: 'line', x1: 0, y1: 0, x2: 520, y2: 0, lineWidth: 1, lineColor: '#000' }
                                        ]
                                    },
                                    {
                                        image: chartImage,
                                        width: 400 // Adjust the width as needed
                                    },
                                    { text: 'CATEGORY : I - Teaching, Learning and Evaluation related activities', style: 'subheader' },
                                    { text: 'Category : I-A - Direct Teaching (Learning / Tutorial / Practical / Project Supervision / Field Work) - To give Semesterwise / Termwise details wherever necessary', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : I-A Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat1_a
                                        }
                                    },
                                    { text: 'Category : I-B - Examination duties (Invigilation, question paper setting, evaluation/assessment of answer scripts) as per allotment', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : I-B:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat1_b
                                        }
                                    },
                                    {
                                        text: 'Category: I - C - Innovative Teaching - Learning methodologies, Updating of subject contents / courses, meentoring etc', style: 'pdfContent', margin: [0, 10, 0, 10]
                                    },
                                    { text: 'Category: I - C Data:', style: 'subheader' },

                                    { text: 'Category I-C(i) - Innovation Teaching - Learning methodologies', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category I-C(i) Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat1_c
                                        }
                                    },
                                    { text: 'Category I-C(ii) - Updating of subject contents /courses', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category I-C(ii) Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto'],
                                            body: tableBody_cat1_c_b
                                        }
                                    },
                                    {
                                        text: 'Category I- C(iii) - Mentoring', style: 'pdfContent', margin: [0, 10, 0, 10]
                                    },
                                    { text: 'Category I- C(iii) Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto'],
                                            body: tableBody_cat1_c_c
                                        }
                                    },
                                    { text: '', margin: [0, 10, 0, 10] },
                                    {
                                        canvas: [
                                            { type: 'line', x1: 0, y1: 0, x2: 520, y2: 0, lineWidth: 1, lineColor: '#000' }
                                        ]
                                    },
                                    { text: 'CATEGORY : II - Professional development, Co-curricular and extension activities', style: 'subheader' },
                                    { text: 'Category : II-A - Student related co-curricular, extension and field based activities', style: 'pdfContent', margin: [0, 10, 0, 10] },

                                    { text: 'Category II-A(i) - Discipline related co-curricular activities (e.g. remedial classes, carrer counseling, study visit, student seminar and other events)', style: 'pdfContent', margin: [0, 10, 0, 10] },

                                    { text: 'Category II-A(ii) - Other co-curricular activities (Cultural, Sports, NSS, NCC etc. - please specify)', style: 'pdfContent', margin: [0, 10, 0, 10] },

                                    { text: 'Category II-A(iii) - Extension and dissemination activities (public / popular lectures / talks / seminars etc)', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Discipline Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody
                                        }
                                    },
                                    { text: 'Category : II-B - Contribution to Corporate life and management of the department and institution through participation in academic and administrative committees and responsibilities.', style: 'pdfContent', margin: [0, 10, 0, 10] },

                                    { text: 'Category II-B(i) - Administrative responsibility (including as Dean/ Principal/ Chairperson /Convener/ Teache-in-charge/ similar other duties that require regular office hrs of its discharge), please specify', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category II- B(ii) - Participation in Board of Studies, Academic and Administrative Committees', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category II-B(iii) - Others', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : II-B Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat2
                                        }
                                    },

                                    { text: 'Category : II-C - Professional Development activities (such as participation in seminars, conferences, short term,training courses,industrial experience, talks, lectures in refresher/ faculty development courses, dissemination and general articles and any other Contribution) please specify', style: 'pdfContent' },
                                    { text: 'Category : II-C Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat2_c
                                        }
                                    },
                                    { text: '', margin: [0, 10, 0, 10] },
                                    {
                                        canvas: [
                                            { type: 'line', x1: 0, y1: 0, x2: 520, y2: 0, lineWidth: 1, lineColor: '#000' }
                                        ]
                                    },
                                    { text: 'CATEGORY : III - Research and academic contributions', style: 'subheader' },
                                    { text: 'Category : III-A - Research Papers Publication in', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-A(a) - Refereed Journals as notified by the UGC / Cases published in Harvard Business Publishing or IVEY Publishing', margin: [0, 10, 0, 10] },

                                    { text: 'Category III-A(b) - Other Reputed Journals as notified by the UGC / cases published by reputed publisher such as ECCH / registered moot cases', style: 'pdfContent', margin: [0, 10, 0, 10] },

                                    { text: 'Category : III-B - Publications other than journal articles (books, chapters in books)', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-B(a) - Text/ Reference, Books published by International Publishers, with ISBN / ISSN number as approved by the University and posted on its website. The list will be intimated to UGC.', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-B(b) - Subject Books, published by National level publishers, with ISBN/ISSN number or State/Central Govt. Publications as approved by the University and posted on its website. The List will be intimated to UGC.', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-B(c) - Subject Books, published by National level publishers, with ISBN/ISSN number or State/Central Govt. Publications as approved by the University and posted on its website. The List will be intimated to UGC.', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-B(d) - Chapters in Books, published by National and International level publishers, with ISBN/ISSN number as approved by the University and posted on its website. The list will be intimated to UGC.', style: 'pdfContent', margin: [0, 10, 0, 10] },

                                    { text: 'Category : III-A,B Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_a
                                        }
                                    },

                                    { text: 'Category : III-C(i) - Research Projects', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-C(i-a) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-C(i-b) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-C(i-c) - Sponsored Major project with grants above Rs. 30 lakhs ( For Faculty of Technology and Engineering, Science, Architecture Planning)/ Major Projects with grants above Rs 5 lakhs (For Faculty of Law, Commerce, Management and Management & Humanities)', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III-C(ii) - Consultancy Projects/ Testing/Training', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : III-c Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_b
                                        }
                                    },
                                    { text: 'Category III-C(iii) - Projects Outcome/Outputs', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : III-c(iii) Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_c
                                        }
                                    },

                                    { text: 'Category III-D - Research Guidance: PhD. programme', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : III-D Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_d
                                        }
                                    },


                                    { text: 'Category III-E - Fellowships, Awards and Invited lectures delivered in conferences/seminars', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category III- E(i) - Fellowships / Awards', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : III-E(i) Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_e
                                        }
                                    },
                                    { text: 'Category III-E(ii) -Invited Lectures / papers', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : III-E(ii) Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_e_2
                                        }
                                    },

                                    { text: 'Category III-F - Development of e-learning delivery process / material', style: 'pdfContent', margin: [0, 10, 0, 10] },
                                    { text: 'Category : III-F Data:', style: 'subheader' },
                                    {
                                        table: {
                                            headerRows: 1,
                                            widths: ['auto', 'auto', 'auto', 'auto'],
                                            body: tableBody_cat3_f
                                        }
                                    },
                                ],
                                styles: {
                                    header: {
                                        fontSize: 18,
                                        bold: true,
                                        margin: [0, 0, 0, 20]
                                    },
                                    subheader: {
                                        fontSize: 14,
                                        bold: true,
                                        margin: [0, 10, 0, 10]
                                    },
                                    pdfContent: {
                                        margin: [0, 0, 0, 10]
                                    },
                                    tableHeader: {
                                        bold: true,
                                        fontSize: 12,
                                        lineHeight: 1.5,
                                        color: 'white',
                                        fillColor: '#21c8de'
                                    }
                                }

                            };
                            // console.log(docDefinition);
                            pdfMake.createPdf(docDefinition).open();
                        }, 500);
                        // pdfMake.createPdf(docDefinition).open();
                    });
                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    </div>
    <br><br>
    <div>

    </div>
</body>

</html>