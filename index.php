<?php
session_start();

$db = mysqli_connect("localhost", "root", "caraka1717", "video");

if (!$db) {
die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$access_code = mysqli_real_escape_string($db, $_POST['access_code']);

$stmt = mysqli_prepare($db, "SELECT access_code FROM code WHERE access_code = ?");
mysqli_stmt_bind_param($stmt, "s", $access_code);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $access_code_result);
mysqli_stmt_fetch($stmt);

if ($access_code === $access_code_result) {
$_SESSION['access_code'] = $access_code;
header('Location: list.php');
exit();
} else {
$login_error = "Kode akses salah";
}

mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="style1.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN COK</title>
</head>

<body>
    <?php include 'src/header.php'; ?>

    <div class="subscribe-container">
        <?php if (isset($login_error)) { ?>
        <p><?php echo $login_error; ?></p>
        <?php } ?>

        <div class="subscribe">
            <p>ACCESS CODE</p>
            <form method="POST" action="index.php">
                <input placeholder="Your Access Code" class="subscribe-input" name="access_code" type="text">
                <br>
                <button type="submit" class="submit-btn">SUBMIT</button>
            </form>
        </div>
    </div>

</body>

</html>