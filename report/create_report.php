<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include __DIR__ . '/../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'] ?? null;
$kategori = $data['kategori'] ?? '';
$deskripsi = $data['deskripsi'] ?? '';
$alamat = $data['alamat'] ?? '';
$latitude = $data['latitude'] ?? '';
$longitude = $data['longitude'] ?? '';

// mapping penting ini
$tujuan = "";

if ($kategori == "kecelakaan") {
    $tujuan = "ambulance";
} elseif ($kategori == "kebakaran") {
    $tujuan = "pemadam";
} elseif ($kategori == "kriminal") {
    $tujuan = "polisi";
}

if (!$user_id || !$kategori) {
    echo json_encode([
        "success" => false,
        "message" => "Data tidak lengkap"
    ]);
    exit;
}

$sql = "INSERT INTO reports 
(user_id, kategori, deskripsi, alamat, latitude, longitude, tujuan)
VALUES 
('$user_id', '$kategori', '$deskripsi', '$alamat', '$latitude', '$longitude', '$tujuan')";

$query = mysqli_query($conn, $sql);

if ($query) {
    echo json_encode([
        "success" => true,
        "message" => "Laporan berhasil dikirim"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);
}
?>