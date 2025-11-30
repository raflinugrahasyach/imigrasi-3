<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>KRISNA</title>
<link rel="shortcut icon" href="images/pdw-admin.ico">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="images2/Envision.css" type="text/css" />
</head>
<body>
<div id="wrap">
  <div id="header">
    <!--<h1 id="logo-text">PANDAWA</h1>
    <h2 id="slogan">ADMIN PENYIMPANAN DOKUMEN KEIMIGRASIAN WNA</h2>-->
	<p><div align="left"><img src="images/krisna_logo.png" height="75"></div></p>
  </div>
  <div  id="menu">
    <marquee style="color:yellow">SELAMAT DATANG DI AREA ADMINISTRATOR APLIKASI KRISNA, SILAKAN LOGIN TERLEBIH DAHULU</marquee>
  </div>
  <div id="content-wrap">
    <div id="main"> <a name="TemplateInfo"></a>

<?php 
		//$con=mysqli_connect("localhost","root","","pandawa");
	  echo"<h3>LOGIN</h3>
      <form action='ceklogin.php' method='POST'>
        <div align='center'>
		<table>
			<tr><td>Username</td><td><input type='text' name='username' size='30' required><br></td></tr>
			<tr><td>Password</td><td><input type='password' name='password' size='30' required>
			<tr><td colspan='2'  align='right'><button name='submit' class='button'>Login</button></td></tr>
		</table>
        </div>
      </form>";
	  ?>
    </div>
  </div>
  <div id="footer">
    <p> &copy; Developed by <strong><a href="https://www.instagram.com/y.diantara/">Y.Diantara</a><br>
	Part of</strong> <a href="https://www.instagram.com/imigrasi_balikpapan/"><strong>TIKKIM Kanim Balikpapan 2024</strong></a></p>
  </div>
</div>
</body>
</html>
