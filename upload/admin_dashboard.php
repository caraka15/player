<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: admin.php');
    exit();
}

require_once('api/db.php');

// Fungsi untuk menghapus data chaind
function deleteChaind($chain_id) {
    global $conn;

    // Hapus data chaind dari database
    $query = "DELETE FROM chainds WHERE chain_id = '$chain_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Proses form delete chaind
if (isset($_POST['delete_chaind'])) {
    $chain_id = $_POST['chain_id'];

    if (deleteChaind($chain_id)) {
        echo "Data chaind berhasil dihapus.";
    } else {
        echo "Gagal menghapus data chaind.";
    }
}

// Query untuk mendapatkan daftar chaind
$query = "SELECT * FROM chainds";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Tampilan daftar chaind -->
    <h2>Daftar Chaind</h2>
    <table>
        <tr>
            <th>Chain ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Logo</th>
            <th>RPC Link</th>
            <th>API Link</th>
            <th>gRPC Link</th>
            <th>Guide Link</th>
            <th>Stake Link</th>
            <th>Snapshot Link</th>
            <th>Statesync Link</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['chain_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['logo']; ?></td>
                <td><?php echo $row['rpc_link']; ?></td>
                <td><?php echo $row['api_link']; ?></td>
                <td><?php echo $row['grpc_link']; ?></td>
                <td><?php echo $row['guide_link']; ?></td>
                <td><?php echo $row['stake_link']; ?></td>
                <td><?php echo $row['snapshot_link']; ?></td>
                <td><?php echo $row['statesync_link']; ?></td>
                <td>
                    <form method="POST" action="delete_chaind.php">
                        <input type="hidden" name="chain_id" value="<?php echo $row['chain_id']; ?>">
                        <button type="submit" name="delete_chaind">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Form edit chaind -->
<h2>Edit Chaind</h2>
<form method="POST" action="edit_chaind.php">
    <input type="text" name="chain_id" placeholder="Chain ID" required>
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="type" placeholder="Type" required>
    <input type="text" name="logo" placeholder="Logo" required>
    <input type="text" name="rpc_link" placeholder="RPC Link" required>
    <input type="text" name="api_link" placeholder="API Link" required>
    <input type="text" name="grpc_link" placeholder="gRPC Link" required>
    <input type="text" name="guide_link" placeholder="Guide Link" required>
    <input type="text" name="stake_link" placeholder="Stake Link" required>
    <input type="text" name="snapshot_link" placeholder="Snapshot Link" required>
    <input type="text" name="statesync_link" placeholder="Statesync Link" required>
    <button type="submit" name="edit_chaind">Edit Chaind</button>
</form>

<!-- Form add chaind -->
<form method="POST" action="add_chaind.php">
    <input type="text" name="chain_id" placeholder="Chain ID" required>
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="type" placeholder="Type" required>
    <input type="text" name="logo" placeholder="Logo" required>
    <input type="text" name="rpc_link" placeholder="RPC Link" required>
    <input type="text" name="api_link" placeholder="API Link" required>
    <input type="text" name="grpc_link" placeholder="gRPC Link" required>
    <input type="text" name="guide_link" placeholder="Guide Link" required>
    <input type="text" name="stake_link" placeholder="Stake Link" required>
    <input type="text" name="snapshot_link" placeholder="Snapshot Link" required>
    <input type="text" name="statesync_link" placeholder="Statesync Link" required>
    <button type="submit">Add Chaind</button>
</form>


</body>
</html>
