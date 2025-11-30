<?php
session_start();
if (!isset($_SESSION['username'])){
header("location:index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PANDAWA</title>
<link rel="stylesheet" href="../images/Envision.css" type="text/css" />
</head>
<body>
<div id="wrap">
  <div id="header">
    <h1 id="logo-text"><a href="content.php" title="">PANDAWA</a></h1>
    <p id="slogan">Pusat Arsip Kanim Kelas I TPI Surakarta </p>
  </div>
  <div  id="menu">
    <ul>
        <li class="first"><a href="view.php?module=home" target="content">HOME</a></li>
        <li><a href="view.php?module=manajemenuser" target="content">MANAJEMEN USER</a></li>
        <li><a href="view.php?module=manajemenrak" target="content">MANAJEMEN RAK</a></li>
        <li><a href="view.php?module=manajemenwa" target="content">MANAJEMEN PESAN</a></li>
        <li><a href="view.php?module=log" target="content">LOG ACTIVITY</a></li>

        <li><a href="wa_reminder.php" target="content">PENGINGAT WA</a></li>

        <li><a href="../logout.php">LOGOUT</a></li>
    </ul>
  </div>
  <div id="content-wrap">
    <div id="main">
      <iframe src="view.php?module=home" name="content" width="100%" height="1800px" style="border:none"></iframe>
    </div>
  </div>
  <div id="footer-bottom">
    <p> &copy; 2023 <strong>Kantor Imigrasi Kelas I TPI Surakarta</strong> | Design by <a href="http://www.styleshout.com/">styleshout</a> | Built by <a href="https://www.instagram.com/krisna.s.n/">krisna.s.n</a></p>
  </div>
</div>
</body>
</html>