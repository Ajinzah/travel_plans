<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Pastikan jalur ke file db.php benar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Perjalanan</title>
    <link rel="stylesheet" href="css/add_style.css">
</head>
<body>
    <header>
        <h1>Rencana Perjalanan</h1>
    </header>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2><?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <ul>
                <a href="index.php">Beranda</a>
                <a href="add_trip.php">Tambah Perjalanan</a>
                <a href="trip_history.php">Riwayat Perjalanan</a>
                <a href="logout.php">Logout</a>
            </ul>
        </div>

        <!-- Konten Utama -->
        <main>
            <h2>Tambah Perjalanan Baru</h2>
            <form action="process_add_trip.php" method="POST">
                <label for="trip_name">Nama Perjalanan:</label>
                <input type="text" id="trip_name" name="trip_name" required>
                
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date" required>
                
                <label for="end_date">Tanggal Selesai:</label>
                <input type="date" id="end_date" name="end_date" required>
                
                <label for="budget">Anggaran:</label>
                <input type="number" id="budget" name="budget" required>
                
                <button type="submit">Tambah Perjalanan</button>
            </form>
        </main>
    </div>
</body>
</html>
