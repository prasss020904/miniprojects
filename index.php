<?php
include 'auth.php';
require 'koneksi.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
$today = date('Y-m-d');


// Query awal
$sql = "SELECT l.*, u.perusahaan_nama, l.logo 
        FROM lowongan l 
        JOIN users u ON l.perusahaan_id = u.id 
        WHERE l.batas_lamaran >= '$today'";

// Tambahkan filter pencarian
if (!empty($keyword)) {
    $sql .= " AND u.perusahaan_nama LIKE '%$keyword%'";
}
if (!empty($kategori)) {
    $sql .= " AND l.kategori = '$kategori'";
}
if (!empty($jenis)) {
    $sql .= " AND l.jenis_pekerjaan = '$jenis'";
}



$query = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>INFO LOKER</title>
    <link rel="stylesheet" href = "index.css">
</head>
<body>
    <header>
        <div class="greeting">
         Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>
    </div>
        <h1 class="title">INFO LOKER</h1>
        <div class="profile-menu" onclick="toggleDropdown()">
        <img src="logoprofil.png" alt="Profil">
        <div class="dropdown" id="dropdown-menu">
        <a href="logout.php">Logout</a>
</div>

    </header>

    <div class="search-bar">
        <form method="GET">
            <label>Cari Nama Perusahaan:</label>
            <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder = "Cari Nama Perusahaan">
            <select name="kategori">
                <option value="">Kategori Pekerjaan</option>
                <option value="IT" <?= $kategori == 'IT' ? 'selected' : '' ?>>IT</option>
                <option value="Keuangan" <?= $kategori == 'Keuangan' ? 'selected' : '' ?>>Keuangan</option>
                <option value="Pendidikan" <?= $kategori == 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
            </select>
            <button type="submit">Cari</button>
        </form>
    </div>

    <div class="job-list">
        <?php if ($query->num_rows > 0): ?>
            <?php while($row = $query->fetch_assoc()): ?>
                <div class="job-item">
                    <?php if (!empty($row['logo'])): ?>
                        <img src="logoperusahaan/<?= $row['logo'] ?>" alt="Logo">
                    <?php endif; ?>
                    <h2><?= $row['nama_pekerjaan'] ?></h2>
                    <p><?= $row['perusahaan_nama'] ?></p>
                    <p><?= $row['jenis_pekerjaan'] ?> | Rp <?= number_format($row['gaji']) ?></p>
                    <p>Lokasi : <?= $row['lokasi'] ?></p>
                    <a href="ajukan_lamaran.php?id=<?= $row['id'] ?>">Lihat Detail</a>
                </div>
            <?php endwhile; ?>  
        <?php else: ?>
            <p>Tidak ada lowongan ditemukan.</p>
        <?php endif; ?>
    </div>

    <script src="index.js"></script>

</body>
    <footer>
        <p>&copy; INFO LOKER</p>
    </footer>
</html>
