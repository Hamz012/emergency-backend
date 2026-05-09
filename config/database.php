<?php
header("Content-Type: application/json");

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT") ?: 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die(json_encode([
        "success" => false,
        "message" => "DB gagal konek",
        "error" => mysqli_connect_error()
    ]));
}
?>