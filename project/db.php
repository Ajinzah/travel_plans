

<?php
$host = "localhost"; // Server database
$username = "root"; // Username database
$password = ""; // Password database (kosong jika default XAMPP)
$database = "travel_planner"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengatur charset
$conn->set_charset("utf8");

// Uncomment ini untuk debugging koneksi
// echo "Koneksi berhasil!";
?>
