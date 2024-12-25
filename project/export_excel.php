<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Sesuaikan username
$password = "";     // Sesuaikan password
$dbname = "travel_db"; // Nama database

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Tulis header kolom
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'User ID');
$sheet->setCellValue('C1', 'Tanggal Mulai');
$sheet->setCellValue('D1', 'Tanggal Selesai');
$sheet->setCellValue('E1', 'Total Biaya (Rp)');

// Query data
$sql = "SELECT id, user_id, start_date, end_date, total_cost FROM itineraries";
$result = $conn->query($sql);

// Tulis data ke spreadsheet
$rowNumber = 2; // Mulai dari baris kedua
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['id']);
        $sheet->setCellValue('B' . $rowNumber, $row['user_id']);
        $sheet->setCellValue('C' . $rowNumber, $row['start_date']);
        $sheet->setCellValue('D' . $rowNumber, $row['end_date']);
        $sheet->setCellValue('E' . $rowNumber, $row['total_cost']);
        $rowNumber++;
    }
}

// Set header untuk file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="data_perjalanan.xlsx"');

// Tulis file Excel ke output
$writer = new Xlsx($spreadsheet);
$writer->save("php://output");

$conn->close();
?>
