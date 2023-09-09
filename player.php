<!DOCTYPE html>
<html>

<head>
    <title>Video Player</title>
    <style>
    /* Gaya CSS untuk tampilan pemutar video */
    body {
        margin: 0;
        padding: 0;
    }

    .video-container {
        max-width: 640px;
        /* Lebar maksimum pemutar video */
        margin: 0 auto;
        /* Pusatkan pemutar video secara horizontal */
    }

    .video-container iframe {
        width: 100%;
        height: 360px;
        /* Tinggi pemutar video */
    }

    .video-title {
        text-align: center;
        padding: 10px;
    }
    </style>
</head>

<body>
    <?php
    // Memeriksa apakah parameter filecode ada di URL
    if (isset($_GET['file_code'])) {
        $fileCode = $_GET['file_code'];

        // Buat URL API Doodapi untuk mendapatkan informasi video
        $apiUrl = "https://doodapi.com/api/file/info?key=238952a5hhtdv0iazrlcf3&file_code=$fileCode";
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);

        // Memeriksa respon dari API Doodapi
        if ($data && isset($data['result'][0])) {
            $videoInfo = $data['result'][0];
            $judul = $videoInfo['title'];
            $videoUrl = "https://doods.pro/e/$fileCode";
    ?>
    <h2 class="video-title"><?php echo $judul; ?></h2>
    <div class="video-container">
        <iframe src="<?php echo $videoUrl; ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <?php
        } else {
            echo "Video tidak ditemukan.";
        }
    } else {
        echo "Video tidak ditemukan.";
    }
    ?>
</body>

</html>