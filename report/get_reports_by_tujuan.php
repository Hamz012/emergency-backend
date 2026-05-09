<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include __DIR__ . '/../config/database.php';

$tujuan = $_GET['tujuan'] ?? 'polisi';

/*
========================================
MAP TUJUAN -> KATEGORI DATABASE
========================================
*/
$map = [
    "polisi" => "kriminal",
    "ambulance" => "kecelakaan",
    "pemadam" => "kebakaran"
];

$kategori = $map[$tujuan] ?? null;

/*
JIKA KATEGORI TIDAK VALID
*/
if (!$kategori) {
    echo json_encode([]);
    exit;
}

/*
========================================
QUERY AMAN (FIX SQL ERROR)
========================================
*/
$sql = "
SELECT 
    r.id,
    r.kategori,
    r.deskripsi,
    r.alamat,
    r.latitude,
    r.longitude,
    r.created_at,
    u.nama,
    u.no_hp
FROM reports r
JOIN users u ON r.user_id = u.id
WHERE r.kategori = ?
ORDER BY r.created_at DESC
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $kategori);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>