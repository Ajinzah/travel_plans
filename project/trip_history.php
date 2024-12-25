<?php
// Mulai sesi untuk cek login
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit();
}

// Koneksi ke database
include('db.php');  // Pastikan Anda telah menghubungkan ke database

// Ambil data perjalanan yang telah dibuat oleh pengguna yang sedang login
$user_id = $_SESSION['user_id'];  // ID pengguna yang login
$sql = "SELECT * FROM trips WHERE user_id = ?";  // Query untuk mengambil data perjalanan
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Bind parameter user_id
$stmt->execute();
$result = $stmt->get_result();  // Ambil hasil query
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perjalanan</title>
    <link rel="stylesheet" href="css/history-style.css">  <!-- Link ke file CSS -->
</head>
<body>
    <!-- Header -->
    <header>
        <h1 style="text-align: center; padding: 20px 0;">Rencana Perjalanan</h1>
    </header>

    <!-- Sidebar Menu -->
    <nav class="sidebar">
        <h2><?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <ul>
           <a href="index.php">Beranda</a>
            <a href="add_trip.php">Tambah Perjalanan</a>
            <a href="trip_history.php">Riwayat Perjalanan</a>
            <a href="logout.php">Logout</a>
        </ul>
    </nav>

    <!-- Konten Halaman -->
    <div class="main-content">
        <h2>Riwayat Perjalanan</h2>

        <!-- Tabel Daftar Perjalanan -->
        <table>
            <thead>
                <tr>
                    <th>Nama Perjalanan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Anggaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($trip = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($trip['trip_name']); ?></td>
                        <td><?php echo htmlspecialchars($trip['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($trip['end_date']); ?></td>
                        <td>Rp <?php echo number_format($trip['budget'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="edit_trip.php?trip_id=<?php echo $trip['trip_id']; ?>">Edit</a> |
                            <a href="delete_trip.php?trip_id=<?php echo $trip['trip_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus rencana ini?');">Hapus</a>
                            <a href="export_excel.php" class="btn btn-success">Export ke Excel</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
