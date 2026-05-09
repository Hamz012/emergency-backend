<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include __DIR__ . '/../config/database.php';

$tujuan = $_GET['tujuan'] ?? '';

$sql = "SELECT * FROM reports WHERE tujuan = '$tujuan' ORDER BY id DESC";

$query = mysqli_query($conn, $sql);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
?>