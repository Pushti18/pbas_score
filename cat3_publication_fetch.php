<?php
include("db_connect.php");
$sql = "SELECT title, academic_year, status, type, region, approval_status, action FROM publication";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['data' => $data]);

$conn->close();
?>