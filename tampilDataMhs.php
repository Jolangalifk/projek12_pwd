<?php
require_once 'connection.php';

// Ambil semua data mahasiswa
$sql = "SELECT * FROM mhs ORDER BY id ASC"; 
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .container {
            background: #fff;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            padding: 12px 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background: #667eea;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .btn-back {
            display: inline-block;
            padding: 10px 18px;
            background: #667eea;
            color: white;
            text-decoration: none;
            margin-top: 20px;
            font-weight: bold;
        }

        .btn-back:hover {
            background: #5563c1;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-lihat, .btn-hapus {
            padding: 8px 12px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-lihat {
            background: #51cf66;
            color: white;
        }

        .btn-lihat:hover {
            background: #40c057;
        }

        .btn-hapus {
            background: #f5576c;
            color: white;
        }

        .btn-hapus:hover {
            background: #d93546;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Data Mahasiswa</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Umur</th>
                <th>Kota</th>
                <th>Email</th>
                <th>Hobi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            $no = 1; // Nomor urut selalu dimulai dari 1
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nim']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['no_hp']); ?></td>
                        <td><?= htmlspecialchars($row['umur']); ?></td>
                        <td><?= htmlspecialchars($row['kota']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['hobi']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="lihatDataMhs.php?id=<?= $row['id']; ?>" class="btn-lihat">Lihat</a>
                                <a href="hapusDataMhs.php?id=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </div>
                        </td>
                    </tr>
            <?php
                }
            } else { ?>
                <tr>
                    <td colspan="9" style="text-align:center;">Belum ada data</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="tambahDataMhs.php" class="btn-back">Tambah Data Baru</a>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
