<?php

$con=mysqli_connect("localhost","root","","pandawa");
// Check connection
/*if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/

// Halaman Home (Pencarian Data Sebelum Input)
if ($_GET['module']=='home'){
	echo "<h1>SELAMAT DATANG</h1>";
}
?>