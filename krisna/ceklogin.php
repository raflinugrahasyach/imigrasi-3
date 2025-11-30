<?php
session_start();
include_once 'app/config.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

// Query untuk admin
$login_admin = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
$cek_admin = mysqli_num_rows($login_admin);

// Query untuk user
$login_user = mysqli_query($conn, "SELECT * FROM user WHERE nip='$username' AND password='$password' AND status='Aktif'");
$cek_user = mysqli_num_rows($login_user);

if ($cek_admin > 0) {
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login_admin";
    header("location:admin/content.php?module=home");

} elseif ($cek_user > 0) {
    // === BAGIAN PENTING YANG DIPERBAIKI ===
    // Ambil data NIP dari hasil query
    $user_data = mysqli_fetch_assoc($login_user);
    
    // Simpan username (NIP) dan NIP ke dalam session
    $_SESSION['username'] = $username;
    $_SESSION['nip'] = $user_data['nip']; // <-- BARIS INI DITAMBAHKAN
    $_SESSION['status'] = "login_user";
    header("location:content.php?module=home");

} else {
    header("location:index.php?pesan=gagal");
}
?>