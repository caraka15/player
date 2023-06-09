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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['link'])) {
        $link = mysqli_real_escape_string($db, $_POST['link']);

        // Mengirim permintaan ke API Doodapi untuk melakukan remote upload
        $apiKey = "238952rybn28vbb6uqxpyz";
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
    } elseif (isset($_POST['link1'])) {
        // Mengimpor koneksi database
        require_once('db.php');

        // Mendapatkan judul dan link video dari form
        $link1 = $_POST['link1'];

        // Menjalankan operasi SQL INSERT
        $sql = "INSERT INTO link (link) VALUES ('$link1')";

        if ($conn->query($sql) === TRUE) {
            echo "Video berhasil ditambahkan ke database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Menutup koneksi database
        $conn->close();
    } elseif (isset($_POST['folder_link'])) {
        $folderLink = mysqli_real_escape_string($db, $_POST['folder_link']);
        $folderId = substr($folderLink, strrpos($folderLink, '/') + 1);
    
        // Mengirim permintaan ke API Doodapi untuk mendapatkan daftar file dalam folder
        $apiKey = "238952rybn28vbb6uqxpyz";
        $apiUrl = "https://doodapi.com/api/file/list?key={$apiKey}&fld_id=" . urlencode($folderId);
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
    
        // Memeriksa respon dari API Doodapi
        if ($data && isset($data['result']) && isset($data['result']['files'])) {
            $files = $data['result']['files'];
    
            foreach ($files as $file) {
                $newUrl = $file['download_url'];
    
                // Mengirim permintaan ke API Doodapi untuk melakukan remote upload
                $uploadUrl = "https://doodapi.com/api/upload/url?key={$apiKey}&url=" . urlencode($newUrl);
                $uploadResponse = file_get_contents($uploadUrl);
                $uploadData = json_decode($uploadResponse, true);
    
                // Memeriksa respon dari API Doodapi
                if ($uploadData && isset($uploadData['result']['download_url'])) {
                    $uploadedDownloadUrl = $uploadData['result']['download_url'];
    
                    // Memasukkan link baru ke dalam database
                    $sql = "INSERT INTO link (link) VALUES ('$uploadedDownloadUrl')";
                    if (mysqli_query($db, $sql)) {
                        echo "Link berhasil ditambahkan ke database.";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($db);
                    }
                } else {
                    echo "Proses remote upload gagal.";
                }
            }
        } else {
            echo "Proses mendapatkan daftar file gagal.";
        }
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

    <form method="POST" action="admin_login.php">
        <input type="text" name="link1" placeholder="Masukkan Link Video" required>
        <button type="submit">UPLOAD</button>
    </form>

    <form method="POST" action="admin_login.php">
        <input type="text" name="folder_link" placeholder="Masukkan Link Folder Doodstream" required>
        <button type="submit">Upload dari Folder</button>
    </form>

    <a href="edit.php">Edit Video</a>
</body>

</html>