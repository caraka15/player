<?php
session_start();

if (!isset($_SESSION['access_code'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Video List Bocah Prik</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <h1>Video List Bocah Prik</h1>
    <div id="blur-container">
        <div class="video-container">
            <?php
            // Mengimpor koneksi database
            require_once('db.php');

            // Memeriksa koneksi database
            if ($conn->connect_error) {
                die("Koneksi database gagal: " . $conn->connect_error);
            }

            // Mendapatkan data video dari tabel link
            $sql = "SELECT * FROM link ORDER BY timestamp_column DESC";
            $result = $conn->query($sql);

            // Memeriksa apakah ada video yang ditemukan
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Mendapatkan link video
                    $videoLink = $row['link'];

                    // Mendapatkan video ID dari link video
                    $videoId = substr($videoLink, strrpos($videoLink, '/') + 1);
                    $videoUrl = "https://doodstream.com/e/{$videoId}";

                    // Mengirim permintaan ke API Doodapi untuk mendapatkan thumbnail dan judul
                    $apiUrl = "https://doodapi.com/api/file/image?key=238952rybn28vbb6uqxpyz&file_code=" . urlencode($videoId);
                    $response = file_get_contents($apiUrl);
                    $data = json_decode($response, true);

                    // Memeriksa respon dari API Doodapi
                    if ($data && isset($data['result'][0]['splash_img'])) {
                        $thumbnail = $data['result'][0]['splash_img'];
                    } else {
                        $thumbnail = $data['result'][0]['single_img'];
                    }
                    $judul = $data['result'][0]['title'];
            ?>
            <div class="video-card">
                <div class="thumbnail-container">
                    <div class="thumbnail-wrapper">
                        <form action="player.php" method="post" target="_blank">
                            <input type="hidden" name="url" value="<?php echo $videoUrl; ?>">
                            <input type="hidden" name="judul" value="<?php echo $judul; ?>">
                            <img src="<?php echo $thumbnail; ?>" alt="Thumbnail" class="thumbnail">
                        </form>
                    </div>
                </div>
                <h2 class="title">
                    <form action="player.php" method="post" target="_blank">
                        <input type="hidden" name="url" value="<?php echo $videoUrl; ?>">
                        <input type="hidden" name="judul" value="<?php echo $judul; ?>">
                        <button type="submit" class="title-btn"><?php echo $judul; ?></button>
                    </form>
                </h2>
            </div>
            <?php
                }
            } else {
                echo "Tidak ada video yang ditemukan.";
            }

            // Menutup koneksi database
            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>