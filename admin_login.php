<!DOCTYPE html>
<html>

<head>
    <title>Upload Video</title>
</head>

<body>
    <h1>Upload Video</h1>

    <form method="POST">
        <input type="text" name="link" placeholder="Masukkan Link Video" required>
        <button type="submit">Upload</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['link'])) {
        $link = $_POST['link'];

        // Ganti dengan API key Anda
        $apiKey = "your_api_key";

        // Memastikan bahwa link dimulai dengan "https://"
        if (!preg_match("~^(?:f|ht)tps?://~i", $link)) {
            $link = "https://" . $link;
        }

        // Buat URL API
        $apiUrl = "https://doodapi.com/api/upload/url?key={$apiKey}&url=" . urlencode($link);

        // Inisialisasi cURL session
        $ch = curl_init($apiUrl);

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Eksekusi permintaan cURL
        $response = curl_exec($ch);

        // Tutup sesi cURL
        curl_close($ch);

        // Memeriksa respon dari API Doodapi
        $data = json_decode($response, true);

        if ($data && isset($data['status']) && $data['status'] === 200) {
            echo "Status: 200 (Sukses)";
        } else {
            echo "Proses upload gagal.";
        }
    }
    ?>
</body>

</html>