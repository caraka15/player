<?php
function getVideoDownloadLink($url) {
    $headers = array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    // Cari tautan unduhan
    preg_match('/<video[^>]*src=[\'"]([^\'"]+)[\'"][^>]*>/', $response, $matches);
    if (isset($matches[1])) {
        return $matches[1];
    }

    return null;
}

if (isset($_POST['tiktok-url'])) {
    $tiktokUrl = $_POST['tiktok-url'];

    // Validasi URL TikTok
    if (filter_var($tiktokUrl, FILTER_VALIDATE_URL)) {
        // Dapatkan tautan unduhan video
        $downloadLink = getVideoDownloadLink($tiktokUrl);

        if ($downloadLink) {
            // Tampilkan tautan unduhan
            echo 'Download Link: <a href="' . $downloadLink . '">Download</a>';
        } else {
            echo 'Video tidak dapat ditemukan atau tautan unduhan tidak tersedia.';
        }
    } else {
        echo 'URL TikTok tidak valid.';
    }
}
?>

<html>

<head>
    <title>TikTok Downloader</title>
</head>

<body>
    <form action="" method="post">
        <input type="text" name="tiktok-url" placeholder="Masukkan URL TikTok" required>
        <button type="submit">Download</button>
    </form>
</body>

</html>