<?php
session_start();
include("db_connection.php");

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
    $attachment = $_FILES['attachment']['name'];
    $current_status_of_work = $_POST['current_status_of_work'];
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
    $employee_id = $_POST['employee_id'];
    global $conn;
    $pbasScore = 0;
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = true;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        // File uploaded successfully

    $fetchCategoryIdSql = "SELECT category_id FROM cat3 WHERE category_id = '$category_id'";
    $result = mysqli_query($conn, $fetchCategoryIdSql);

    if ($row = mysqli_fetch_assoc($result)) {
        $category_id = $row['category_id'];
        $sql = "INSERT INTO publication (cat3_id, employee_id, region, type, title, author, role, publication_group, 
                journal_title, co_author, month_of_publication, year_of_publication, publisher, publication_date, 
                volume_no, page_no, attachment, current_status_of_work, pbas_score) 
                VALUES ('$category_id', '$employee_id','$region', '$type', '$title', '$author', '$role', '$publication_group', 
                '$journalTitle', '$coAuthor', '$month', '$year', '$publisher', '$pubDate', '$volume', '$page', '$attachment', '$current_status_of_work', '$pbasScore')";

        if (mysqli_query($conn, $sql)) {
            $fetchDetailsSql = "SELECT * FROM publication WHERE employee_id = '$employee_id' AND title = '$title'";
            $detailsResult = mysqli_query($conn, $fetchDetailsSql);

            if ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                $publication_details = [
                    'title' => $detailsRow['title'],
                    'academic_year' => $detailsRow['academic_year'],
                    'status' => $detailsRow['status'],
                    'type' => $detailsRow['type'],
                    'region' => $detailsRow['region'],
                    'approval_status' => $detailsRow['approval_status'],
                    'pbas_score' => $detailsRow['pbas_score']
                ];

                echo json_encode($publication_details);
            } else {
                echo json_encode(['error' => "Details not found."]);
            }
        } else {
            echo json_encode(['error' => "Error: " . mysqli_error($conn)]);
        }
    } else {
        echo "Category ID not found.";
    }

} else {
    echo "Sorry, there was an error uploading your file.";
}

mysqli_close($conn);
} else {
echo "Invalid request method.";
}
?>