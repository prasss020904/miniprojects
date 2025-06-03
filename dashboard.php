<?php
include 'auth.php';
require 'koneksi.php';

if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$id_perusahaan = $_SESSION['user_id'];
$query = $koneksi->query("SELECT * FROM lowongan WHERE perusahaan_id = $id_perusahaan");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perusahaan</title>
    <link rel="stylesheet" href = "dashboard.css">
</head>
<body>
    <h2 class="header-title">Dashboard Perusahaan</h2>
           <div class="greeting">
    Halo, <?= htmlspecialchars($_SESSION['perusahaan_nama'] ?? 'Perusahaan') ?>
    </div>
       <div class="profile-icon" onclick="toggleDropdown()">
        <img src="logoprofil.png" alt="Profil">
        <div class="dropdown" id="dropdown-menu">
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </header>
    <a href="tambah_lowongan.php">+ Tambah Lowongan</a>
    <br><br>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Logo</th>
            <th>Posisi</th>
            <th>Kategori</th>
            <th>Gaji</th>
            <th>Edit</th>
        </tr>
        <?php while($l = $query->fetch_assoc()): ?>
        <tr>
            <td>
                <?php if (!empty($l['logo'])): ?>
                    <img src="logoperusahaan/<?= $l['logo'] ?>" width="80" alt="Logo">
                <?php endif; ?>
            </td>
            <td><?= $l['nama_pekerjaan'] ?></td>
            <td><?= $l['kategori'] ?></td>
            <td>Rp <?= number_format($l['gaji']) ?></td>
            <td>
                <a href="edit_lowongan.php?id=<?= $l['id'] ?>">Edit</a> |
                <a href="hapus_lowongan.php?id=<?= $l['id'] ?>" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">Hapus</a> |
                <a href="lihat_pelamar.php?id=<?= $l['id'] ?>">Lihat Pelamar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <script>
function toggleDropdown() {
  const menu = document.getElementById("dropdown-menu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}
</script>

</body>
</html>
