<?php
include 'auth.php';
require 'koneksi.php';

if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$lowongan_id = $_GET['id'];
$query = $koneksi->query("SELECT * FROM lamaran WHERE lowongan_id = $lowongan_id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pelamar</title>
    <link rel="stylesheet" href = "lihat_pelamar.css">
</head>
<body>
    <h2>Daftar Pelamar:</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Nomor HP</th>
            <th>CV</th>
        </tr>
        <?php while($row = $query->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nama_lengkap'] ?></td>
            <td><?= $row['tanggal_lahir'] ?></td>
            <td><?= $row['nomor_hp'] ?></td>
            <td>
                <a href="uploads/<?= $row['cv_file'] ?>" target="_blank">Lihat CV</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
