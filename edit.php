<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: admin.php');
    exit();
}
// Mengimpor koneksi database
require_once('db.php');

// Mengimpor fungsi untuk mengambil judul video dari API Doodapi
function getVideoTitle($videoId) {
    $apiKey = "238952rybn28vbb6uqxpyz";
    $apiUrl = "https://doodapi.com/api/file/image?key={$apiKey}&file_code=" . urlencode($videoId);
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Memeriksa respon dari API Doodapi
    if ($data && isset($data['result'][0]['title'])) {
        return $data['result'][0]['title'];
    }

    return "Judul tidak tersedia";
}

// Menghapus video jika ada parameter 'action' dengan nilai 'delete' yang diberikan melalui URL
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Menghapus video dari database
        $sql = "DELETE FROM link WHERE id = '$id'";
        if ($conn->query($sql) === TRUE) {
            echo "Video berhasil dihapus dari database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Mengambil semua video dari database
$sql = "SELECT * FROM link";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Video</title>
</head>

<body>
    <h1>Daftar Video</h1>

    <?php
    // Menampilkan daftar video
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $link = $row['link'];

            // Mengambil video ID dari link video
            $videoId = substr($link, strrpos($link, '/') + 1);

            // Mengambil judul video dari API Doodapi
            $judul = getVideoTitle($videoId);

            // Menampilkan judul video, link video, dan tombol hapus video
            echo "<p>Judul: $judul</p>";
            echo "<button onclick=\"window.location.href='edit.php?action=delete&id=$id'\">Hapus Video</button>";
        }
    } else {
        echo "Tidak ada video yang tersedia.";
    }
    ?>

    <!-- Link kembali ke halaman admin_login.php -->
    <a href="admin_login.php">Kembali</a>
</body>

</html>

<?php
// Menutup koneksi database
$conn->close();
?>