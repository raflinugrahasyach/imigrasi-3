<?php
//koneksi ke db lokal
$servername='localhost';
$username='root';
$password='';
$dbname = "pandawa";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
   die('Could not Connect My Sql:' .mysql_error());
}

//koneksi ke db akses view
$servername='10.5.16.17';
$username='balikpapanView';
$password='wnaV!3wknbal1kp4p4n!';
$dbname="db_it_kanim";
$conn_spri=mysqli_connect($servername,$username,$password,"$dbname",3307);
if(!$con_spri){
	die('Could not Connect My Sql SPRI:' .mysql_error());
}
?>