<?php
session_start();

$db = mysqli_connect("localhost", "root", "caraka1717", "video");

if (!$db) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = mysqli_real_escape_string($db, $_POST['user']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $stmt = mysqli_prepare($db, "SELECT user, password FROM admin WHERE user = ?");
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user, $hashed_password);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user'] = $user;
        header('Location: admin_login.php');
        exit();
    } else {
        $login_error = "Password salah";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($db);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style1.css">
    <title>Admin Login</title>

</head>

<body>
    <h1>Admin Login</h1>

    <div class="subscribe-container">
        <?php if (isset($login_error)) { ?>
        <p><?php echo $login_error; ?></p>
        <?php } ?>

        <div class="subscribe">
            <p>ACCESS CODE</p>
            <form method="POST" action="admin.php">
                <div class="input-group">
                    <input type="text" name="user" class="subscribe-input" placeholder="Username" required>
                    <input type="password" name="password" class="subscribe-input" placeholder="Password" required>
                    <button type="submit" class="submit-btn">Login</button>
                </div>
            </form>
        </div>


</body>

</html>