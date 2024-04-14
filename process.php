<?php
session_start();
include ("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST['year'];
    $target = $_POST['target'];
    // $employeeId = 1;
    $employeeId = $_SESSION['employee_id'];

    // Check if a record already exists for the academic year and employee ID combination
    $sql_check = "SELECT COUNT(*) AS count FROM pbas_score WHERE year = ? AND employee_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("si", $year, $employeeId);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();
    $existing_records_count = $row_check['count'];
    $stmt_check->close();

    if ($existing_records_count == 0) {
        // No record exists for the academic year and employee ID combination, so insert new record
        if (!empty($year) && !empty($target)) {
            $sql = "INSERT INTO pbas_score (year, target, employee_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $year, $target, $employeeId);

            if ($stmt->execute()) {
                // Set session or any other logic here if needed
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Invalid data submitted!";
        }
    } else {
        // Redirect back to the same page with a status indicating record already exists
        header("Location: dashboard.php?status=exists");
        exit();
    }
} else {
    // Handle cases where the request method is not POST
}

$conn->close();
?>