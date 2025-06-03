<?php
session_start();
require 'koneksi.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $query = $koneksi->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if ($query->num_rows > 0) {
        $user = $query->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'perusahaan') {
    $_SESSION['perusahaan_nama'] = $user['perusahaan_nama'];
} else {
    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
}
        header("Location: " . ($user['role'] == 'perusahaan' ? 'dashboard.php' : 'index.php'));
        exit();
    } else {
        $error = "Email atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Info Loker</title>
    <link rel="stylesheet" href = "login.css">
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="daftar.php">Daftar</a></p>
    </div>
</body>
</html>
