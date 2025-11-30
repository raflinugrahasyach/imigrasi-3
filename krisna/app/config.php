<?php
// =========$conn (string koneksi ke database lokal)=============
$servername='localhost';
$username='root';
$password='';
$dbname = "krisna_new";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
    die('Could not Connect My Sql:' .mysqli_connect_error());
}

// ========$conn_spri (string koneksi ke spri)================
// Baris ini dinonaktifkan untuk pengembangan lokal agar tidak timeout
/*
$servername_spri='10.5.16.17';
$username_spri='balikpapanView';
$password_spri='V!3wbalikpapan';
$dbname_spri = "spri_local";
$conn_spri=mysqli_connect($servername_spri,$username_spri,$password_spri,"$dbname_spri",3306);

if(!$conn_spri){
    die('Could not Connect My Sql:' .mysql_error());
}
*/
// Agar tidak error di halaman lain, variabel $conn_spri diarahkan sementara ke koneksi lokal
$conn_spri = $conn;

// ========$conn_arsip (string koneksi ke arsip)================
$servername_arsip='localhost';
$username_arsip='root';
$password_arsip='';
$dbname_arsip = "arsip";
$conn_arsip=mysqli_connect($servername_arsip,$username_arsip,$password_arsip,"$dbname_arsip");
if(!$conn_arsip){
    // Dibuat agar tidak fatal error jika database 'arsip' tidak ada
    // die('Could not Connect My Sql:' .mysql_error());
}

?>