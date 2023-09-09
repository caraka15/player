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
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <?php include 'src/header.php'; ?>


    <h1>Video List Bocah Prik</h1>
    <div id="blur-container">
        <div class="video-container">
            <?php
            // Mendapatkan data video dari API Doodapi
            $apiUrl = "https://doodapi.com/api/file/list?key=238952a5hhtdv0iazrlcf3";
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            // Memeriksa respon dari API Doodapi
            if ($data && isset($data['result']) && isset($data['result']['files'])) {
                $videos = $data['result']['files'];
                foreach ($videos as $video) {
                    $fileCode = $video['file_code']; // Ambil file_code dari data video
                    $videoUrl = str_replace("/d/", "/e/", $video['download_url']); // Mengganti d dengan e pada URL
                    $judul = $video['title'];
                    $thumbnail = $video['single_img'];
            
            ?>
            <div class="video-card">
                <div class="thumbnail-container">
                    <div class="thumbnail-wrapper">
                        <a href="player.php?file_code=<?php echo $fileCode; ?>" target="_blank">
                            <img src="<?php echo $thumbnail; ?>" alt="Thumbnail" class="thumbnail">
                        </a>
                    </div>
                </div>
                <h2 class="title">
                    <a href="player.php?file_code=<?php echo $fileCode; ?>" target="_blank"
                        class="button-like"><?php echo $judul; ?></a>
                </h2>
            </div>
            <?php
                }
            } else {
                echo "Tidak ada video yang ditemukan.";
            }
            ?>
        </div>
    </div>
</body>

</html>