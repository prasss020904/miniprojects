<?php
include 'auth.php';
require 'koneksi.php';

if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_perusahaan = $_SESSION['user_id'];
    $nama = $_POST['nama_pekerjaan'];
    $kategori = $_POST['kategori'];
    $jenis = $_POST['jenis']; // dari select dropdown
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $gaji = $_POST['gaji'];
    $batas = $_POST['batas_lamaran'];

    // Upload logo
    $logo_name = '';
    if (!empty($_FILES['logo']['name'])) {
        $tmp = $_FILES['logo']['tmp_name'];
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo_name = time() . "_logo." . $ext;
        move_uploaded_file($tmp, "logoperusahaan/" . $logo_name);
    }

    // Simpan ke DB
    $sql = "INSERT INTO lowongan (perusahaan_id, nama_pekerjaan, kategori, jenis_pekerjaan, lokasi, deskripsi, syarat_kualifikasi, gaji, batas_lamaran, logo)
            VALUES ('$id_perusahaan', '$nama', '$kategori', '$jenis', '$lokasi', '$deskripsi', '$syarat', '$gaji', '$batas', '$logo_name')";
    
    $koneksi->query($sql);
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Lowongan</title>
    <link rel="stylesheet" href = "tambah_lowongan.css">
</head>
<body>
    <h2>Form Tambah Lowongan</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama Pekerjaan:</label><br>
        <input type="text" name="nama_pekerjaan" required><br><br>

        <label>Kategori:</label><br>
        <input type="text" name="kategori" required><br><br>

        <label>Jenis Pekerjaan:</label><br>
        <select name="jenis" required>
            <option value="">-- Pilih Jenis Pekerjaan --</option>
            <option value="Full-time">Full-time</option>
            <option value="Part-time">Part-time</option>
            <option value="Remote">Remote</option>
        </select><br><br>

        <label>Lokasi:</label><br>
        <input type="text" name="lokasi" required><br><br>

        <label>Deskripsi Pekerjaan:</label><br>
        <textarea name="deskripsi" rows="4" cols="40" required></textarea><br><br>

        <label>Syarat & Kualifikasi:</label><br>
        <textarea name="syarat" rows="4" cols="40" required></textarea><br><br>

        <label>Gaji:</label><br>
        <input type="number" name="gaji" required><br><br>

        <label>Batas Lamaran:</label><br>
        <input type="date" name="batas_lamaran" required><br><br>

        <label>Logo:</label><br>
        <input type="file" name="logo" accept="image/*"><br><br>

        <button type="submit">Simpan Lowongan</button>
    </form>
</body>
</html>
