<?php
// Memeriksa apakah ada metode POST yang digunakan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Memeriksa apakah kode akses yang dimasukkan sesuai dengan yang diharapkan
    $expectedAccessCode = "bocahprik"; // Ganti dengan kode akses yang diinginkan
    $accessCode = $_POST['access_code'];

    if ($accessCode === $expectedAccessCode) {
        // Kode akses yang dimasukkan benar, lanjutkan ke halaman video
        session_start();
        $_SESSION['user'] = true; // Menandai bahwa pengguna telah memasukkan kode akses yang benar

        // Redirect ke halaman video
        header('Location: index.php');
        exit();
    } else {
        // Kode akses yang dimasukkan salah, kembali ke halaman sebelumnya
        header('Location: index.php');
        exit();
    }
} else {
    // Jika metode HTTP bukan POST, kembali ke halaman sebelumnya
    header('Location: index.php');
    exit();
}
?>