<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

include __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents("php://input"), true) ?? [];

$user_id = $data['user_id'] ?? null;
$kategori = $data['kategori'] ?? '';
$deskripsi = $data['deskripsi'] ?? '';
$alamat = $data['alamat'] ?? '';
$latitude = $data['latitude'] ?? '';
$longitude = $data['longitude'] ?? '';

if (!$user_id || !$kategori || !$deskripsi) {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap",
        "debug" => $data
    ]);
    exit;
}

$user_id = intval($user_id);
$kategori = mysqli_real_escape_string($conn, $kategori);
$deskripsi = mysqli_real_escape_string($conn, $deskripsi);
$alamat = mysqli_real_escape_string($conn, $alamat);
$latitude = mysqli_real_escape_string($conn, $latitude);
$longitude = mysqli_real_escape_string($conn, $longitude);

/* INSERT */
$query = mysqli_query($conn,
    "INSERT INTO reports 
    (user_id, kategori, deskripsi, alamat, latitude, longitude)
    VALUES 
    ('$user_id', '$kategori', '$deskripsi', '$alamat', '$latitude', '$longitude')"
);

if ($query) {
    echo json_encode([
        "success" => true,
        "message" => "Laporan berhasil dikirim"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Gagal insert",
        "error" => mysqli_error($conn)
    ]);
}
?>