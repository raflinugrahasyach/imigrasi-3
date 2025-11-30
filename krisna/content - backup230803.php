<?php

include_once 'app/config.php';
//$conn=mysqli_connect("localhost","root","","pandawa");
// Check connection
/*if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/

//HALAMAN HOME (DASHBOARD)
if ($_GET['module']=='home'){
	$user = mysqli_query ($conn,"SELECT * FROM user where nip = '$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	echo "<h1>DASHBOARD</h1>
			<h3>JUMLAH DOKIM WNA YANG DIARSIPKAN 7 HARI TERAKHIR PADA SEKSI $u[seksi]</h3>";
	
	
	echo"<iframe src='app/chart1.php' height='400px' width='700px'></iframe>
			<br><br><hr color=#265180><br>
	 
			<h3>JUMLAH DOKIM WNA YANG DISERAHKAN DALAM 7 HARI TERAKHIR PADA SEKSI $u[seksi]</h3>
			<iframe src='app/chart2.php' height='400px' width='700px'></iframe>";
	 
	}

// HALAMAN SCAN NO DOKIM SIMPAN
elseif ($_GET['module']=='carisimpan'){
	echo"<h3>PENYIMPANAN DOKUMEN KEIMIGRASIAN WNA</h3>
	<form method=POST action='view.php?module=hasilcarisimpan'>
	<table>
	   <tr align='right'><td colspan=3 align='left'><i>Masukkan Nomor Permohonan Izin Tinggal</i></td></tr>
	  <tr><td><b>NOMOR PERMOHONAN</b></td><td width='15'>:</td><td><input name=nomor_permohonan type=text size=50></td></tr>
	  <tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
	";
}

// HALAMAN PENYIMPANAN OTOMATIS
elseif ($_GET['module']=='hasilcarisimpan'){
	echo"<h3>PENYIMPANAN DOKUMEN KEIMIGRASIAN WNA</h3>";
	
	$cari=mysqli_query($conn,"SELECT * FROM arsip_dokim
									where nomor_permohonan='$_POST[nomor_permohonan]'");
	$jumlahcari = mysqli_num_rows($cari);
	$jc = mysqli_fetch_array($cari);
	
	//JIKA NOMOR PERMOHONAN SUDAH PERNAH DIINPUT DAN BELUM DISERAHKAN
	if($jumlahcari>0 AND $jc['tanggal_serah']=='0000-00-00'){
		echo"	<div align='center'><br><b>DOKIM TELAH DIINPUT KE APLIKASI PANDAWA</b><br><br>
				<table border='1'>
					<thead>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='100'>NOMOR DOKIM</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>JENIS KELAMIN</span></th>
					<th width='100'>RAK</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[nomor_permohonan]'");
				$mas = mysqli_fetch_array($tampilMas);
					echo"<tr align='center'>
					<td>$mas[nomor_permohonan]</td>
					<td>$mas[nomor_dokim]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>";
				if($mas['jenis_kelamin']=='P'){
					echo"<td>PRIA</td>";
				}else{
					echo"<td>Wanita</td>";
				}
				echo"<td>$mas[nomor_rak]</td>
					</tr></tbody>
					</table></div>";
					
	//JIKA NOMOR PERMOHONAN SUDAH PERNAH DIINPUT DAN SUDAH DISERAHKAN
	}elseif($jumlahcari>0 AND $jc['tanggal_serah']!='0000-00-00'){
		$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[nomor_permohonan]'");
		$mas2    = mysqli_fetch_array($tampilMas2);
		$serah =  mysqli_query($conn,"SELECT * FROM user where nip=$_SESSION[nip]");
		$s    = mysqli_fetch_array($serah);
		echo"
		<div align='center'><br><b>DOKIM TELAH DIINPUT KE APLIKASI PANDAWA DAN TELAH DISERAHKAN</b><br><br>
		<table border='1'>
		<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Dokim</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
		<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_dokim]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
		</table></div>";
	
	//JIKA NOMOR PERMOHONAN BELUM PERNAH DIINPUT	
	}else{
		$detail=mysqli_query($conn_spri,"SELECT * FROM data_wna
										where no_permohonan='$_POST[nomor_permohonan]'");
		$jumlah = mysqli_num_rows($detail);
		$d = mysqli_fetch_array($detail);
		
		//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS SELESAI
		if ($jumlah > 0 AND $d['sub_tahapan']=='SELESAI'){
		echo"
		  <form method=POST enctype='multipart/form-data' action=input.php?module=dokumen&act=input>
		  <input type='hidden' name='nip' value=$_SESSION[nip]>
		  <input type='hidden' name='nomor_permohonan' value=$_POST[nomor_permohonan]>
		  <input type='hidden' name='nomor_dokim' value=$d[dokim_no]>
		  <input type='hidden' name='nomor_paspor' value=$d[no_paspor]>
		  <input type='hidden' name='nama' value='$d[nama_pemohon]'>
		  <input type='hidden' name='kebangsaan' value='$d[kebangsaan]'>
		  <input type='hidden' name='jenis_kelamin' value=$d[jenis_kelamin]>
		  <input type='hidden' name='niora' value=$d[niora]>
		  <input type='hidden' name='tempat_lahir' value='$d[tempat_lahir]'>
		  <input type='hidden' name='tanggal_lahir' value=$d[tgl_lahir]>
		  <input type='hidden' name='jenis_layanan' value='$d[nama_layanan]'>
		  <input type='hidden' name='tanggal_permohonan' value=$d[tanggal_permohonan]>";
		  //<input type='hidden' name='no_hp' value=$d[no_hp]>
			
			$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
			$u = mysqli_fetch_array($user);
			
			echo"<p>
			  <table>
				<tr><td>Nomor Permohonan</td><td><input type='text' value=$d[no_permohonan] size='60' disabled></td></tr>
				<tr><td>Nomor Dokim</td><td><input type='text' name='nomor_dokim' size='60' value=$d[dokim_no] disabled></td></tr>
				<tr><td>Nomor Paspor</td><td><input type='text' name='nomor_paspor' size='60' value=$d[no_paspor] disabled></td></tr>
				<tr><td>Nama Lengkap</td><td><input type='text' name='nama' size='60' value='$d[nama_pemohon]' disabled></td></tr>
				<tr><td>Kebangsaan</td><td><input type='text' name='kebangsaan' size='60' value='$d[kebangsaan]' disabled></td></tr>
				<tr><td>No HP/WA</td><td><input type='text' name='no_hp' size='60' value='$d[no_hp]'></td></tr>
				<tr><td>Jenis Kelamin</td>";
				if($d['jenis_kelamin']=='P'){
					echo"<td><input type='text' name='jenis_kelamin' size='60' value='PRIA' disabled></td></tr>";
				}else{
					echo"<td><input type='text' name='jenis_kelamin' size='60' value='Wanita' disabled></td></tr>";
				}
				echo"<tr><td colspan='2'><hr></td></tr>
				<tr><td>Lokasi Rak Dokumen</td><td><select name='nomor_rak' required>";
													$cekrak = mysqli_query($conn,"SELECT * FROM rak WHERE lokasi='$u[seksi]' ORDER BY nomor_rak");
													while ($rak = mysqli_fetch_array($cekrak)){
														$kuota = mysqli_query($conn,"SELECT kuota FROM rak where nomor_rak='$rak[nomor_rak]'");
														while ($k = mysqli_fetch_array($kuota)){;
															$terpakai = mysqli_query($conn, "SELECT COUNT(nomor_rak) as terpakai FROM arsip_dokim where nomor_rak='$rak[nomor_rak]' and status='aktif'");
															while ($t = mysqli_fetch_array($terpakai)){;
																$sisa = $k['kuota']-$t['terpakai'];
																if ($t['terpakai'] < $k['kuota']){
																	echo"<option value=$rak[nomor_rak]>$rak[nomor_rak] || Sisa Kuota : $sisa</option>";
																}}}}
												   echo"</select></td></tr>
				<tr><td colspan=2 align='right'><input type='submit' name='save' value='Simpan' style='height:50px; width:100px'></td></tr>
			  </table>
			</p>
		  </form>";
		  
		//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS BELUM SELESAI
		}elseif($jumlah > 0 AND $d['sub_tahapan']!='SELESAI'){
			echo"DOKUMEN DENGAN NOMOR PERMOHONAN <b>$d[no_permohonan]</b> ATAS NAMA <b>$d[nama_pemohon]</b> SAAT INI MASIH BERSTATUS <b>$d[sub_tahapan]</b>";
		
		//HALAMAN JIKA TIDAK DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN	
		}else{
			echo"TIDAK DITEMUKAN DOKUMEN DENGAN NOMOR DOKUMEN <b>$_POST[nomor_permohonan]</b>";
		}
	}
}

// HALAMAN SIMPAN DOKUMEN MANUAL
elseif ($_GET['module']=='simpan'){
	
	echo"<h3>INPUT DOKUMEN KEIMIGRASIAN WNA</h3>
      <form method=POST enctype='multipart/form-data' action=input.php?module=dokumen&act=input>
	  <input type='hidden' name='nip' value=$_SESSION[nip]>
        <p>
          <table>
			<tr><td>Nomor Permohonan</td><td><input type='text' name='nomor_permohonan' size='60' required></td></tr>
			<tr><td>Tanggal Permohonan</td><td><input type='date' name='tanggal_permohonan' required></td></tr>
			<tr><td>Niora</td><td><input type='text' name='niora' size='60' required></td></tr>
			<tr><td>Nomor Dokim</td><td><input type='text' name='nomor_dokim' size='60' required></td></tr>
			<tr><td>Jenis Layanan</td><td><input type='text' name='jenis_layanan' size='60' required></td></tr>
			<tr><td>Nomor Paspor</td><td><input type='text' name='nomor_paspor' size='60' required></td></tr>
			<tr><td>Nama Lengkap</td><td><input type='text' name='nama' size='60' required></td></tr>
			<tr><td>Kebangsaan</td><td><input type='text' name='kebangsaan' size='60' required></td></tr>
			<tr><td>No HP/WA</td><td><input type='text' name='no_hp' size='60'></td></tr>
			<tr><td>Tempat Lahir</td><td><input type='text' name='tempat_lahir' size='60' required></td></tr>
			<tr><td>Tanggal Lahir</td><td><input type='date' name='tanggal_lahir' required></td></tr>
			<tr><td>Jenis Kelamin</td><td><select name='jenis_kelamin'>
											<option value='P'>Pria</option>
											<option value='W'>Wanita</option>
										  </select></td></tr>
			<tr><td valign='top'>Keterangan</td><td><textarea rows='60' cols='60' name='keterangan'></textarea></td></tr>
			<tr><td colspan='2'><hr></td></tr>
			<tr><td>Lokasi Rak Dokumen</td><td><select name='nomor_rak' required>";
												$cekrak = mysqli_query($conn,"SELECT * FROM rak ORDER BY nomor_rak");
												while ($rak = mysqli_fetch_array($cekrak)){
													$kuota = mysqli_query($conn,"SELECT kuota FROM rak where nomor_rak='$rak[nomor_rak]'");
													while ($k = mysqli_fetch_array($kuota)){;
														$terpakai = mysqli_query($conn, "SELECT COUNT(nomor_rak) as terpakai FROM arsip_dokim where nomor_rak='$rak[nomor_rak]' and status='aktif'");
														while ($t = mysqli_fetch_array($terpakai)){;
															$sisa = $k['kuota']-$t['terpakai'];
															if ($t['terpakai'] < $k['kuota']){
																echo"<option value=$rak[nomor_rak]>$rak[nomor_rak] || Sisa Kuota : $sisa</option>";
															}}}}
										       echo"</select></td></tr>
			<tr><td colspan=2 align='right'><input type='submit' name='save' value='Simpan' style='height:50px; width:100px'></td></tr>
		  </table>
        </p>
      </form>";
}

// HALAMAN SERAH DOKUMEN
elseif ($_GET['module']=='serah'){
	
	echo"<h3>PENYERAHAN DOKUMEN KEIMIGRASIAN WNA</h3>
	<form method=POST action='view.php?module=hasilpencarian'>
	<table>
	  <tr><td>Kata Kunci </td><td width='15'>:</td><td><input name=kata type=text size=30></td></tr>
	  <tr><td>Cari Berdasarkan </td><td>:</td><td><select name=kategori id=kategori>
		<option value=nomor_permohonan>No Permohonan</option>
		<option value=nama>Nama</option>
	  </select></td></tr>
	  <tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
	";
}

// HALAMAN CARI DOKUMEN SERAH
elseif ($_GET['module']=='hasilpencarian'){
	echo"<h3>PENYERAHAN DOKUMEN KEIMIGRASIAN WNA</h3>";
	
	//HALAMAN CARI DOKUMEN DENGAN NOMOR PERMOHONAN
	if($_POST['kategori']=='nomor_permohonan'){
		$seksi = mysqli_query($conn,"SELECT * FROM user WHERE nip='$_SESSION[nip]'");
		$s = mysqli_fetch_array($seksi);
		$cari   = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN rak b ON a.nomor_rak=b.nomor_rak WHERE a.nomor_permohonan = '$_POST[kata]' AND b.lokasi='$s[seksi]'");
		$jumlah = mysqli_num_rows($cari);
		
		//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN
		if ($jumlah > 0){
			$status = mysqli_query($conn,"SELECT * FROM arsip_dokim WHERE nomor_permohonan = '$_POST[kata]' AND status='Aktif'");
			$jmlst = mysqli_num_rows($status);
			
			//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS AKTIF(TERSIMPAN) - HALAMAN PENYERAHAN ARSIP
			if ($jmlst > 0){
				echo"<table>
					<thead>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='100'>NOMOR DOKIM</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>JENIS KELAMIN</span></th>
					<th width='100'>RAK</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
				$mas = mysqli_fetch_array($tampilMas);
					echo"<tr align='center'>
					<td>$mas[nomor_permohonan]</td>
					<td>$mas[nomor_dokim]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>";
				if($mas['jenis_kelamin']=='P'){
					echo"<td>PRIA</td>";
				}else{
					echo"<td>Wanita</td>";
				}
				echo"<td>$mas[nomor_rak]</td>
					</tr></tbody>
					</table>";
				echo"<hr color=#265180>";
				
				$tanggal=date('Y-m-d H:i:s');
				
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip=$_SESSION[nip]");
				$s    = mysqli_fetch_array($serah);
				
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				echo"<form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=serah>
					 <input type='hidden' name='nomor_permohonan' value=$mas2[nomor_permohonan]>
					 <input type='hidden' name='nomor_rak' value=$mas2[nomor_rak]>
					 <input type='hidden' name='nomor_dokim' value=$mas2[nomor_dokim]>
					 <input type='hidden' name='nama' value='$mas2[nama]'>
					 <input type='hidden' name='nip' value=$_SESSION[nip]>
						<p>
						  <table>
							<tr><td>Diserahkan Kepada &nbsp;</td><td><input type='text' name='penerima' size='60' required></td></tr>
							<tr><td>Petugas Penyerah &nbsp;</td><td><input type='text' name='nip2' size='60' value='$_SESSION[nip] - $s[nama]' disabled></td></tr>
							<tr><td>Tanggal Serah &nbsp;</td><td><input type='date' name='tanggal' value=$tanggal  size='60' disabled></td></tr>
							<tr><td colspan=2 align='right'><input type='submit' name='save' value='SERAHKAN' style='height:50px; width:100px'></td></tr>
						  </table>
						</p>
					  </form>";
				
			//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS INAKTIF (SUDAH DISERAHKAN)	
			} else {
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
				$s    = mysqli_fetch_array($serah);
				echo"
				<div align='center'><br><b>DOKIM TELAH DISERAHKAN</b><br><br>
				<table border='1'>
				<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Dokim</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
				<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_dokim]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
				</table></div>";
			}
			
		//HALAMAN TIDAK JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN	
		} else {
			echo"TIDAK DITEMUKAN DOKUMEN WNA DENGAN NOMOR PERMOHONAN : $_POST[kata]";
			}
	
	//HALAMAN CARI DOKUMEN DENGAN NAMA	
	}elseif($_POST['kategori']=='nama'){
		$seksi = mysqli_query($conn,"SELECT * FROM user WHERE nip='$_SESSION[nip]'");
		$s = mysqli_fetch_array($seksi);
		$cari   = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a LEFT JOIN dokim_wna b ON a.nomor_permohonan=b.nomor_permohonan
																			  LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
														   WHERE b.nama LIKE '%$_POST[kata]%' AND c.lokasi='$s[seksi]'");
		$jumlah = mysqli_num_rows($cari);
		
		//HALAMAN JIKA DITEMUKAN HANYA SATU DOKUMEN DENGAN NAMA
		if ($jumlah == 1){
			$status = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama LIKE '%$_POST[kata]%' AND b.status='Aktif'");
			$jmlst = mysqli_num_rows($status);
			
			//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NAMA DAN BERSTATUS AKTIF (TERSIMPAN) - HALAMAN PENYERAHAN ARSIP
			if ($jmlst > 0){
				echo"
				<table  border='1'>
					<thead>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='100'>NOMOR DOKIM</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>JENIS KELAMIN</span></th>
					<th width='100'>RAK</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a LEFT JOIN dokim_wna b ON a.nomor_permohonan=b.nomor_permohonan
																			  LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
														   WHERE b.nama LIKE '%$_POST[kata]%' AND c.lokasi='$s[seksi]'");
				$mas = mysqli_fetch_array($tampilMas);
					echo"<tr align='center'>
					<td>$mas[nomor_permohonan]</td>
					<td>$mas[nomor_dokim]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>";
				if($mas['jenis_kelamin']=='P'){
					echo"<td>PRIA</td>";
				}else{
					echo"<td>Wanita</td>";
				}
				echo"<td>$mas[nomor_rak]</td>
					</tr>
				</tbody>
				</table>";
				echo"<hr color=#265180>";
				
				$tanggal=date('Y-m-d H:i:s');
				
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip=$_SESSION[nip]");
				$s    = mysqli_fetch_array($serah);
				
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama LIKE '%$_POST[kata]%'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				echo"<form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=serah>
					 <input type='hidden' name='nomor_permohonan' value=$mas2[nomor_permohonan]>
					 <input type='hidden' name='nomor_rak' value=$mas2[nomor_rak]>
					 <input type='hidden' name='nomor_dokim' value=$mas2[nomor_dokim]>
					 <input type='hidden' name='nama' value='$mas2[nama]'>
					 <input type='hidden' name='nip' value=$_SESSION[nip]>
						<p>
						  <table>
							<tr><td>Diserahkan Kepada &nbsp;</td><td><input type='text' name='penerima' size='60' required></td></tr>
							<tr><td>Petugas Penyerah &nbsp;</td><td><input type='text' name='nip2' size='60' value='$_SESSION[nip] - $s[nama]' disabled></td></tr>
							<tr><td>Tanggal Serah &nbsp;</td><td><input type='date' name='tanggal' value=$tanggal  size='60' disabled></td></tr>
							<tr><td colspan=2 align='right'><input type='submit' name='save' value='SERAHKAN' style='height:50px; width:100px'></td></tr>
						  </table>
						</p>
					  </form>";
			
			//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NAMA DAN BERSTATUS INAKTIF (SUDAH SERAH)
			} else {
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama = '$_POST[kata]'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
				$s    = mysqli_fetch_array($serah);
				echo"
				<div align='center'><br><b>DOKIM TELAH DISERAHKAN</b><br><br>
				<table border='1'>
				<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Dokim</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
				<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_dokim]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
				</table></div>";
			}
		
		//HALAMAN JIKA DITEMUKAN LEBIH DARI SATU DOKUMEN DENGAN NAMA		
		} elseif ($jumlah > 1){
				echo"<table border='1'>
					<thead>
					<tr><td colspan=6>Ditemukan Dokim Dengan Nama <b>$_POST[kata]</b> Sebanyak <b>$jumlah</b> buah</td></tr>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='100'>NOMOR DOKIM</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>JENIS KELAMIN</span></th>
					<th width='100'>STATUS</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a LEFT JOIN dokim_wna b ON a.nomor_permohonan=b.nomor_permohonan
																			  LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
														   WHERE b.nama LIKE '%$_POST[kata]%' AND c.lokasi='$s[seksi]'
														   ORDER by a.status");
				while($mas = mysqli_fetch_array($tampilMas)){
					echo"<tr align='center'>";
					if($mas['status']=='Aktif'){
						echo"<td><a href=?module=seraharsip&nomor_permohonan=$mas[nomor_permohonan]>$mas[nomor_permohonan]</a></td>";
					}else{
						echo"<td>$mas[nomor_permohonan]</td>";
					}
					echo"<td>$mas[nomor_dokim]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>";
				if($mas['jenis_kelamin']=='P'){
					echo"<td>PRIA</td>";
				}else{
					echo"<td>Wanita</td>";
				}
					
					if ($mas['status']=='Aktif'){
						echo"<td bgcolor='red'><font color='white'><b>TERSIMPAN DI RAK $mas[nomor_rak]</b></font></td>";
					}else{
						echo"<td bgcolor='green'><font color='white'><b>SUDAH DISERAHKAN</b></font></td>";
					}
					echo"</tr>
				</tbody>";
				}
				echo"</table>";
		}
		
		//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NAMA DAN BERSTATUS AKTIF (TERSIMPAN)		
		else {
			echo"TIDAK DITEMUKAN DOKUMEN WNA DENGAN NAMA : $_POST[kata]";
		}
	}
}

// HALAMAN PENYERAHAN ARSIP
elseif ($_GET['module']=='seraharsip'){
	echo"<h3>PENYERAHAN DOKUMEN KEIMIGRASIAN WNA</h3>";
	$tampilMas = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_GET[nomor_permohonan]'");
	while($mas = mysqli_fetch_array($tampilMas)){
		echo"<table border='1'>
					<thead>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='100'>NOMOR DOKIM</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>JENIS KELAMIN</span></th>
					<th width='100'>RAK</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_GET[nomor_permohonan]'");
				while($mas = mysqli_fetch_array($tampilMas)){
					echo"<tr align='center'>
					<td>$mas[nomor_permohonan]</td>
					<td>$mas[nomor_dokim]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>";
				if($mas['jenis_kelamin']=='P'){
					echo"<td>PRIA</td>";
				}else{
					echo"<td>Wanita</td>";
				}
				echo"<td>$mas[nomor_rak]</td>
					</tr>
				</tbody>
				</table>";
				}
				echo"<hr color=#265180>";
				
				$tanggal=date('Y-m-d H:i:s');
				
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip=$_SESSION[nip]");
				$s    = mysqli_fetch_array($serah);
				
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_GET[nomor_permohonan]'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				echo"<form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=serah>
					 <input type='hidden' name='nomor_permohonan' value=$mas2[nomor_permohonan]>
					 <input type='hidden' name='nomor_rak' value=$mas2[nomor_rak]>
					 <input type='hidden' name='nomor_dokim' value=$mas2[nomor_dokim]>
					 <input type='hidden' name='nama' value='$mas2[nama]'>
					 <input type='hidden' name='nip' value=$_SESSION[nip]>
						<p>
						  <table>
							<tr><td>Diserahkan Kepada &nbsp;</td><td><input type='text' name='penerima' size='60' required></td></tr>
							<tr><td>Petugas Penyerah &nbsp;</td><td><input type='text' name='nip2' size='60' value='$_SESSION[nip] - $s[nama]' disabled></td></tr>
							<tr><td>Tanggal Serah &nbsp;</td><td><input type='date' name='tanggal' value=$tanggal  size='60' disabled></td></tr>
							<tr><td colspan=2 align='right'><input type='submit' name='save' value='SERAHKAN' style='height:50px; width:100px'></td></tr>
						  </table>
						</p>
					  </form>";
				
	}
}

// HALAMAN DOKIM TERSIMPAN
elseif ($_GET['module']=='dokimsimpan'){
	echo"<h3>DOKIM TERSIMPAN DAN DOKIM TELAH SERAH</h3>";
	echo"<div align='center'><table border='0'><tr><td align='center' bgcolor='#b5e2ff'><b>DOKIM TERSIMPAN</b></td>
										<td>&nbsp&nbsp</td>
										<td align='center'><a href=view.php?module=dokimserah>DOKIM TELAH SERAH</a></td></tr>
							 </table></div>";
	
	echo"<table border='1'>
    <thead bgcolor='yellow'>
      <tr align='center'>
	    <th width='50'>NO</span></th>
        <th width='100'>NOMOR RAK</span></th>
		<th width='100'>NOMOR PERMOHONAN</span></th>
        <th width='100'>NOMOR DOKIM</span></th>
		<th width='100'>NOMOR PASPOR</span></th>
		<th width='400'>NAMA</span></th>
		<th width='100'>KEBANGSAAN</span></th>
		<th width='100'>AKSI</span></th>
      </tr>
    </thead>
    <tbody>";
	$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	
	$halaman = 10;
	$page = isset($_GET["halaman"])?(int)$_GET["halaman"] : 1;
	$mulai = ($page>1)?($page * $halaman) - $halaman : 0;
	$sebelum        = $page - 1;
	$setelah        = $page + 1;
	$result = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN rak b ON a.nomor_rak = b.nomor_rak where a.status='Aktif' AND b.lokasi='$u[seksi]'");
	$total = mysqli_num_rows($result);
	$pages = ceil($total/$halaman);
	$tampilMas = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan
																			 LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									WHERE a.status='Aktif' AND c.lokasi='$u[seksi]'  order by a.nomor_rak LIMIT $mulai, $halaman");
	$no = $mulai+1;
                while($mas = mysqli_fetch_array($tampilMas)){
	echo "<tr align='center'>
			  <td>$no</td>
			  <td>$mas[nomor_rak]</td>
			  <td><a href=?module=detildokimsimpan&nomor_permohonan=$mas[nomor_permohonan]>$mas[nomor_permohonan]</a></td>
			  <td>$mas[nomor_dokim]</td>
			  <td>$mas[nomor_paspor]</td>
			  <td>$mas[nama]</td>
			  <td>$mas[kebangsaan]</td>
			  <td><a href=input.php?module=arsip&act=hapus&nomor_permohonan=$mas[nomor_permohonan]&nip=$_SESSION[nip]><button class=buttonhapuskecil><img src='images/trash.png' height=15px/></button></a></td>
		   </tr>";

		$no++;
				}
	echo"</table><br>";
	
	//paging
	 echo"<div style='font-weight:bold;' align='center'>";
		$previous = $page - 1;
		$next = $page + 1;	
           /* for ($i=1; $i<=$pages ; $i++){
            echo"<a href=?module=lihatdatapaspor&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
            }*/
		if($page-1 < 5){
			for ($i=1; $i<=$page-1 ; $i++){
				echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			echo"<a href=?module=dokimsimpan&halaman=1; style='text-decoration:none'>   << First |</a>";
			if($pages-$page < 6){
				for ($i=$pages-9; $i<=$page-1 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
					}
			}else {
				for ($i=$page-4; $i<=$page-1 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
		}
		
		echo"<b> $i</b>";
		
		if($pages-$page < 6){
			for ($i=$page+1; $i<=$pages ; $i++){
				echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			if($page-1 < 5){
				for ($i=$page+1; $i<=10 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			} else {
				for ($i=$page+1; $i<=$page+5 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
			echo"<a href=?module=dokimsimpan&halaman=$pages; style='text-decoration:none'>   | Last >></a>";
		}
    echo"<br></div><br>";
}

// Halaman Dokim DETIL DOKIM TERSIMPAN
elseif ($_GET['module']=='detildokimsimpan'){
	$detail=mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan
									where a.nomor_permohonan='$_GET[nomor_permohonan]'");
	$d=mysqli_fetch_array($detail);
	$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	echo"<h3>EDIT LOKASI RAK DOKUMEN KEIMIGRASIAN WNA</h3>
      <form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=edit>
	  <input type='hidden' name='nip' value=$_SESSION[nip]>
	  <input type='hidden' name='nomor_permohonan' value=$d[nomor_permohonan]>
	  <input type='hidden' name='nomor_rak_lama' value=$d[nomor_rak]>
	  <input type='hidden' name='nama' value='$d[nama]'>
	  <input type='hidden' name='nomor_paspor' value=$d[nomor_paspor]>
	  <input type='hidden' name='jenis_kelamin' value=$d[jenis_kelamin]>
	  <input type='hidden' name='kebangsaan' value='$d[kebangsaan]'>
        <p>
          <table>
			<tr><td>Nomor Permohonan</td><td><input type='text' value=$d[nomor_permohonan] size='60' disabled></td></tr>
			<tr><td>Nomor Dokim</td><td><input type='text' name='nomor_dokim' size='60' value=$d[nomor_dokim] disabled></td></tr>
			<tr><td>Nomor Paspor</td><td><input type='text' name='nomor_paspor' size='60' value=$d[nomor_paspor] disabled></td></tr>
			<tr><td>Nama Lengkap</td><td><input type='text' name='nama' size='60' value='$d[nama]' disabled></td></tr>
			<tr><td>Kebangsaan</td><td><input type='text' name='kebangsaan' size='60' value='$d[kebangsaan]' disabled></td></tr>
			<tr><td>No HP/WA</td><td><input type='text' name='kebangsaan' size='60' value='$d[no_hp]' disabled></td></tr>
			<tr><td>Jenis Kelamin</td><td>";
	if($d['jenis_kelamin']=='P'){
			echo"<input type='text' name='jenis_kelamin' size='60' value='PRIA' disabled></td></tr>";
	}else{
			echo"<input type='text' name='jenis_kelamin' size='60' value='Wanita' disabled></td></tr>";
	}
	echo"   <tr><td colspan='2'><hr></td></tr>
			<tr><td>Lokasi Rak Dokumen Saat Ini</td><td>&nbsp<b>$d[nomor_rak]</b></td></tr>
			<tr><td>Ganti Lokasi Rak</td><td><select name='nomor_rak' REQUIRED>";
												$cekrak = mysqli_query($conn,"SELECT * FROM rak where nomor_rak != '$d[nomor_rak]' AND lokasi='$u[seksi]' ORDER BY nomor_rak");
												while ($rak = mysqli_fetch_array($cekrak)){
													$kuota = mysqli_query($conn,"SELECT kuota FROM rak where nomor_rak='$rak[nomor_rak]'");
													while ($k = mysqli_fetch_array($kuota)){;
														$terpakai = mysqli_query($conn, "SELECT COUNT(nomor_rak) as terpakai FROM arsip_dokim where nomor_rak='$rak[nomor_rak]' and status='aktif'");
														while ($t = mysqli_fetch_array($terpakai)){;
															$sisa = $k['kuota']-$t['terpakai'];
															if ($t['terpakai'] < $k['kuota']){
																echo"<option value=$rak[nomor_rak]>$rak[nomor_rak] || Sisa Kuota : $sisa</option>";
															}}}}
										       echo"</select></td></tr>
			<tr><td colspan=2 align='right'><input type='submit' name='save' value='Simpan' style='height:50px; width:100px'></td></tr>
		  </table>
        </p>
      </form>";
}

// HALAMAN DOKIM SERAH
elseif ($_GET['module']=='dokimserah'){
	echo"<h3>DOKIM TERSIMPAN DAN DOKIM TELAH SERAH</h3>";
	echo"<div align='center'><table><tr><td align='center'><a href=view.php?module=dokimsimpan>DOKIM TERSIMPAN</a></td>
										<td>&nbsp&nbsp</td>
										<td align='center' bgcolor='#b5e2ff'><b>DOKIM TELAH SERAH</b></td></tr>
							 </table></div>";
	
	echo"<form method=POST action='view.php?module=hasilpencariandokimserah'>
	  <table>
	  <tr><td colspan='3' align='left'>Pencarian Data Dokim Serah<br><br></td></tr>
	  <tr><td>Kata Kunci </td><td width='15'>:</td><td><input name=kata placeholder='Pencarian' type=text size=30></td></tr>
	  <tr><td>Cari Berdasarkan </td><td>:</td><td><select name=kategori id=kategori>
		<option value=nomor_permohonan>No Permohonan</option>
		<option value=nama>Nama</option>
	  </select></td></tr>
		<tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
      <hr color=#265180>";
	
	echo"<table border='1'>
    <thead bgcolor='yellow'>
      <tr align='center'>
	    <th width='50'>NO</span></th>
		<th width='100'>NOMOR PERMOHONAN</span></th>
        <th width='100'>NOMOR DOKIM</span></th>
		<th width='400'>NAMA</span></th>
		<th width='100'>TANGGAL SERAH</span></th>
		<th width='100'>DISERAHKAN KEPADA</span></th>
		<th width='100'>PETUGAS SERAH</span></th>
      </tr>
    </thead>
    <tbody>";
	
	$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	
	$halaman = 10;
	$page = isset($_GET["halaman"])?(int)$_GET["halaman"] : 1;
	$mulai = ($page>1)?($page * $halaman) - $halaman : 0;
	$sebelum        = $page - 1;
	$setelah        = $page + 1;
	$result = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN rak b ON a.nomor_rak=b.nomor_rak WHERE a.status='Serah' AND b.lokasi='$u[seksi]'");
	$total = mysqli_num_rows($result);
	$pages = ceil($total/$halaman);
	$tampilMas = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan
																			LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									where a.status='Serah' AND c.lokasi='$u[seksi]' order by a.tanggal_serah DESC LIMIT $mulai, $halaman");
	$no = $mulai+1;
                while($mas = mysqli_fetch_array($tampilMas)){
	echo "<tr align='center'>
			  <td>$no</td>
			  <td>$mas[nomor_permohonan]</td>
			  <td>$mas[nomor_dokim]</td>
			  <td>$mas[nama]</td>
			  <td>$mas[tanggal_serah]</td>
			  <td>$mas[penerima]</td>";
			  $petugas = mysqli_query($conn,"SELECT a.*, b.* FROM user a LEFT JOIN arsip_dokim b on a.nip = b.nip_serah
									where a.nip = $mas[nip_serah]");
			  $p    = mysqli_fetch_array($petugas);
			  echo"<td>$mas[nip_serah] - $p[nama]</td>
		   </tr>";

		$no++;
				}
	echo"</table><br>";
	
	//paging
	 echo"<div style='font-weight:bold;' align='center'>";
		$previous = $page - 1;
		$next = $page + 1;	
           /* for ($i=1; $i<=$pages ; $i++){
            echo"<a href=?module=lihatdatapaspor&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
            }*/
		if($page-1 < 5){
			for ($i=1; $i<=$page-1 ; $i++){
				echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			echo"<a href=?module=dokimsimpan&halaman=1; style='text-decoration:none'>   << First |</a>";
			if($pages-$page < 6){
				for ($i=$pages-9; $i<=$page-1 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
					}
			}else {
				for ($i=$page-4; $i<=$page-1 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
		}
		
		echo"<b> $i</b>";
		
		if($pages-$page < 6){
			for ($i=$page+1; $i<=$pages ; $i++){
				echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			if($page-1 < 5){
				for ($i=$page+1; $i<=10 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			} else {
				for ($i=$page+1; $i<=$page+5 ; $i++){
					echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
			echo"<a href=?module=dokimsimpan&halaman=$pages; style='text-decoration:none'>   | Last >></a>";
		}
    echo"<br></div><br>";
}

//HALAMAN PENCARIAN DOKIM SUDAH SERAH
elseif ($_GET['module']=='hasilpencariandokimserah'){
	echo"<h3>DOKIM TERSIMPAN DAN DOKIM TELAH SERAH</h3>";
	echo"<div align='center'><table><tr><td align='center'><a href=view.php?module=dokimsimpan>DOKIM TERSIMPAN</a>&nbsp;</td>
										<td align='center' bgcolor='#b5e2ff'>&nbsp;<b>DOKIM TELAH SERAH</b></td></tr>
							 </table></div>";
	
	echo"<form method=POST action='?module=hasilpencariandokimserah'>
	  <table>
	  <tr><td colspan='3' align='left'>Pencarian Data Dokim Serah<br><br></td></tr>
	  <tr><td>Kata Kunci </td><td width='15'>:</td><td><input name=kata placeholder='Pencarian' value='$_POST[kata]' type=text size=30></td></tr>
	  <tr><td>Cari Berdasarkan </td><td>:</td><td><select name=kategori id=kategori>
		<option value=nomor_permohonan>No Permohonan</option>
		<option value=nama>Nama</option>
	  </select></td></tr>
		<tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
      <hr color=#265180>";
	
	//PENCARIAN DENGAN NOMOR PERMOHONAN	
	if($_POST['kategori']=='nomor_permohonan'){
		$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
		$u = mysqli_fetch_array($user);
		$status = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN rak b ON a.nomor_rak=b.nomor_rak
													  WHERE a.nomor_permohonan = '$_POST[kata]' AND a.status='Serah' AND b.lokasi='$u[seksi]'");
		$jmlst = mysqli_num_rows($status);
		
		//PENCARIAN DENGAN NOMOR PERMOHONAN DITEMUKAN 
		if ($jmlst > 0){
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
			$mas2    = mysqli_fetch_array($tampilMas2);
			$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
			$s    = mysqli_fetch_array($serah);
			echo"
			<div align='center'>
			<table border='1'>
			<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Dokim</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
			<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_dokim]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
			</table></div>";
		
		//PENCARIAN DENGAN NOMOR PERMOHONAN TIDAK DITEMUKAN 
		}else {
			echo"TIDAK DITEMUKAN DOKIM WNA DENGAN NOMOR PERMOHONAN :<b>$_POST[kata]</b><br><br>";
		}
	
	//PENCARIAN DENGAN NAMA
	}elseif($_POST['kategori']=='nama'){
		$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
		$u = mysqli_fetch_array($user);
		$status = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a LEFT JOIN dokim_wna b on a.nomor_permohonan = b.nomor_permohonan
																			LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									  WHERE b.nama LIKE '%$_POST[kata]%' AND a.status='Serah' AND c.lokasi='$u[seksi]'");
		$jmlst = mysqli_num_rows($status);
		
		//PENCARIAN DENGAN NAMA DITEMUKAN SATU DOKIM
		if ($jmlst == 1){
			
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama LIKE '%$_POST[kata]%' AND b.status='Serah' ORDER by b.status");
			$mas2 = mysqli_fetch_array($tampilMas2);
			$serah =  mysqli_query($conn,"SELECT * FROM user where nip=$mas2[nip_serah]");
			$s    = mysqli_fetch_array($serah);
			echo"
			<div align='center'>
			<table border='1'>
			<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Dokim</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
			<tr align='center'>	<td>$mas2[nomor_permohonan]</td>
								<td>$mas2[nomor_dokim]</td>
								<td>$mas2[nama]</td>
								<td>$mas2[tanggal_serah]</td>
								<td>$mas2[penerima]</td>
								<td>$mas2[nip_serah] - $s[nama]</td></tr>
			</table></div>";
		
		//PENCARIAN DENGAN NAMA DITEMUKAN LEBIH DARI SATU DOKIM		
		}elseif ($jmlst > 1){
			echo"<table border='1'>
				<thead>
				<tr><td colspan=6>Ditemukan Dokim Dengan Nama <b>$_POST[kata]</b> Sebanyak <b>$jmlst</b> Data</td></tr>
				<tr bgcolor='yellow'>
				<th width='200'>Nomor Permohonan</span></th>
				<th width='100'>Nomor Dokim</span></th>
				<th width='400'>Nama</span></th>
				<th width='100'>Tanggal Penyerahan</span></th>
				<th width='100'>Diserahkan Kepada</span></th>
				<th width='100'>Petugas Serah</span></th>
			  </tr></thead>
				<tbody>";
			$serah =  mysqli_query($conn,"SELECT * FROM user where nip=$_SESSION[nip]");
			$s    = mysqli_fetch_array($serah);
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wna a LEFT JOIN arsip_dokim b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama LIKE '%$_POST[kata]%' AND b.status='Serah' ORDER by b.status");
			while($mas2 = mysqli_fetch_array($tampilMas2)){
				echo"<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_dokim]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
					 </tbody>";
			}
			echo"</table>";
		
		//PENCARIAN DENGAN NAMA TIDAK DITEMUKAN	
		}else {
		echo"TIDAK DITEMUKAN DOKIM WNA DENGAN NAMA : $_POST[kata]<br><br>";
		}
	}
}

//HALAMAN EDIT USER
elseif ($_GET['module']=='user'){
	echo"<h3>USER</h3>";

	$user = mysqli_query($conn,"SELECT * FROM user where nip='$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	
	echo"<form method=POST enctype='multipart/form-data' action=input.php?module=user&act=edit>
		 <input type='hidden' name=nip value='$u[nip]'>
			<table border='0' width='100%'>
				<tr><td>NIP</td><td>:</td><td><input type='text' value='$u[nip]' size='50%' disabled></td></tr>
				<tr><td>NAMA</td><td>:</td><td><input type='text' value='$u[nama]' size='50%' disabled></td></tr>
				<tr><td>PASSWORD</td><td>:</td><td><input type='password' name='password' size='50%' required></td></tr>
				<tr><td colspan='3' align='right'><input type='submit' name='save' value='Simpan'></td></tr></table>
		 </form>";
}

// HALAMAN EXPORT ARSIP
elseif ($_GET['module']=='exportxl'){
	echo"<h3>EXPORT DATA PENYERAHAN DOKIM WNA KE EXCEL</h3>";
	echo"<form method=POST action='export_excel.php'>
	  <table>
	  <tr valign='center'><th>Masukkan Tanggal Penyerahan :</th></tr>
	  <tr><td><input type='date' name='tanggal_awal' value=CURRENT_DATE()> Sampai Dengan Tanggal <input type='date' name='tanggal_akhir' value=CURRENT_DATE()></td></tr>
		<tr align='right'><td><input type=submit value='Export to Excel'></td></tr></table>
      </form>";
}

// HALAMAN KIRIM ARSIP
elseif ($_GET['module']=='kirimarsip'){
	echo"<h3>KIRIM DOKIM WNA KE ARSIP</h3>";
	echo"<form method=POST action='?module=cekkirimarsip'>
	  <table>
	  <tr valign='center'><th>Masukkan Tanggal Penyerahan :</th></tr>
	  <tr><td><input type='date' name='tanggal_awal' value=CURRENT_DATE()> Sampai Dengan Tanggal <input type='date' name='tanggal_akhir' value=CURRENT_DATE()></td></tr>
		<tr align='right'><td><input type=submit value='Open'></td></tr></table>
      </form>";
}

// HALAMAN CEK KIRIM ARSIP
elseif ($_GET['module']=='cekkirimarsip'){
	echo"<h3>KIRIM DOKIM WNA KE ARSIP</h3>";
	
	?>
					
		<script language="JavaScript">
			function toggle(source) {
			  checkboxes = document.getElementsByName('foo[ ]');
			  for(var i=0, n=checkboxes.length;i<n;i++) {
				checkboxes[i].checked = source.checked;
			  }
			}
		</script>
		
	<?php
	
	echo"<table border='1'>
		<thead bgcolor='yellow'>
		  <tr align='center'>
			<th></span><input type='checkbox' onClick='toggle(this)' /></th>
			<th width='50'>NO</th>
			<th width='100'>NOMOR PERMOHONAN</span></th>
			<th width='100'>NOMOR DOKIM</span></th>
			<th width='400'>NAMA</span></th>
			<th width='100'>TANGGAL SERAH</span></th>
			<th width='100'>STATUS PENGIRIMAN ARSIP</span></th>
		  </tr>
		</thead>
		<tbody>";
	
	echo"<form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=kirimcandi>";
	$seksi = mysqli_query($conn,"SELECT * FROM user WHERE nip='$_SESSION[nip]'");
	$ss = mysqli_fetch_array($seksi);
	$status = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_dokim a
												 LEFT JOIN dokim_wna b ON a.nomor_permohonan=b.nomor_permohonan
												 LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
												 WHERE a.status='Serah' AND (a.tanggal_serah>='$_POST[tanggal_awal]' AND a.tanggal_serah<='$_POST[tanggal_akhir]') AND c.lokasi='$ss[seksi]'");
	$st = mysqli_num_rows($status);
	$no=1;
	echo"<tr><td colspan='8'><i>Jumlah Dokim Berstatus Sudah Serah Pada Seksi $ss[seksi] Pada Tanggal $_POST[tanggal_awal] s/d $_POST[tanggal_akhir]</i> : <b>$st</b></td></tr>";
	while($s = mysqli_fetch_array($status)){
		if($s['tanggal_arsip']!='0000-00-00'){
			echo "<tr  align='center'>
					<td><input type='checkbox' name='' value='$s[nomor_permohonan]' disabled>
					<td>$no</td>
					<td>$s[nomor_permohonan]</td>
					<td>$s[nomor_dokim]</td>
					<td>$s[nama]</td>
					<td>$s[tanggal_serah]</td>
					<td bgcolor='green'><font color='white'>SUDAH DIKIRIM</font></td>
				</tr>";
			$no++;
		}else{
			echo "<tr  align='center'>
					<input type='hidden' name='niora[ ]' value='$s[niora]'>
					<input type='hidden' name='nomor_dokim[ ]' value='$s[nomor_dokim]'>
					<input type='hidden' name='nomor_paspor[ ]' value='$s[nomor_paspor]'>
					<input type='hidden' name='nama[ ]' value='$s[nama]'>
					<input type='hidden' name='kebangsaan[ ]' value='$s[kebangsaan]'>
					<input type='hidden' name='jenis_kelamin[ ]' value='$s[jenis_kelamin]'>
					<input type='hidden' name='tempat_lahir[ ]' value='$s[tempat_lahir]'>
					<input type='hidden' name='tanggal_lahir[ ]' value='$s[tanggal_lahir]'>
					<input type='hidden' name='jenis_layanan[ ]' value='$s[jenis_layanan]'>
					<input type='hidden' name='tanggal_permohonan[ ]' value='$s[tanggal_permohonan]'>
					<input type='hidden' name='nip[ ]' value='$_SESSION[nip]'>
					
					<td><input type='checkbox' name='foo[ ]' value='$s[nomor_permohonan]'>
					<td>$no</td>
					<td>$s[nomor_permohonan]</td>
					<td>$s[nomor_dokim]</td>
					<td>$s[nama]</td>
					<td>$s[tanggal_serah]</td>
					<td bgcolor='red'><font color='white'>BELUM DIKIRIM</font></td>
				</tr>";
			$no++;
		}
	}
		echo"</table>
		
			 <div align='right'><input type='submit' name='save' value='KIRIM ARSIP' style='height:50px; width:100px'></div><br><br></form>";

}

//jika modul tidak ditemukan
else{
  echo "<p align=center><b>MODUL BELUM ADA</b></p>";
}
?>