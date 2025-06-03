<?php
session_start();
require 'koneksi.php';
if ($_SESSION['role'] != 'pencari_kerja') {
     header("Location: login.php"); 
    exit();
     }
$user_id = $_SESSION['user_id'];
$lowongan_id = $_GET['id'];
$cek = $koneksi->query("SELECT * FROM lamaran WHERE user_id=$user_id AND lowongan_id=$lowongan_id");
if ($cek->num_rows > 0) die("Anda sudah melamar.");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cv = $_FILES['cv']['name'];
    $cvtmp = $_FILES['cv']['tmp_name'];
    $cvname = time() . '_cv.' . pathinfo($cv, PATHINFO_EXTENSION);
    move_uploaded_file($cvtmp, 'uploads/' . $cvname);
    $koneksi->query("INSERT INTO lamaran (user_id, lowongan_id, nama_lengkap, tanggal_lahir, nomor_hp, cv_file)
                     VALUES ($user_id, $lowongan_id, '{$_POST['nama_lengkap']}', '{$_POST['tanggal_lahir']}', '{$_POST['nohp']}', '$cvname')");
    echo "Lamaran dikirim."; exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ajukan Lamaran</title>
    <link rel="stylesheet" href="ajukan_lamaran.css">
</head>
<body>
    <h2>Form Pengajuan Lamaran</h2>
    <form method="POST" enctype="multipart/form-data">
        <input name="nama_lengkap" placeholder="Nama Lengkap" required>
        <input type="date" name="tanggal_lahir" required>
        <input type="tel" name="nohp" placeholder="No HP" required>
        <input type="file" name="cv" accept=".pdf" required>
        <button type="submit">Kirim</button>
    </form>
</body>
</html>