<!DOCTYPE html>
<html>
<head>
	<title>Cetak Data Arsip Paspor</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
	
	<?php
	date_default_timezone_set("Asia/SIngapore");
	$tanggallog=date('Y-m-d H:i:s');
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Pengiriman Dokumen Paspor ke Arsip $tanggallog.xls");
	// koneksi database
		$koneksi = mysqli_connect("localhost","root","","krisna");
	$nama = mysqli_query($koneksi,"SELECT * FROM user WHERE nip = '$_GET[nip_arsip]'");
	$n = mysqli_fetch_array($nama);
	?>
 
	<center>
		<b><font size=+2>DATA PENGIRIMAN BERKAS PASPOR KE ARSIP <br> KANTOR IMIGRASI BALIKPAPAN</font></b><br>
		<?php echo"Tanggal Pengiriman : $_GET[tanggal_arsip] <br>
				   Petugas Pengirim : $_GET[nip_arsip] - $n[nama]</b><br><br>"; ?>
	</center>
 
	<table border="1">
		<tr>
			<th>NO</th>
			<th>NOMOR PERMOHONAN<br>(15 Digit Awal)</th>
			<th>NOMOR PERMOHONAN 2<br>(1 Digit Akhir)</th>
			<th>NOMOR PASPOR</th>
			<th>NAMA</th>
		</tr>
		<?php 
		
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b ON a.nomor_permohonan=b.nomor_permohonan
														WHERE a.tanggal_arsip='$_GET[tanggal_arsip]' AND nip_arsip='$_GET[nip_arsip]'");
		$jumlah = mysqli_num_rows($data);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $d['nomor_permohonan']; ?></td>
			<?php
				$string = mysqli_query($koneksi, "SELECT substr(nomor_permohonan, 16) as no_permohonan FROM arsip_paspor WHERE nomor_permohonan = '$d[nomor_permohonan]'");
				$st = mysqli_fetch_array($string);?>
			<td><?php echo $st['no_permohonan']; ?></td>
			<td><?php echo $d['nomor_paspor']; ?></td>
			<td><?php echo $d['nama']; ?></td>
		</tr>
		<?php 
		}
		?>
	
	</table>
	<br><div align="right"><?php echo"tanggal cetak laporan : $tanggallog" ?></div>

	

</body>
</html>