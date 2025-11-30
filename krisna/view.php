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
<title>KRISNA</title>
<link rel="shortcut icon" href="images/krisna_icon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="images/Envision.css" type="text/css" />

    
<link href="app/css/sweetalert2.min.css" rel="stylesheet">
</link>
		
</head>
<body>
<div id="wrap">
  <div id="header">
    <!--<h1 id="logo-text">PANDAWA</h1>
    <h2 id="slogan">PENYIMPANAN DOKUMEN KEIMIGRASIAN WNA</h2>-->
	<p><div align="left"><img src="images/krisna_logo.png" height="75"></div></p>
  </div>
  <div  id="menu">
    <ul>
      <li id="current"><a href="#"><?php
									$con=mysqli_connect("localhost","root","","krisna_new");
									$user = mysqli_query($con,"SELECT * FROM user where nip = '$_SESSION[nip]'");
									$u = mysqli_fetch_array($user);
									echo"<a href='view.php?module=user'>$_SESSION[nip] - $u[nama]</a>";
									?></a></li>
    </ul>
  </div>
  <div id="content-wrap">
    <div id="sidebar">
      <h1>Menu</h1>
      <ul class="sidemenu">
        <li><a href=view.php?module=home>HOME</a></li>
        <li><a href=view.php?module=carisimpan>PENYIMPANAN PASPOR</a></li>
        <li><a href=view.php?module=serah>PENYERAHAN PASPOR</a></li>
        <li><a href=view.php?module=dokimsimpan>LIHAT DATA PASPOR</a></li>
		<li><a href=view.php?module=peringatan>PERINGATAN PEMBATALAN</a></li>
		<li><a href=view.php?module=kirimarsip>KIRIM KE ARSIP</a></li>
		<?php
		echo"<li><a href='input.php?module=logout&nip=$_SESSION[nip]'>LOGOUT</a></li>";
		?>
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