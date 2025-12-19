<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambahDataMhs.php');
    exit;
}

// Ambil dan sanitasi input
$nim = substr(strip_tags(trim($_POST['nim'] ?? '')), 0, 50);
$nama = substr(strip_tags(trim($_POST['nama'] ?? '')), 0, 200);

$no_hp_raw = trim($_POST['no_hp'] ?? '');
$no_hp = preg_replace('/[^0-9+\- ]/', '', $no_hp_raw);
$no_hp = substr($no_hp, 0, 50);

$umur = isset($_POST['umur']) ? (int)$_POST['umur'] : 0;
if ($umur < 0) $umur = 0;

$tempat_lahir = substr(strip_tags(trim($_POST['tempat_lahir'] ?? '')), 0, 100);

$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
if ($tanggal_lahir !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_lahir)) {
    $tanggal_lahir = '';
}

$alamat = substr(strip_tags(trim($_POST['alamat'] ?? '')), 0, 1000);
$kota = substr(strip_tags(trim($_POST['kota'] ?? '')), 0, 100);
$jk = substr(strip_tags(trim($_POST['jk'] ?? '')), 0, 50);
$status = substr(strip_tags(trim($_POST['status'] ?? '')), 0, 50);

$hobi_arr = $_POST['hobi'] ?? [];
if (is_array($hobi_arr)) {
    $sanitized_hobi = array_map(function ($h) {
        return substr(strip_tags(trim((string)$h)), 0, 100);
    }, $hobi_arr);
    $hobi = implode(', ', $sanitized_hobi);
} else {
    $hobi = '';
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

// Validasi minimal
if ($nim === '' || $nama === '' || $email === '') {
    echo "Field NIM, Nama, dan Email wajib diisi.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email tidak valid.";
    exit;
}

if (!preg_match('/^[A-Za-z0-9.\-]+$/', $nim)) {
    echo "NIM hanya boleh huruf, angka, titik, dan tanda '-' (tanpa spasi).";
    exit;
}

if (!preg_match('/^[\p{L}\s\'\-]+$/u', $nama)) {
    echo "Nama hanya boleh huruf dan spasi.";
    exit;
}

$hp_digits = preg_replace('/\D/', '', $no_hp);
if ($hp_digits === '' || strlen($hp_digits) < 6) {
    echo "Nomor HP minimal 6 angka.";
    exit;
}

if ($umur < 0 || $umur > 120) {
    echo "Umur tidak valid.";
    exit;
}

if ($tanggal_lahir !== '') {
    if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $tanggal_lahir, $m)) {
        echo "Format tanggal lahir harus YYYY-MM-DD.";
        exit;
    }
    if (!checkdate((int)$m[2], (int)$m[3], (int)$m[1])) {
        echo "Tanggal lahir tidak valid.";
        exit;
    }
}

// Simpan ke database
$sql = "INSERT INTO mhs (nim, nama, no_hp, umur, tempat_lahir, tanggal_lahir, alamat, kota, jk, status, hobi, email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo 'Prepare failed: ' . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sssissssssss",
    $nim,
    $nama,
    $no_hp,
    $umur,
    $tempat_lahir,
    $tanggal_lahir,
    $alamat,
    $kota,
    $jk,
    $status,
    $hobi,
    $email
);

$exec = mysqli_stmt_execute($stmt);

if ($exec) {

    // SIMPAN INPUT USER KE SESSION
    $_SESSION['hasil_mhs'] = [
        'nim' => $nim,
        'nama' => $nama,
        'no_hp' => $no_hp,
        'umur' => $umur,
        'tempat_lahir' => $tempat_lahir,
        'tanggal_lahir' => $tanggal_lahir,
        'alamat' => $alamat,
        'kota' => $kota,
        'jk' => $jk,
        'status' => $status,
        'hobi' => $hobi,
        'email' => $email
    ];

    header("Location: tampilDataMhs.php");
    exit;

} else {

    echo "Insert gagal: " . htmlspecialchars(mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
