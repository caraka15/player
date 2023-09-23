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


        // Memastikan bahwa link dimulai dengan "https://"
        if (!preg_match("~^https://~i", $link)) {
            $link = "https://" . $link;
        }

        // Buat URL API
        $apiUrl = "https://doodapi.com/api/upload/url?key=238952a5hhtdv0iazrlcf3&url={$link}";

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

        if ($data && isset($data['result']['status']) && $data['result']['status'] === 200) {
            echo "Status: 200 (Sukses)";
        } else {
            echo "Proses upload gagal.";
        }
    }
    ?>
</body>

</html>