<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

// Ambil data perjalanan berdasarkan trip_id
if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
    $sql = "SELECT * FROM trips WHERE trip_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $trip_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $trip = $result->fetch_assoc();

    if (!$trip) {
        echo "Perjalanan tidak ditemukan.";
        exit();
    }
} else {
    header('Location: trip_history.php');
    exit();
}

// Proses update perjalanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_name = $_POST['trip_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $budget = $_POST['budget'];

    $sql = "UPDATE trips SET trip_name = ?, start_date = ?, end_date = ?, budget = ? WHERE trip_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiii", $trip_name, $start_date, $end_date, $budget, $trip_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        header('Location: trip_history.php');
        exit();
    } else {
        echo "Gagal mengupdate perjalanan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Perjalanan</title>
    <link rel="stylesheet" href="css/edit-style.css">
</head>
<body>
    <header>
        <h1>Edit Perjalanan</h1>
    </header>
    <nav class="sidebar">
        <h2><?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <ul>
            <li><a href="index.php">Beranda</a></li>
            <li><a href="add_trip.php">Tambah Perjalanan</a></li>
            <li><a href="trip_history.php">Riwayat Perjalanan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <h2>Edit Rencana Perjalanan</h2>
        <form method="POST">
            <label>Nama Perjalanan:</label>
            <input type="text" name="trip_name" value="<?php echo htmlspecialchars($trip['trip_name']); ?>" required>
            <label>Tanggal Mulai:</label>
            <input type="date" name="start_date" value="<?php echo $trip['start_date']; ?>" required>
            <label>Tanggal Selesai:</label>
            <input type="date" name="end_date" value="<?php echo $trip['end_date']; ?>" required>
            <label>Anggaran:</label>
            <input type="number" name="budget" value="<?php echo $trip['budget']; ?>" required>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
