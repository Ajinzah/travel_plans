<?php
session_start();
include 'db.php'; // Impor koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Query untuk mengambil perjalanan
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
  <title>Dashboard - Travel App</title>
  <link rel="stylesheet" href="css/index_style.css">
</head>
<body>
  <!-- Header -->
  <header>
    <h1>Rencana Perjalanan</h1>
  </header>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="index.php">Beranda</a>
    <a href="add_trip.php">Tambah Perjalanan</a>
    <a href="trip_history.php">Riwayat Perjalanan</a>
    <a href="logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="container">
    <div class="card">
      <h3>Riwayat Perjalanan</h3>
      <table border="1" cellspacing="0" cellpadding="10" width="100%">
        <thead>
          <tr>
            <th>Destinasi</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Biaya</th>
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

  </div>
   <script src="script.js"></script>
</body>
</html>
