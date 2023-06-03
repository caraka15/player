<?php
// Mengimpor koneksi database
require_once('db.php');

// Mendapatkan judul dan link video dari form
$link1 = $_POST['link1'];

// Menjalankan operasi SQL INSERT
$sql = "INSERT INTO link (link) VALUES ('$link1')";

if ($conn->query($sql) === TRUE) {
    echo "Video berhasil ditambahkan ke database.";
    // Mengarahkan pengguna kembali ke halaman admin_login.php
    header('Location: admin_login.php');
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi database
$conn->close();
?>