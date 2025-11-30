<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
session_start();
if (empty($_SESSION['nip']) AND empty($_SESSION['passuser'])){
  echo "<center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>KRISNA - ADMIN</title>
<link rel="shortcut icon" href="../images/pdw-admin.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="../images/Envision.css" type="text/css" />
</head>
<body>
<div id="wrap">
  <div id="header">
	<p><div align="left"><img src="../images/krisna_logo.png" height="75"></div></p>
  </div>
  <div  id="menu">
    <ul>
      <li id="current"><a href="#">
		<a href="view.php?module=passwordadmin">SELAMAT DATANG ADMINISTRATOR DI APLIKASI KRISNA</a>
	  </li>
    </ul>
  </div>
  <div id="content-wrap">
    <div id="sidebar">
      <h1>Menu</h1>
      <ul class="sidemenu">
        <li><a href="view.php?module=home">HOME</a></li>
        <li><a href="view.php?module=manajemenuser">MANAJEMEN USER</a></li>
        <li><a href="view.php?module=manajemenrak">MANAJEMEN RAK</a></li>
		<li><a href="view.php?module=manajemenwa">MANAJEMEN PESAN</a></li>
        
        <li><a href="view.php?module=wa_reminder">PENGINGAT WA</a></li>
        <li><a href="view.php?module=log">LOG ACTIVITY</a></li>
		<li><a href="logout.php">LOGOUT</a></li>
      </ul>
    </div>
    <div id="main"> <a name="TemplateInfo"></a>
      <?php include "content.php"; ?>
    </div>
  </div>
  <div id="footer">
    <p> &copy; Developed by <strong><a href="https://www.instagram.com/y.diantara/">Y.Diantara</a><br>
	Part of</strong> <a href="https://www.instagram.com/imigrasi_balikpapan/"><strong>TIKKIM Kanim Balikpapan 2024</strong></a></p>
  </div>
</div>
</body>
</html>
<?php } ?>