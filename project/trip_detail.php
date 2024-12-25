<?php
include '../db.php';
include '../functions.php';

$trip_id = $_GET['trip_id'] ?? 0;

// Fetch detail perjalanan
$query = $pdo->prepare("SELECT * FROM trips WHERE trip_id = ?");
$query->execute([$trip_id]);
$trip = $query->fetch(PDO::FETCH_ASSOC);

if (!$trip) {
    die("Perjalanan tidak ditemukan!");
}

// Fetch destinasi
$query = $pdo->prepare("SELECT * FROM destinasi WHERE trip_id = ?");
$query->execute([$trip_id]);
$destinations = $query->fetchAll(PDO::FETCH_ASSOC);

// Total biaya
$total_cost = calculate_total_cost($pdo, $trip_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perjalanan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Detail Perjalanan: <?= htmlspecialchars($trip['trip_name']) ?></h1>
    <p>Tanggal: <?= htmlspecialchars($trip['start_date']) ?> - <?= htmlspecialchars($trip['end_date']) ?></p>
    <p>Anggaran: Rp <?= number_format($trip['budget'], 2) ?></p>
    <p>Total Biaya Destinasi: Rp <?= number_format($total_cost, 2) ?></p>
    <h2>Destinasi</h2>
    <a href="add_destination.php?trip_id=<?= $trip_id ?>" class="btn">Tambah Destinasi Baru</a>
    <table>
        <thead>
            <tr>
                <th>Nama Destinasi</th>
                <th>Aktivitas</th>
                <th>Biaya</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($destinations as $dest): ?>
                <tr>
                    <td><?= htmlspecialchars($dest['destinasi_name']) ?></td>
                    <td><?= htmlspecialchars($dest['activity']) ?></td>
                    <td>Rp <?= number_format($dest['cost'], 2) ?></td>
                    <td>
                        <a href="edit_destination.php?destinasi_id=<?= $dest['destinasi_id'] ?>">Edit</a>
                        <a href="delete_destination.php?destinasi_id=<?= $dest['destinasi_id'] ?>" onclick="return confirm('Hapus destinasi ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

