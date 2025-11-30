<!DOCTYPE html>
<html>
<head>
	<title>Export Data Penyerahan Paspor Ke Excel</title>
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
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_Penyerahan_Dokim_WNA_$_POST[tanggal_awal]_sd_$_POST[tanggal_akhir].xls");
	?>
 
	<table border="1">
		<tr>
			<th>NO</th>
			<th>NOMOR PERMOHONAN</th>
			<th>NIORA</th>
			<th>NOMOR DOKIM</th>
			<th>NOMOR PASPOR</th>
			<th>NAMA PEMOHON</th>
			<th>KEBANGSAAN</th>
			<th>JENIS KELAMIN</th>
			<th>TEMPAT LAHIR</th>
			<th>TANGGAL LAHIR</th>
			<th>JENIS LAYANAN</th>
			<th>KETERANGAN</th>
			<th>TANGGAL PERMOHONAN</th>
		</tr>
		<?php 
		// koneksi database
		$koneksi = mysqli_connect("localhost","root","","pandawa");
 
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,"select a.*, b.* from arsip_dokim a LEFT JOIN dokim_wna b ON a.nomor_permohonan = b.nomor_permohonan WHERE a.tanggal_serah >= '$_POST[tanggal_awal]' AND a.tanggal_serah <= '$_POST[tanggal_akhir]'");
		$no=1;
		while($d = mysqli_fetch_array($data)){
			//$kanan = substr($d['nopermohonan'],15);
			//$kiri = substr($d['nopermohonan'],0,-1);
			
		?>
		<tr>
			<td><?php echo $no; ?></td>
			<td><?php echo $d['nomor_permohonan']; ?></td>
			<td><?php echo $d['niora']; ?></td>
			<td><?php echo $d['nomor_dokim']; ?></td>
			<td><?php echo $d['nomor_paspor']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td><?php echo $d['kebangsaan']; ?></td>
			<td><?php echo $d['jenis_kelamin']; ?></td>
			<td><?php echo $d['tempat_lahir']; ?></td>
			<td><?php echo $d['tanggal_lahir']; ?></td>
			<td><?php echo $d['jenis_layanan']; ?></td>
			<td><?php echo $d['keterangan']; ?></td>
			<td><?php echo $d['tanggal_permohonan']; ?></td>
		</tr>
		<?php
			$no++;
		}
		?>
	</table>
</body>
</html>