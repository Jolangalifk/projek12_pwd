<?php
require_once 'connection.php';

// Ambil ID dari parameter GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validasi ID
if ($id === 0) {
    echo "ID tidak valid.";
    exit;
}

// Ambil data mahasiswa berdasarkan ID
$sql = "SELECT * FROM mhs WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo 'Prepare failed: ' . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    echo "Data tidak ditemukan.";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Mahasiswa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border-radius: 10px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h2 {
            font-size: 28px;
            font-weight: 600;
        }

        .content {
            padding: 40px;
        }

        .detail-group {
            margin-bottom: 25px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 15px;
        }

        .detail-group:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #667eea;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #495057;
            font-size: 16px;
            word-break: break-word;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-back {
            background: #667eea;
            color: white;
        }

        .btn-back:hover {
            background: #5563c1;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #51cf66;
            color: white;
        }

        .btn-edit:hover {
            background: #40c057;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #f5576c;
            color: white;
        }

        .btn-delete:hover {
            background: #d93546;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Detail Data Mahasiswa</h2>
    </div>

    <div class="content">
        <div class="detail-group">
            <div class="detail-label">NIM</div>
            <div class="detail-value"><?= htmlspecialchars($row['nim']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Nama Lengkap</div>
            <div class="detail-value"><?= htmlspecialchars($row['nama']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">No HP</div>
            <div class="detail-value"><?= htmlspecialchars($row['no_hp']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Umur</div>
            <div class="detail-value"><?= htmlspecialchars($row['umur']); ?> tahun</div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Tempat Lahir</div>
            <div class="detail-value"><?= htmlspecialchars($row['tempat_lahir']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Tanggal Lahir</div>
            <div class="detail-value"><?= htmlspecialchars($row['tanggal_lahir']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Alamat</div>
            <div class="detail-value"><?= htmlspecialchars($row['alamat']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Kota</div>
            <div class="detail-value"><?= htmlspecialchars($row['kota']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Jenis Kelamin</div>
            <div class="detail-value"><?= htmlspecialchars($row['jk']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Status</div>
            <div class="detail-value"><?= htmlspecialchars($row['status']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Hobi</div>
            <div class="detail-value"><?= htmlspecialchars($row['hobi']); ?></div>
        </div>

        <div class="detail-group">
            <div class="detail-label">Email</div>
            <div class="detail-value"><?= htmlspecialchars($row['email']); ?></div>
        </div>

        <div class="action-buttons">
            <a href="tampilDataMhs.php" class="btn btn-back">Kembali</a>
            <a href="hapusDataMhs.php?id=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
