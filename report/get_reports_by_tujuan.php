<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include __DIR__ . '/../config/database.php';

$tujuan = $_GET['tujuan'] ?? 'polisi';

$sql = "
SELECT 
r.id,
r.kategori,
r.deskripsi,
r.alamat,
r.latitude,
r.longitude,
r.created_at,
COALESCE(r.operator_confirm, 'diproses') as operator_confirm,
u.nama,
u.no_hp
FROM reports r
JOIN users u ON r.user_id = u.id
WHERE r.tujuan = ?
ORDER BY r.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $tujuan);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>