<?php
require_once 'connection.php';

// Ambil ID dari parameter GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validasi ID
if ($id === 0) {
    echo "ID tidak valid.";
    exit;
}

// Buat query hapus data
$sql = "DELETE FROM mhs WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo 'Prepare failed: ' . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);
$exec = mysqli_stmt_execute($stmt);

if ($exec) {
    // Hapus berhasil, redirect ke tampilDataMhs.php
    header("Location: tampilDataMhs.php");
    exit;
} else {
    echo "Hapus gagal: " . htmlspecialchars(mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
