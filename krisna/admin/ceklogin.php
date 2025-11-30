<?php

$pass=md5($_POST['password']);
include_once '../app/config.php';
$login=mysqli_query($conn,"SELECT * FROM admin WHERE username='$_POST[username]' AND password='$pass'");
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
	session_start();
  
	$_SESSION['username']=$r['username'];
	$_SESSION['passuser']=$r['password'];
    
    // ================== PERBAIKAN PENTING ==================
    // Menambahkan session 'nip' untuk admin agar halaman lain tidak error.
    $_SESSION['nip'] = $r['username']; 
    // ===============================================
	
	header('location:view.php?module=home');
}
else{
  echo"<div align='center'><br><br><br><h2>Username/Password Salah <br> Silakan Coba Lagi</h2><br>
		<input type=button value=Kembali style='height:35px; width:100px' onclick=self.history.back()>";
}
?>