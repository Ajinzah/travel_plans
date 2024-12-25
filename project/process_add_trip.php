<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek jika form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $trip_name = $_POST['trip_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $budget = $_POST['budget'];
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session

    // Validasi input
    if (empty($trip_name) || empty($start_date) || empty($end_date) || empty($budget)) {
        echo "Semua field harus diisi!";
        exit();
    }

    // Koneksi ke database
    include 'db.php'; // Pastikan jalur ke file db.php benar

    // Query untuk menyimpan data perjalanan
    $query = "INSERT INTO trips (user_id, trip_name, start_date, end_date, budget, created_at) 
              VALUES (?, ?, ?, ?, ?, NOW())";

    // Persiapkan statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameter
        $stmt->bind_param("isssd", $user_id, $trip_name, $start_date, $end_date, $budget);

        // Eksekusi query
        if ($stmt->execute()) {
            // Redirect ke halaman index setelah berhasil
            header("Location: index.php");
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan perjalanan.";
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Gagal menyiapkan query.";
    }

    // Tutup koneksi
    $conn->close();
}
?>
