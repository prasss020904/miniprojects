<?php
include 'auth.php';
require 'koneksi.php';

if ($_SESSION['role'] !== 'perusahaan') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Cek apakah lowongan ini sudah dilamar
$cek = $koneksi->query("SELECT COUNT(*) AS total FROM lamaran WHERE lowongan_id = $id");
$data = $cek->fetch_assoc();

if ($data['total'] > 0) {
    // Ada pelamar → tampilkan pesan
    echo 
    "<!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Gagal Hapus</title>
        <link rel='stylesheet' href='dashboard.css'>
    </head>
    <body>
        <div class='warning-box'>
            <p>Lowongan ini sudah memiliki pelamar dan tidak bisa dihapus.</p>
            <a href='dashboard.php' class='back-button'>⬅ Kembali ke Dashboard</a>
        </div>
    </body>
    </html>";
    exit();
}

$koneksi->query("DELETE FROM lowongan WHERE id = $id");
header("Location: dashboard.php");
exit();
?>
