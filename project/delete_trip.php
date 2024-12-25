<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include('db.php');

// Hapus data perjalanan
if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
    $sql = "DELETE FROM trips WHERE trip_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $trip_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        header('Location: trip_history.php');
        exit();
    } else {
        echo "Gagal menghapus perjalanan.";
    }
} else {
    header('Location: trip_history.php');
    exit();
}
?>
