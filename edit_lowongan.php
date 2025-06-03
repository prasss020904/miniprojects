<?php
include 'auth.php';
require 'koneksi.php';

if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$lowongan = $koneksi->query("SELECT * FROM lowongan WHERE id='$id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_pekerjaan'];
    $kategori = $_POST['kategori'];
    $jenis = $_POST['jenis'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $gaji = $_POST['gaji'];
    $batas = $_POST['batas_lamaran'];

    // Cek apakah user upload logo baru
    if (!empty($_FILES['logo']['name'])) {
        $tmp = $_FILES['logo']['tmp_name'];
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo_name = time() . "_logo." . $ext;
        move_uploaded_file($tmp, "uploads/" . $logo_name);
    } else {
        $logo_name = $lowongan['logo'];
    }

    $sql = "UPDATE lowongan SET 
                nama_pekerjaan='$nama', kategori='$kategori', jenis_pekerjaan='$jenis',
                lokasi='$lokasi', deskripsi='$deskripsi', syarat_kualifikasi='$syarat',
                gaji='$gaji', batas_lamaran='$batas', logo='$logo_name'
            WHERE id='$id'";

    $koneksi->query($sql);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Lowongan</title>
    <link rel="stylesheet" href = "edit.lowongan.css">
</head>
<body>
    <h2>Edit Lowongan</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nama_pekerjaan" value="<?= $lowongan['nama_pekerjaan'] ?>" required><br>
        <input type="text" name="kategori" value="<?= $lowongan['kategori'] ?>" required><br>
        <select name="jenis" required>
            <option value="Full-time" <?= $lowongan['jenis_pekerjaan'] == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
            <option value="Part-time" <?= $lowongan['jenis_pekerjaan'] == 'Part-time' ? 'selected' : '' ?>>Part-time</option>
            <option value="Remote" <?= $lowongan['jenis_pekerjaan'] == 'Remote' ? 'selected' : '' ?>>Remote</option>
        </select><br>
        <input type="text" name="lokasi" value="<?= $lowongan['lokasi'] ?>" required><br>
        <textarea name="deskripsi" required><?= $lowongan['deskripsi'] ?></textarea><br>
        <textarea name="syarat" required><?= $lowongan['syarat_kualifikasi'] ?></textarea><br>
        <input type="number" name="gaji" value="<?= $lowongan['gaji'] ?>" required><br>
        <input type="date" name="batas_lamaran" value="<?= $lowongan['batas_lamaran'] ?>" required><br>
        <label>Upload Logo Baru (kosongkan jika tidak diganti):</label><br>
        <input type="file" name="logo" accept="image/*"><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
