<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $region = $_POST['region'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $role = $_POST['role'];
    $publication_group = $_POST['publication_group'];
    $journalTitle = $_POST['journalTitle'];
    $coAuthor = $_POST['coAuthor'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $publisher = $_POST['publisher'];
    $pubDate = $_POST['pubDate'];
    $volume = $_POST['volume'];
    $page = $_POST['page'];
    $frontImage = $_POST['frontImage'];
    $current_status_of_work = $_POST['current_status_of_work'];
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
    $employee_id = $_POST['employee_id'];
    global $conn;
    $pbasScore = 0;

    // ... Your existing code for calculating pbasScore ...

    $fetchCategoryIdSql = "SELECT category_id FROM cat3 WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $fetchCategoryIdSql);

    if ($row = mysqli_fetch_assoc($result)) {
        $category_id = $row['category_id'];
        $sql = "INSERT INTO publication (cat3_id, employee_id, region, type, title, author, role, publication_group, 
                journal_title, co_author, month_of_publication, year_of_publication, publisher, publication_date, 
                volume_no, page_no, publication_front_image, current_status_of_work, pbas_score) 
                VALUES ('$category_id', '$employee_id','$region', '$type', '$title', '$author', '$role', '$publication_group', 
                '$journalTitle', '$coAuthor', '$month', '$year', '$publisher', '$pubDate', '$volume', '$page', '$frontImage', '$current_status_of_work', '$pbasScore')";

        mysqli_query($conn, $sql);

        if (mysqli_error($conn)) {
            echo json_encode(['error' => "Error: " . mysqli_error($conn)]);
        } else {
            // After insertion, fetch the details
            $fetchDetailsSql = "SELECT * FROM publication WHERE employee_id = '$employee_id' AND title = '$title'";
            $detailsResult = mysqli_query($conn, $fetchDetailsSql);

            if ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                $publication_details = [
                    'title' => $detailsRow['title'],
                    'academic_year' => $detailsRow['academic_year'], // replace with the actual academic year column
                    'status' => $detailsRow['status'], // replace with the actual status column
                    'type' => $detailsRow['type'],
                    'region' => $detailsRow['region'],
                    'approval_status' => $detailsRow['approval_status'], // replace with the actual approval status column
                    'pbas_score' => $detailsRow['pbas_score']
                ];

                echo json_encode($publication_details);
            } else {
                echo json_encode(['error' => "Details not found."]);
            }
        }
    } else {
        echo "Category ID not found.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>