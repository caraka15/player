<?php
// Konfigurasi database
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'caraka1717';
$dbName = 'video';

// Membuat koneksi database
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
