<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: admin.php');
    exit();
}

$db = mysqli_connect("localhost", "root", "caraka1717", "video");

if (!$db) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['link'])) {
    $link = mysqli_real_escape_string($db, $_POST['link']);

    // Mengirim permintaan ke API Doodapi untuk melakukan remote upload
    $apiKey = "238952a5hhtdv0iazrlcf3";
    $apiUrl = "https://doodapi.com/api/upload/url?key={$apiKey}&url=" . urlencode($link);
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Memeriksa respon dari API Doodapi
    if ($data && isset($data['result']['download_url'])) {
        $downloadUrl = $data['result']['download_url'];

        // Memasukkan link baru ke dalam database
        $sql = "INSERT INTO link (link) VALUES ('$downloadUrl')";
        if (mysqli_query($db, $sql)) {
            echo "Link berhasil ditambahkan ke database.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    } else {
        echo "Proses remote upload gagal.";
    }
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
</head>

<body>
    <h1>Admin Login</h1>

    <form method="POST" action="admin_login.php">
        <input type="text" name="link" placeholder="Masukkan Link Video" required>
        <button type="submit">Reupload</button>
    </form>

    <a href="edit.php">Edit Video</a>
</body>

</html>