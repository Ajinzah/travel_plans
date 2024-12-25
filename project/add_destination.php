<?php
include '../db.php';

$trip_id = $_GET['trip_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destinasi_name = $_POST['destinasi_name'];
    $activity = $_POST['activity'];
    $cost = $_POST['cost'];

    $query = $pdo->prepare("INSERT INTO destinasi (trip_id, destinasi_name, activity, cost) VALUES (?, ?, ?, ?)");
    $query->execute([$trip_id, $destinasi_name, $activity, $cost]);

    header("Location: trip_detail.php?trip_id=" . $trip_id);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Destinasi</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Tambah Destinasi Baru</h1>
    <form action="" method="POST">
        <label>Nama Destinasi:</label>
        <input type="text" name="destinasi_name" required>
        <label>Aktivitas:</label>
        <input type="text" name="activity" required>
        <label>Biaya:</label>
        <input type="number" name="cost" required>
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
