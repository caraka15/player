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
            max-width: 640px; /* Lebar maksimum pemutar video */
            margin: 0 auto; /* Pusatkan pemutar video secara horizontal */
        }
        
        .video-container iframe {
            width: 100%;
            height: 360px; /* Tinggi pemutar video */
        }
        
        .video-title {
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <?php
    // Memeriksa apakah parameter url dan judul ada di URL
    if (isset($_POST['url']) && isset($_POST['judul'])) {
        $videoUrl = $_POST['url'];
        $judul = $_POST['judul'];
    ?>
        <h2 class="video-title"><?php echo $judul; ?></h2>
        <div class="video-container">
            <iframe src="<?php echo $videoUrl; ?>" frameborder="0" allowfullscreen></iframe>
        </div>
    <?php
    } else {
        echo "Video tidak ditemukan.";
    }
    ?>
</body>
</html>
