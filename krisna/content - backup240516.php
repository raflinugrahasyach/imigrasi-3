<?php

include_once 'app/config.php';
//$conn=mysqli_connect("localhost","root","","pandawa");
// Check connection
/*if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/

//HALAMAN HOME (DASHBOARD)
if ($_GET['module']=='home'){
	$user = mysqli_query ($conn,"SELECT * FROM user where nip = '$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	echo "<h1>DASHBOARD</h1>
			<h3>JUMLAH PASPOR YANG DIARSIPKAN 7 HARI TERAKHIR</h3>";
	
	
	echo"<iframe src='app/chart1.php' height='400px' width='700px'></iframe>
			<br><br><hr color=#265180><br>
	 
			<h3>JUMLAH PASPOR YANG DISERAHKAN DALAM 7 HARI TERAKHIR</h3>
			<iframe src='app/chart2.php' height='400px' width='700px'></iframe>";
	 
	}

// HALAMAN SCAN NO DOKIM SIMPAN
elseif ($_GET['module']=='carisimpan'){
	echo"<h3>PENYIMPANAN PASPOR</h3>
	<form method=POST action='view.php?module=hasilcarisimpan'>
	<table>
	   <tr align='right'><td colspan=3 align='left'><i>Masukkan Nomor Permohonan</i></td></tr>
	  <tr><td><b>NOMOR PERMOHONAN</b></td><td width='15'>:</td><td><input name=nomor_permohonan type=text size=50></td></tr>
	  <tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
	";
	?>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    
    
    <!-- jika ada session sukses maka tampilkan sweet alert dengan pesan yang telah di set
    di dalam session sukses  -->
    <?php if(@$_SESSION['sukses']){ ?>
        <script>
            swal("SUKSES", "DOKUMEN DENGAN NOMOR PERMOHONAN <font color='red'><b><?php echo $_SESSION['nomor_permohonan']; ?></b></font> DISIMPAN PADA RAK <font color='red'><b><?php echo $_SESSION['nomor_rak']; ?></b></font>", "success");
        </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
    <?php unset($_SESSION['sukses']); }
}

// HALAMAN PENYIMPANAN OTOMATIS
elseif ($_GET['module']=='hasilcarisimpan'){
	echo"<h3>PENYIMPANAN PASPOR</h3>";
	
	$cari=mysqli_query($conn,"SELECT * FROM arsip_paspor
									where nomor_permohonan='$_POST[nomor_permohonan]'");
	$jumlahcari = mysqli_num_rows($cari);
	$jc = mysqli_fetch_array($cari);
	
	//JIKA NOMOR PERMOHONAN SUDAH PERNAH DIINPUT DAN BELUM DISERAHKAN
	if($jumlahcari>0 AND $jc['tanggal_serah']=='0000-00-00'){
		echo"	<div align='center'><br><b>DOKIM TELAH DIINPUT KE APLIKASI KRISNA</b><br><br>
				<table border='1'>
					<thead>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>TANGGAL LAHIR</span></th>
					<th width='100'>RAK</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[nomor_permohonan]'");
				$mas = mysqli_fetch_array($tampilMas);
					echo"<tr align='center'>
					<td>$mas[nomor_permohonan]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>
					<td>$mas[tanggal_lahir]</td>
					<td>$mas[nomor_rak]</td>
					</tr></tbody>
					</table></div>";
					
	//JIKA NOMOR PERMOHONAN SUDAH PERNAH DIINPUT DAN SUDAH DISERAHKAN
	}elseif($jumlahcari>0 AND $jc['tanggal_serah']!='0000-00-00'){
		$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wni a LEFT JOIN arsip_paspor b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[nomor_permohonan]'");
		$mas2    = mysqli_fetch_array($tampilMas2);
		$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
		$s    = mysqli_fetch_array($serah);
		echo"
		<div align='center'><br><b>DOKIM TELAH DIINPUT KE APLIKASI KRISNA DAN TELAH DISERAHKAN</b><br><br>
		<table border='1'>
		<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Paspor</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
		<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_paspor]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
		</table></div>";
	
	//JIKA NOMOR PERMOHONAN BELUM PERNAH DIINPUT	
	}else{
		$detail=mysqli_query($conn_spri,"SELECT * FROM datapaspor
										where nomor_permohonan='$_POST[nomor_permohonan]'");
		$jumlah = mysqli_num_rows($detail);
		$d = mysqli_fetch_array($detail);
		
		//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS SELESAI
		//if ($jumlah > 0 AND ($d['sub_tahapan']=='SELESAI' OR $d['sub_tahapan'] == 'PEMINDAIAN DOKUMEN SELESAI')){
		if ($jumlah > 0 AND ($d['tahapan']=='SELESAI' OR $d['tahapan']=='PENYERAHAN')){
		$seksi=mysqli_query($conn,"SELECT * FROM user WHERE nip='$_SESSION[nip]'");
		$sk=mysqli_fetch_array($seksi);
		echo"
		  <form method=POST enctype='multipart/form-data' action=input.php?module=dokumen&act=input>
		  <input type='hidden' name='nip' value=$_SESSION[nip]>
		  <input type='hidden' name='seksi' value=$sk[seksi]>
		  <input type='hidden' name='nomor_permohonan' value=$_POST[nomor_permohonan]>
		  <input type='hidden' name='nomor_paspor' value=$d[no_paspor]>
		  <input type='hidden' name='jenis_paspor' value=$d[jenis_paspor]>
		  <input type='hidden' name='tanggal_permohonan' value=$d[tanggal_permohonan]>
		  <input type='hidden' name='nama' value='$d[nama_lengkap]'>
		  <input type='hidden' name='jenis_kelamin' value=$d[jenis_kelamin]>
		  <input type='hidden' name='tempat_lahir' value='$d[tempat_lahir]'>
		  <input type='hidden' name='tanggal_lahir' value=$d[tanggal_lahir]>
		  <input type='hidden' name='no_hp' value=$d[no_hp]>
		  <input type='hidden' name='email' value=$d[email]>";
			
			$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
			$u = mysqli_fetch_array($user);
			
			echo"<p>
			  <table>
				<tr><td>Nomor Permohonan</td><td><input type='text' value=$d[nomor_permohonan] size='60' disabled></td></tr>
				<tr><td>Nomor Paspor</td><td><input type='text' name='nomor_paspor' size='60' value=$d[no_paspor] disabled></td></tr>
				<tr><td>Nama Lengkap</td><td><input type='text' name='nama' size='60' value='$d[nama_lengkap]' disabled></td></tr>
				<tr><td>Tempat / Tgl Lahir</td><td><input type='text' name='nama' size='60' value='$d[tempat_lahir] / $d[tanggal_lahir]' disabled></td></tr>
				<tr><td>No HP/WA</td><td><input type='text' name='no_hp' value='$d[no_hp]' size='60'></td></tr>
				<tr><td>Email</td><td><input type='text' name='email' size='60' value='$d[email]' disabled></td></tr>
				<tr><td>Jenis Kelamin</td>";
				if($d['jenis_kelamin']=='P'){
					echo"<td><input type='text' name='jenis_kelamin' size='60' value='Perempuan' disabled></td></tr>";
				}else{
					echo"<td><input type='text' name='jenis_kelamin' size='60' value='Laki-Laki' disabled></td></tr>";
				}
				echo"<tr><td colspan='2'><hr></td></tr>
				<tr><td valign='top'>Catatan Petugas</td><td><input type='text' name='keterangan' size='60'></td></tr>
				<tr><td>Lokasi Rak Dokumen</td><td><select name='nomor_rak' required>";
													$cekrak = mysqli_query($conn,"SELECT * FROM rak WHERE lokasi='$u[seksi]' ORDER BY nomor_rak");
													while ($rak = mysqli_fetch_array($cekrak)){
														$kuota = mysqli_query($conn,"SELECT kuota FROM rak where nomor_rak='$rak[nomor_rak]'");
														while ($k = mysqli_fetch_array($kuota)){;
															$terpakai = mysqli_query($conn, "SELECT COUNT(nomor_rak) as terpakai FROM arsip_paspor where nomor_rak='$rak[nomor_rak]' and status='Aktif'");
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
		//}elseif($jumlah > 0 AND ($d['sub_tahapan']!='SELESAI' OR $d['sub_tahapan'] != 'PEMINDAIAN DOKUMEN SELESAI')){
		}elseif($jumlah > 0 AND ($d['tahapan']!='SELESAI' OR $d['tahapan']!='PENYERAHAN')){
			echo"DOKUMEN DENGAN NOMOR PERMOHONAN <b>$d[nomor_permohonan]</b> ATAS NAMA <b>$d[nama_lengkap]</b> SAAT INI MASIH BERSTATUS <b>$d[tahapan]</b>";
		
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
	
	echo"<h3>PENYERAHAN PASPOR</h3>
	<form method=POST action='view.php?module=hasilpencarian'>
	<table>
	   <tr align='right'><td colspan=3 align='left'><i>Masukkan Nomor Permohonan</i></td></tr>
	  <tr><td><b>NOMOR PERMOHONAN</b></td><td width='15'>:</td><td><input name=kata type=text size=50></td></tr>
	  <tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
	";
	?>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
	</script>
	<!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    
    
    <!-- jika ada session sukses maka tampilkan sweet alert dengan pesan yang telah di set
    di dalam session sukses  -->
    <?php if(@$_SESSION['suksesserah']){ ?>
        <script>
            swal("SUKSES", "DOKUMEN DENGAN NOMOR PERMOHONAN <font color='red'><b><?php echo $_SESSION['nomor_permohonan_serah']; ?></b></font> DISERAHKAN KEPADA <font color='red'><b><?php echo $_SESSION['penerima_serah']; ?></b></font>", "success");
        </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
    <?php unset($_SESSION['suksesserah']); }
}

// HALAMAN CARI DOKUMEN SERAH
elseif ($_GET['module']=='hasilpencarian'){
	echo"<h3>PENYERAHAN DOKUMEN KEIMIGRASIAN WNA</h3>";
	
		$seksi = mysqli_query($conn,"SELECT * FROM user WHERE nip='$_SESSION[nip]'");
		$s = mysqli_fetch_array($seksi);
		$cari   = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN rak b ON a.nomor_rak=b.nomor_rak WHERE a.nomor_permohonan = '$_POST[kata]' AND b.lokasi='$s[seksi]'");
		$jumlah = mysqli_num_rows($cari);
		
		//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN
		if ($jumlah > 0){
			$status = mysqli_query($conn,"SELECT * FROM arsip_paspor WHERE nomor_permohonan = '$_POST[kata]' AND status='Aktif'");
			$jmlst = mysqli_num_rows($status);
			
			//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS AKTIF(TERSIMPAN) - HALAMAN PENYERAHAN ARSIP
			if ($jmlst > 0){
				echo"<table>
					<thead>
					<tr bgcolor='yellow'>
					<th width='200'>NOMOR PERMOHONAN</span></th>
					<th width='400'>NOMOR PASPOR</span></th>
					<th width='100'>NAMA</span></th>
					<th width='100'>JENIS KELAMIN</span></th>
					<th width='100'>RAK</span></th>
				  </tr>
				</thead>
				<tbody>";
				$tampilMas = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
				$mas = mysqli_fetch_array($tampilMas);
					echo"<tr align='center'>
					<td>$mas[nomor_permohonan]</td>
					<td>$mas[nomor_paspor]</td>
					<td>$mas[nama]</td>";
				if($mas['jenis_kelamin']=='P'){
					echo"<td>Perempuan</td>";
				}else{
					echo"<td>Laki-Laki</td>";
				}
				echo"<td>$mas[nomor_rak]</td>
					</tr></tbody>
					</table>";
				echo"<hr color=#265180>";
				
				$tanggal=date('Y-m-d H:i:s');
				
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$_SESSION[nip]'");
				$s    = mysqli_fetch_array($serah);
				
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				echo"<form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=serah>
					 <input type='hidden' name='nomor_permohonan' value=$mas2[nomor_permohonan]>
					 <input type='hidden' name='nomor_rak' value=$mas2[nomor_rak]>
					 <input type='hidden' name='nomor_paspor' value=$mas2[nomor_paspor]>
					 <input type='hidden' name='nama' value='$mas2[nama]'>
					 <input type='hidden' name='nip' value=$_SESSION[nip]>
						<p>
						  <table>
							<tr valign='top'><td>Catatan Petugas</td><td><textarea name='keterangan' disabled>$mas2[keterangan]</textarea></td></tr>
							<tr><td>Diserahkan Kepada &nbsp;</td><td><input type='text' name='penerima' size='60' required></td></tr>
							<tr><td>Petugas Penyerah &nbsp;</td><td><input type='text' name='nip2' size='60' value='$_SESSION[nip] - $s[nama]' disabled></td></tr>
							<tr><td>Tanggal Serah &nbsp;</td><td><input type='date' name='tanggal' value=$tanggal  size='60' disabled></td></tr>
							<tr><td colspan=2 align='right'><input type='submit' name='save' value='SERAHKAN' style='height:50px; width:100px'></td></tr>
						  </table>
						</p>
					  </form>";
				
			//HALAMAN JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN DAN BERSTATUS INAKTIF (SUDAH DISERAHKAN)	
			} else {
				$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
				$mas2    = mysqli_fetch_array($tampilMas2);
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
				$s    = mysqli_fetch_array($serah);
				echo"
				<div align='center'><br><b>PASPOR TELAH DISERAHKAN</b><br><br>
				<table border='1'>
				<tr bgcolor='yellow' align='center'><th>Nomor Permohonan</th><th>Nomor Paspor</th><th>Nama</th><th>Tanggal Penyerahan</th><th>Diserahkan Kepada</th><th>Petugas Serah</th></tr>
				<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_paspor]</td><td>$mas2[nama]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
				</table></div>";
			}
			
		//HALAMAN TIDAK JIKA DITEMUKAN DOKUMEN DENGAN NOMOR PERMOHONAN	
		} else {
			echo"TIDAK DITEMUKAN DOKUMEN WNA DENGAN NOMOR PERMOHONAN : $_POST[kata]";
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
				
				$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$_SESSION[nip]'");
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
	echo"<h3>PASPOR TERSIMPAN DAN PASPOR TELAH SERAH</h3>";
	echo"<div align='center'><table border='0'><tr><td align='center' bgcolor='#baf53d'>&nbsp;<b>PASPOR TERSIMPAN</b>&nbsp;</td>
										<td>&nbsp&nbsp</td>
										<td align='center'>&nbsp;<a href=view.php?module=dokimserah>PASPOR TELAH SERAH</a>&nbsp;</td></tr>
							 </table></div>";
	
	echo"<table border='1'>
    <thead bgcolor='yellow'>
      <tr align='center'>
	    <th width='50'>NO</span></th>
        <th width='100'>NOMOR RAK</span></th>
		<th width='100'>NOMOR PERMOHONAN</span></th>
		<th width='100'>NOMOR PASPOR</span></th>
		<th width='400'>NAMA</span></th>
		<th width='400'>TEMPAT / TGL LAHIR</span></th>
		<th width='200'>HAPUS</span></th>
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
	$result = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN rak b ON a.nomor_rak = b.nomor_rak where a.status='Aktif' AND b.lokasi='$u[seksi]'");
	$total = mysqli_num_rows($result);
	$pages = ceil($total/$halaman);
	$tampilMas = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan
																			 LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									WHERE a.status='Aktif' AND c.lokasi='$u[seksi]'  order by a.nomor_rak LIMIT $mulai, $halaman");
	$no = $mulai+1;
                while($mas = mysqli_fetch_array($tampilMas)){
	echo "<tr align='center'>
			  <td>$no</td>
			  <td>$mas[nomor_rak]</td>
			  <td><a href=?module=detildokimsimpan&nomor_permohonan=$mas[nomor_permohonan]>$mas[nomor_permohonan]</a></td>
			  <td>$mas[nomor_paspor]</td>
			  <td>$mas[nama]</td>
			  <td>$mas[tempat_lahir] / $mas[tanggal_lahir]</td>
			  <td><a href=input.php?module=arsip&act=hapus&nomor_permohonan=$mas[nomor_permohonan]&nip=$_SESSION[nip] class='btn btn-sm btn-danger alert_notif'><button class=buttonhapuskecil><img src='images/trash.png' height=15px/></button></a></td>
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
		if($page-1 < 10){
			for ($i=1; $i<=$page-1 ; $i++){
				echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			echo"<a href=?module=dokimsimpan&halaman=1; style='text-decoration:none'>   << First |</a>";
			if($pages-$page < 11){
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
		
		if($pages-$page < 11){
			for ($i=$page+1; $i<=$pages ; $i++){
				echo"<a href=?module=dokimsimpan&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			if($page-1 < 10){
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
	
	?>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    
    
        <!-- jika ada session sukses maka tampilkan sweet alert dengan pesan yang telah di set
        di dalam session sukses  -->
        <?php if(@$_SESSION['sukses']){ ?>
            <script>
                Swal.fire({            
                    icon: 'success',                   
                    title: 'Sukses',    
                    text: 'Arsip Berhasil Diinaktivasi',                        
                    timer: 3000,                                
                    showConfirmButton: false
                })
            </script>
        <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
        <?php unset($_SESSION['sukses']); } ?>
    
    
        <!-- di bawah ini adalah script untuk konfirmasi hapus data dengan sweet alert  -->
        <script>
            $('.alert_notif').on('click',function(){
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "YAKIN UNTUK MENGHAPUS?",            
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: "Batal"
                
                }).then(result => {
                    //jika klik ya maka arahkan ke proses.php
                    if(result.isConfirmed){
                        window.location.href = getLink
                    }
                })
                return false;
            });
        </script>
	<?php
	
	
}

// Halaman Dokim DETIL DOKIM TERSIMPAN
elseif ($_GET['module']=='detildokimsimpan'){
	$detail=mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wni a LEFT JOIN arsip_paspor b on a.nomor_permohonan = b.nomor_permohonan
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
        <p>
          <table>
			<tr><td>Nomor Permohonan</td><td><input type='text' value=$d[nomor_permohonan] size='60' disabled></td></tr>
				<tr><td>Nomor Paspor</td><td><input type='text' name='nomor_paspor' size='60' value=$d[nomor_paspor] disabled></td></tr>
				<tr><td>Nama Lengkap</td><td><input type='text' name='nama' size='60' value='$d[nama]' disabled></td></tr>
				<tr><td>Tempat / Tgl Lahir</td><td><input type='text' size='60' value='$d[tempat_lahir] / $d[tanggal_lahir]' disabled></td></tr>
				<tr><td>No HP/WA</td><td><input type='text' name='no_hp' size='60'></td></tr>
				<tr><td>Jenis Kelamin</td>";
				if($d['jenis_kelamin']=='P'){
					echo"<td><input type='text' name='jenis_kelamin' size='60' value='Perempuan' disabled></td></tr>";
				}else{
					echo"<td><input type='text' name='jenis_kelamin' size='60' value='Laki-Laki' disabled></td></tr>";
				}
	echo"   <tr valign='top'><td>Catatan Petugas</td><td><textarea name='keterangan' disabled>$d[keterangan]</textarea></td></tr>
			<tr><td colspan='2'><hr></td></tr>
			<tr><td>Lokasi Rak Dokumen Saat Ini</td><td>&nbsp<b>$d[nomor_rak]</b></td></tr>
			<tr><td>Ganti Lokasi Rak</td><td><select name='nomor_rak' REQUIRED>";
												$cekrak = mysqli_query($conn,"SELECT * FROM rak where nomor_rak != '$d[nomor_rak]' AND lokasi='$u[seksi]' ORDER BY nomor_rak");
												while ($rak = mysqli_fetch_array($cekrak)){
													$kuota = mysqli_query($conn,"SELECT kuota FROM rak where nomor_rak='$rak[nomor_rak]'");
													while ($k = mysqli_fetch_array($kuota)){;
														$terpakai = mysqli_query($conn, "SELECT COUNT(nomor_rak) as terpakai FROM arsip_paspor where nomor_rak='$rak[nomor_rak]' and status='aktif'");
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
	echo"<h3>PASPOR TERSIMPAN DAN PASPOR TELAH SERAH</h3>";
	echo"<div align='center'><table><tr><td align='center'>&nbsp;<a href=view.php?module=dokimsimpan>PASPOR TERSIMPAN</a>&nbsp;</td>
										<td>&nbsp&nbsp</td>
										<td align='center' bgcolor='#baf53d'>&nbsp;<b>PASPOR TELAH SERAH</b>&nbsp;</td></tr>
							 </table></div>";
	
	echo"<form method=POST action='view.php?module=hasilpencariandokimserah'>
	  <table>
	  <tr><td colspan='3' align='left'>Pencarian Data Paspor Telah Serah<br><br></td></tr>
	  <tr><td>Kata Kunci </td><td width='15'>:</td><td><input name=kata placeholder='Pencarian' type=text size=30></td></tr>
	  <tr><td>Cari Berdasarkan </td><td>:</td><td><select name=kategori id=kategori>
		<option value=nomor_permohonan>Nomor Permohonan</option>
		<option value=nomor_paspor>Nomor Paspor</option>
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
        <th width='100'>NOMOR PASPOR</span></th>
		<th width='400'>NAMA</span></th>
		<th width='400'>TEMPAT / TGL LAHIR</span></th>
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
	$result = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan
																			LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									where a.status='Serah' AND c.lokasi='$u[seksi]'");
	$total = mysqli_num_rows($result);
	$pages = ceil($total/$halaman);
	$tampilMas = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan
																			LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									where a.status='Serah' AND c.lokasi='$u[seksi]' order by a.tanggal_serah DESC LIMIT $mulai, $halaman");
	$no = $mulai+1;
                while($mas = mysqli_fetch_array($tampilMas)){
	echo "<tr align='center'>
			  <td>$no</td>
			  <td>$mas[nomor_permohonan]</td>
			  <td>$mas[nomor_paspor]</td>
			  <td>$mas[nama]</td>
			  <td>$mas[tempat_lahir] / $mas[tanggal_lahir]</td>
			  <td>$mas[tanggal_serah]</td>
			  <td>$mas[penerima]</td>";
			  $petugas = mysqli_query($conn,"SELECT a.*, b.* FROM user a LEFT JOIN arsip_paspor b on a.nip = b.nip_serah
									where a.nip = '$mas[nip_serah]'");
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
		if($page-1 < 10){
			for ($i=1; $i<=$page-1 ; $i++){
				echo"<a href=?module=dokimserah&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			echo"<a href=?module=dokimserah&halaman=1; style='text-decoration:none'>   << First |</a>";
			if($pages-$page < 11){
				for ($i=$pages-9; $i<=$page-1 ; $i++){
					echo"<a href=?module=dokimserah&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
					}
			}else {
				for ($i=$page-4; $i<=$page-1 ; $i++){
					echo"<a href=?module=dokimserah&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
		}
		
		echo"<b> $i</b>";
		
		if($pages-$page < 11){
			for ($i=$page+1; $i<=$pages ; $i++){
				echo"<a href=?module=dokimserah&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			if($page-1 < 10){
				for ($i=$page+1; $i<=10 ; $i++){
					echo"<a href=?module=dokimserah&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			} else {
				for ($i=$page+1; $i<=$page+5 ; $i++){
					echo"<a href=?module=dokimserah&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
			echo"<a href=?module=dokimserah&halaman=$pages; style='text-decoration:none'>   | Last >></a>";
		}
    echo"<br></div><br>";
}

//HALAMAN PENCARIAN DOKIM SUDAH SERAH
elseif ($_GET['module']=='hasilpencariandokimserah'){
	echo"<h3>PASPOR TERSIMPAN DAN PASPOR TELAH SERAH</h3>";
	echo"<div align='center'><table><tr><td align='center'>&nbsp;<a href=view.php?module=dokimsimpan>PASPOR TERSIMPAN</a>&nbsp;&nbsp;</td>
										<td align='center' bgcolor='#baf53d'>&nbsp;<b>PASPOR TELAH SERAH</b>&nbsp;</td></tr>
							 </table></div>";
	
	echo"<form method=POST action='?module=hasilpencariandokimserah'>
	  <table>
	  <tr><td colspan='3' align='left'>Pencarian Data Paspor Telah Serah<br><br></td></tr>
	  <tr><td>Kata Kunci </td><td width='15'>:</td><td><input name=kata placeholder='Pencarian' value='$_POST[kata]' type=text size=30></td></tr>
	  <tr><td>Cari Berdasarkan </td><td>:</td><td><select name=kategori id=kategori>
		<option value=nomor_permohonan>Nomor Permohonan</option>
		<option value=nomor_paspor>Nomor Paspor</option>
		<option value=nama>Nama</option>
	  </select></td></tr>
		<tr align='right'><td colspan=3><input type=submit value=Cari></td></tr></table>
      </form>
      <hr color=#265180>";
	
	//PENCARIAN DENGAN NOMOR PERMOHONAN	
	if($_POST['kategori']=='nomor_permohonan'){
		$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
		$u = mysqli_fetch_array($user);
		$status = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN rak b ON a.nomor_rak=b.nomor_rak
													  WHERE a.nomor_permohonan = '$_POST[kata]' AND a.status='Serah' AND b.lokasi='$u[seksi]'");
		$jmlst = mysqli_num_rows($status);
		
		//PENCARIAN DENGAN NOMOR PERMOHONAN DITEMUKAN 
		if ($jmlst > 0){
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nomor_permohonan = '$_POST[kata]'");
			$mas2    = mysqli_fetch_array($tampilMas2);
			$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
			$s    = mysqli_fetch_array($serah);
			echo"
			<div align='center'>
			<table border='1'>
			<tr bgcolor='yellow' align='center'><th>NOMOR PERMOHONAN</th><th>NOMOR PASPOR</th><th>NAMA</th><th>TEMPAT / TGL LAHIR</th><th>TANGGAL SERAH</th><th>DISERAHKAN KEPADA</th><th>PETUGAS</th></tr>
			<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_paspor]</td><td>$mas2[nama]</td><td>$mas2[tempat_lahir] / $mas2[tanggal_lahir]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
			</table></div>";
		
		//PENCARIAN DENGAN NOMOR PERMOHONAN TIDAK DITEMUKAN 
		}else {
			echo"TIDAK DITEMUKAN PASPOR DENGAN NOMOR PERMOHONAN :<b>$_POST[kata]</b><br><br>";
		}
	
	//PENCARIAN DENGAN NOMOR PASPOR
	}elseif($_POST['kategori']=='nomor_paspor'){
		$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
		$u = mysqli_fetch_array($user);
		$status = mysqli_query($conn,"SELECT a.*, b.*,c.* FROM dokim_wni a LEFT JOIN arsip_paspor b ON a.nomor_permohonan=b.nomor_permohonan
																			   LEFT JOIN rak c ON b.nomor_rak=c.nomor_rak
													  WHERE a.nomor_paspor = '$_POST[kata]' AND b.status='Serah' AND c.lokasi='$u[seksi]'");
		$jmlst = mysqli_num_rows($status);
		
		//PENCARIAN DENGAN NOMOR PERMOHONAN DITEMUKAN 
		if ($jmlst > 0){
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan WHERE b.nomor_paspor = '$_POST[kata]'");
			$mas2    = mysqli_fetch_array($tampilMas2);
			$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
			$s    = mysqli_fetch_array($serah);
			echo"
			<div align='center'>
			<table border='1'>
			<tr bgcolor='yellow' align='center'><th>NOMOR PERMOHONAN</th><th>NOMOR PASPOR</th><th>NAMA</th><th>TEMPAT / TGL LAHIR</th><th>TANGGAL SERAH</th><th>DISERAHKAN KEPADA</th><th>PETUGAS</th></tr>
			<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_paspor]</td><td>$mas2[nama]</td><td>$mas2[tempat_lahir] / $mas2[tanggal_lahir]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
			</table></div>";
		
		//PENCARIAN DENGAN NOMOR PERMOHONAN TIDAK DITEMUKAN 
		}else {
			echo"TIDAK DITEMUKAN PASPOR DENGAN NOMOR PASPOR :<b>$_POST[kata]</b><br><br>";
		}
	
	//PENCARIAN DENGAN NAMA
	}elseif($_POST['kategori']=='nama'){
		$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
		$u = mysqli_fetch_array($user);
		$status = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_paspor a LEFT JOIN dokim_wni b on a.nomor_permohonan = b.nomor_permohonan
																			LEFT JOIN rak c on a.nomor_rak = c.nomor_rak
									  WHERE b.nama LIKE '%$_POST[kata]%' AND a.status='Serah' AND c.lokasi='$u[seksi]'");
		$jmlst = mysqli_num_rows($status);
		
		//PENCARIAN DENGAN NAMA DITEMUKAN SATU DOKIM
		if ($jmlst == 1){
			
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wni a LEFT JOIN arsip_paspor b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama LIKE '%$_POST[kata]%' AND b.status='Serah' ORDER by b.status");
			$mas2 = mysqli_fetch_array($tampilMas2);
			$serah =  mysqli_query($conn,"SELECT * FROM user where nip='$mas2[nip_serah]'");
			$s    = mysqli_fetch_array($serah);
			echo"
			<div align='center'>
			<table border='1'>
			<tr bgcolor='yellow' align='center'><th>NOMOR PERMOHONAN</th><th>NOMOR DOKIM</th><th>NAMA</th><th>TEMPAT / TGL LAHIR</th><th>TANGGAL SERAH</th><th>DISERAHKAN KEPADA</th><th>PETUGAS SERAH</th></tr>
			<tr align='center'>	<td>$mas2[nomor_permohonan]</td>
								<td>$mas2[nomor_paspor]</td>
								<td>$mas2[nama]</td>
								<td>$mas2[tempat_lahir] / $mas2[tanggal_lahir]</td>
								<td>$mas2[tanggal_serah]</td>
								<td>$mas2[penerima]</td>
								<td>$mas2[nip_serah] - $s[nama]</td></tr>
			</table></div>";
		
		//PENCARIAN DENGAN NAMA DITEMUKAN LEBIH DARI SATU DOKIM		
		}elseif ($jmlst > 1){
			echo"<table border='1'>
				<thead>
				<tr><td colspan=7>Ditemukan Paspor Dengan Nama <b>$_POST[kata]</b> Sebanyak <b>$jmlst</b> Data</td></tr>
				<tr bgcolor='yellow'>
				<th width='200'>NOMOR PERMOHONAN</span></th>
				<th width='100'>NOMOR PASPOR</span></th>
				<th width='400'>NAMA</span></th>
				<th width='400'>TEMPAT / TGL LAHIR</span></th>
				<th width='100'>TANGGAL SERAH</span></th>
				<th width='100'>DISERAHKAN KEPADA</span></th>
				<th width='100'>PETUGAS SERAH</span></th>
			  </tr></thead>
				<tbody>";
			
			$tampilMas2 = mysqli_query($conn,"SELECT a.*, b.* FROM dokim_wni a LEFT JOIN arsip_paspor b on a.nomor_permohonan = b.nomor_permohonan WHERE a.nama LIKE '%$_POST[kata]%' AND b.status='Serah' ORDER by b.status");
			while($mas2 = mysqli_fetch_array($tampilMas2)){
				$serah =  mysqli_query($conn,"SELECT * FROM user WHERE nip='$mas2[nip_serah]'");
				$s    = mysqli_fetch_array($serah);
				echo"<tr align='center'><td>$mas2[nomor_permohonan]</td><td>$mas2[nomor_paspor]</td><td>$mas2[nama]</td><td>$mas2[tempat_lahir] / $mas2[tanggal_lahir]</td><td>$mas2[tanggal_serah]</td></td><td>$mas2[penerima]</td><td>$mas2[nip_serah] - $s[nama]</td></tr>
					 </tbody>";
			}
			echo"</table>";
		
		//PENCARIAN DENGAN NAMA TIDAK DITEMUKAN	
		}else {
		echo"TIDAK DITEMUKAN PASPOR DENGAN NAMA : $_POST[kata]<br><br>";
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
				<tr><td>SEKSI</td><td>:</td><td><input type='text' value='$u[seksi]' size='50%' disabled></td></tr>
				<tr><td>PASSWORD</td><td>:</td><td><input type='password' name='password' size='50%' required></td></tr>
				<tr><td colspan='3' align='right'><input type='submit' name='save' value='Simpan'></td></tr></table>
		 </form>";
}

// HALAMAN EXPORT ARSIP
elseif ($_GET['module']=='exportxl'){
	echo"<h3>KIRIM DOKUMEN PASPOR KE ARSIP</h3>";
	
	echo"<div align='center'><table><tr><td align='center'>&nbsp; <a href=view.php?module=kirimarsip>KIRIM ARSIP</a> &nbsp;</td>
										<td align='center' bgcolor='#baf53d'>&nbsp;<b>EXPORT FILE</b></a> &nbsp;</td></tr>
							 </table></div>";
	
	echo"<table border='1'>
		 <tr><th>No</th><th>Tanggal Pengiriman</th><th>Jumlah Dokumen</th><th>Petugas Pengiriman</th><th>Download</th></tr>";
	
	$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$_SESSION[nip]'");
	$u = mysqli_fetch_array($user);
	$halaman = 10;
	$page = isset($_GET["halaman"])?(int)$_GET["halaman"] : 1;
	$mulai = ($page>1)?($page * $halaman) - $halaman : 0;
	$sebelum        = $page - 1;
	$setelah        = $page + 1;
	$result = mysqli_query($conn,"SELECT COUNT(a.nomor_permohonan) AS qty, a.tanggal_arsip, a.nip_arsip, b.nama 
								  FROM arsip_paspor a LEFT JOIN user b ON a.nip_arsip=b.nip
													 LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
								  WHERE a.tanggal_arsip != '0000-00-00' AND c.lokasi = '$u[seksi]'
								  GROUP BY a.tanggal_arsip, a.nip_arsip");
	$total = mysqli_num_rows($result);
	$pages = ceil($total/$halaman);
	$export = mysqli_query($conn,"SELECT COUNT(a.nomor_permohonan) AS qty, a.tanggal_arsip, a.nip_arsip, b.nama 
								  FROM arsip_paspor a LEFT JOIN user b ON a.nip_arsip=b.nip
													 LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
								  WHERE a.tanggal_arsip != '0000-00-00' AND c.lokasi = '$u[seksi]'
								  GROUP BY a.tanggal_arsip, a.nip_arsip
								  ORDER BY a.tanggal_arsip DESC
								  LIMIT $mulai, $halaman");
	$no = $mulai+1;
	while ($xl = mysqli_fetch_array ($export)){
		echo"<tr align='center'><td>$no</td>
				 <td>$xl[tanggal_arsip]</td>
				 <td>$xl[qty]</td>
				 <td>$xl[nip_arsip] - $xl[nama]</td>
				 <td><a href=export_excel2.php?tanggal_arsip=$xl[tanggal_arsip]&nip_arsip=$xl[nip_arsip]><img src='images/download.png' height=20px/></a></td>
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
		if($page-1 < 10){
			for ($i=1; $i<=$page-1 ; $i++){
				echo"<a href=?module=exportxl&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			echo"<a href=?module=exportxl&halaman=1; style='text-decoration:none'>   << First |</a>";
			if($pages-$page < 11){
				for ($i=$pages-9; $i<=$page-1 ; $i++){
					echo"<a href=?module=exportxl&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
					}
			}else {
				for ($i=$page-4; $i<=$page-1 ; $i++){
					echo"<a href=?module=exportxl&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
		}
		
		echo"<b> $i</b>";
		
		if($pages-$page < 11){
			for ($i=$page+1; $i<=$pages ; $i++){
				echo"<a href=?module=exportxl&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			if($page-1 < 10){
				for ($i=$page+1; $i<=10 ; $i++){
					echo"<a href=?module=exportxl&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			} else {
				for ($i=$page+1; $i<=$page+5 ; $i++){
					echo"<a href=?module=exportxl&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
			echo"<a href=?module=exportxl&halaman=$pages; style='text-decoration:none'>   | Last >></a>";
		}
    echo"<br></div><br>";
}

// HALAMAN KIRIM ARSIP
elseif ($_GET['module']=='kirimarsip'){
	echo"<h3>KIRIM DOKUMEN PASPOR KE ARSIP</h3>";
	
	echo"<div align='center'><table><tr><td align='center' bgcolor='#baf53d'>&nbsp; <b>KIRIM ARSIP</b> &nbsp;</td>
										<td align='center'>&nbsp;<a href=view.php?module=exportxl>EXPORT FILE</a> &nbsp;</td></tr>
							 </table></div>";
	
	echo"<form method=POST action='?module=cekkirimarsip'>
	  <table>
	  <tr valign='center'><th>Masukkan Tanggal Penyerahan :</th></tr>
	  <tr><td><input type='date' name='tanggal_awal' value=CURRENT_DATE()> Sampai Dengan Tanggal <input type='date' name='tanggal_akhir' value=CURRENT_DATE()></td></tr>
		<tr align='right'><td><input type=submit value='Open'></td></tr></table>
      </form>";
	  
	  ?>
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
	</script>
	<!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    
    
    <!-- jika ada session sukses maka tampilkan sweet alert dengan pesan yang telah di set
    di dalam session sukses  -->
    <?php if(@$_SESSION['suksescandi']){ ?>
        <script>
            swal("SUKSES", "DOKUMEN PASPOR BERHASIL DIKIRIM KE APLIKASI PENGARSIPAN CANDI", "success");
        </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
    <?php unset($_SESSION['suksescandi']); }
}

// HALAMAN CEK KIRIM ARSIP
elseif ($_GET['module']=='cekkirimarsip'){
	echo"<h3>KIRIM DOKUMEN PASPOR KE ARSIP</h3>";
	
	echo"<div align='center'><table><tr><td align='center' bgcolor='#baf53d'>&nbsp; <b>KIRIM ARSIP</b> &nbsp;</td>
										<td align='center'>&nbsp;<a href=view.php?module=exportxl>EXPORT FILE</a> &nbsp;</td></tr>
							 </table></div>";
	
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
			<th width='100'>NOMOR PASPOR</span></th>
			<th width='400'>NAMA</span></th>
			<th width='100'>TANGGAL SERAH</span></th>
			<th width='100'>STATUS PENGIRIMAN ARSIP</span></th>
		  </tr>
		</thead>
		<tbody>";
	
	echo"<form method=POST enctype='multipart/form-data' action=input.php?module=arsip&act=kirimcandi>";
	$seksi = mysqli_query($conn,"SELECT * FROM user WHERE nip='$_SESSION[nip]'");
	$ss = mysqli_fetch_array($seksi);
	$status = mysqli_query($conn,"SELECT a.*, b.*, c.* FROM arsip_paspor a
												 LEFT JOIN dokim_wni b ON a.nomor_permohonan=b.nomor_permohonan
												 LEFT JOIN rak c ON a.nomor_rak=c.nomor_rak
												 WHERE a.status='Serah' AND (a.tanggal_serah>='$_POST[tanggal_awal]' AND a.tanggal_serah<='$_POST[tanggal_akhir]') AND c.lokasi='$ss[seksi]'
												 ORDER BY a.tanggal_serah");
	$st = mysqli_num_rows($status);
	$no=1;
	echo"<tr><td colspan='8'><i>Jumlah Paspor Berstatus Sudah Serah Pada Tanggal $_POST[tanggal_awal] s/d $_POST[tanggal_akhir]</i> : <b>$st</b></td></tr>";
	while($s = mysqli_fetch_array($status)){
		if($s['tanggal_arsip']!='0000-00-00'){
			echo "<tr  align='center'>
					<td><input type='checkbox' name='' value='$s[nomor_permohonan]' disabled>
					<td>$no</td>
					<td>$s[nomor_permohonan]</td>
					<td>$s[nomor_paspor]</td>
					<td>$s[nama]</td>
					<td>$s[tanggal_serah]</td>
					<td bgcolor='green'><font color='white'>SUDAH DIKIRIM</font></td>
				</tr>";
			$no++;
		}else{
			echo "<tr  align='center'>
					<input type='hidden' name='nomor_paspor[ ]' value='$s[nomor_paspor]'>
					<input type='hidden' name='jenis_paspor[ ]' value='$s[jenis_paspor]'>
					<input type='hidden' name='tanggal_permohonan[ ]' value='$s[tanggal_permohonan]'>
					<input type='hidden' name='nama[ ]' value='$s[nama]'>
					<input type='hidden' name='jenis_kelamin[ ]' value='$s[jenis_kelamin]'>
					<input type='hidden' name='tempat_lahir[ ]' value='$s[tempat_lahir]'>
					<input type='hidden' name='tanggal_lahir[ ]' value='$s[tanggal_lahir]'>
					<input type='hidden' name='keterangan[ ]' value='$s[keterangan]'>
					<input type='hidden' name='nip[ ]' value='$_SESSION[nip]'>
					
					<td><input type='checkbox' name='foo[ ]' value='$s[nomor_permohonan]'>
					<td>$no</td>
					<td>$s[nomor_permohonan]</td>
					<td>$s[nomor_paspor]</td>
					<td>$s[nama]</td>
					<td>$s[tanggal_serah]</td>
					<td bgcolor='red'><font color='white'>BELUM DIKIRIM</font></td>
				</tr>";
			$no++;
		}
	}
		echo"</table>
		
			 <div align='right'><input type='submit' name='save' value='KIRIM ARSIP' style='height:50px';></div><br><br></form>";

}

//PERINGATAN MASA BERLAKU
elseif ($_GET['module']=='peringatan'){
	echo "<h3>KIRIM PESAN PENGINGAT VIA WHATSAPP</h3>
		  
		  <div align='center'><table><tr><td align='center' bgcolor='#baf53d'>&nbsp;<b>KIRIM PESAN</b>&nbsp;</td>
										<td align='center'>&nbsp;<a href=view.php?module=terkirim>PESAN TERKIRIM</a> &nbsp;</td></tr>
							 </table></div>
		  
		  <form method=POST action='view.php?module=carikirimmanual'>
		  <table>
		  <tr><td>CARI PASPOR YANG MASIH TERSIMPAN DAN BELUM DIAMBIL SELAMA : <input type='number' size='5' name='hari' value='20' style='width: 3em'> HARI</td></tr>
		  <tr><td align='right'><input type=submit value=Cari style='height:30px; width:80px'></td></tr></table>
		  </form>";
}

// HALAMAN HASIL CARI DOKIM MASA BERLAKU
elseif ($_GET['module']=='carikirim'){
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
	date_default_timezone_set("Asia/SIngapore");
	$hariini=date('Y-m-d');
	$jmlhari=$_POST['hari'];
	$exp=date('Y-m-d', strtotime('-'.$jmlhari.'days', strtotime($hariini)));
	
	echo"		
		<h3>KIRIM PESAN PENGINGAT VIA WHATSAPP</h3>
		<div align='center'><table><tr><td align='center' bgcolor='#baf53d'>&nbsp;<b>KIRIM PESAN</b>&nbsp;</td>
										<td align='center'>&nbsp;<a href=view.php?module=terkirim>PESAN TERKIRIM</a> &nbsp;</td></tr>
							 </table></div>		
				
		 <p>Daftar Dokim Izin Tinggal Yang Akan Habis Masa Berlakunya Dalam $jmlhari hari ($exp)</p>";
		 
	echo"<table border='1'>
		 <tr bgcolor='yellow'><th></span><input type='checkbox' onClick='toggle(this)' /></th><th width='40'>No</th><th width='200'>Nomor Dokim</th><th width='200'>Nama</th><th width='200'>Sponsor</th><th width='200'>Nomor HP</th><th width='200'>Tanggal Habis Masa Berlaku</th></tr>";
	
	echo"<form method=POST enctype='multipart/form-data' action=input.php?module=dokim&act=kirimpesan>";
	$cari=mysqli_query($conn_spri,"SELECT * FROM data_wna WHERE dokim_akhir='$exp' AND (dokim_no LIKE '2C%' OR dokim_no LIKE '2D%')");
	$no=1;
	while ($c = mysqli_fetch_array($cari)){
		echo"<input type='hidden' name='nomor_dokim[ ]' value='$c[dokim_no]'>
			 <input type='hidden' name='nip[ ]' value='$_SESSION[nip]'>
			 
			 <tr align='center'><td><input type='checkbox' name='foo[ ]' value='$c[no_permohonan]'></td>
								<td>$no</td><td>$c[dokim_no]</td>
								<td>$c[nama_pemohon]</td>
								<td>$c[sponsor_nama]</td>
								<td>$c[no_hp]</td>
								<td>$c[dokim_akhir]</td></tr>";
		$no++;
	}
	echo"</table>
		 <br><div align='right'><input type='submit' name='save' value='KIRIM PESAN'></form></div><br>";
	
}

// HALAMAN HASIL CARI DOKIM MASA BERLAKU
elseif ($_GET['module']=='carikirimmanual'){
	date_default_timezone_set("Asia/SIngapore");
	$hariini=date('Y-m-d');
	$jmlhari=$_POST['hari'];
	$exp=date('Y-m-d', strtotime('-'.$jmlhari.'days', strtotime($hariini)));
	
	echo"		
		<h3>KIRIM PESAN PENGINGAT VIA WHATSAPP</h3>
		<div align='center'><table><tr><td align='center' bgcolor='#baf53d'>&nbsp;<b>KIRIM PESAN</b>&nbsp;</td>
										<td align='center'>&nbsp;<a href=view.php?module=terkirim>PESAN TERKIRIM</a> &nbsp;</td></tr>
							 </table></div>		
				
		 <p>Daftar Paspor Yang Belum Diambil Dalam $jmlhari Hari (Tanggal Tersimpan : $exp)</p>";
		 
	echo"<table border='1'>
		 <tr bgcolor='yellow'><th>No</th><th>Tanggal Disimpan</th><th>Nomor Permohonan</th><th>Nomor Paspor</th><th>Nama</th><th>Nomor HP</th></tr>";
	
	echo"<form method=POST enctype='multipart/form-data' action=input.php?module=dokim&act=kirimpesanmanual>";
	$cari=mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b
																  ON a.nomor_permohonan = b.nomor_permohonan WHERE a.tanggal_input='$exp' AND a.tanggal_serah='0000-00-00'");
	$no=1;
	while ($c = mysqli_fetch_array($cari)){
		
		echo"<input type='hidden' name='nip[ ]' value='$_SESSION[nip]'>
			 <input type='hidden' name='nomor_permohonan[ ]' value='$c[nomor_permohonan]'>
			 <input type='hidden' name='jmlhari[ ]' value='$jmlhari'>";
			 
				echo"<tr align='center'><td>$no</td>
					<td>$c[tanggal_input]</td>
					<td>$c[nomor_permohonan]</td>
					<td>$c[nomor_paspor]</td>
					<td>$c[nama]</td>
					<td><input type='text' name='no_hp[ ]' value='$c[no_hp]'></td></tr>";
		$no++;
		
	}
	echo"</table>
		 <br><div align='right'><input type='submit' name='save' value='KIRIM PESAN'></form></div><br>";
}

//HALAMAN HISTORY PESAN WA TERKIRIM
elseif ($_GET['module']=='terkirim'){

	echo "<h3>KIRIM PESAN PERINGATAN VIA WHATSAPP</h3>
		
		<div align='center'><table><tr><td align='center'>&nbsp; <a href=view.php?module=peringatan>KIRIM PESAN</a> &nbsp;</td>
										<td align='center' bgcolor='#baf53d'>&nbsp;<b>PESAN TERKIRIM</b> &nbsp;</td></tr>";

	echo"
				  <table border='1'>
					<tr bgcolor='yellow'><th>No</th><th>Nomor Permohonan</th><th>Nomor Paspor</th><th>Nama</th><th>Nomor WA</th><th>Tanggal Tersimpan</th><th>Tanggal Kirim Pesan</th><th>Petugas Kirim Pesan</th></tr>";
	
	$halaman = 10;
	$page = isset($_GET["halaman"])?(int)$_GET["halaman"] : 1;
	$mulai = ($page>1)?($page * $halaman) - $halaman : 0;
	$sebelum        = $page - 1;
	$setelah        = $page + 1;
	$result = mysqli_query($conn,"SELECT * FROM kirimpesan");
	$total = mysqli_num_rows($result);
	$pages = ceil($total/$halaman);
	
	$cari = mysqli_query($conn,"SELECT * FROM kirimpesan ORDER BY tanggal_kirim DESC LIMIT $mulai, $halaman");
	$no = $mulai+1;
	while ($c = mysqli_fetch_array($cari)){
		$spri = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b ON a.nomor_permohonan=b.nomor_permohonan
													WHERE a.nomor_permohonan='$c[nomor_permohonan]'");
		$s = mysqli_fetch_array($spri);
		
		$user = mysqli_query($conn,"SELECT * FROM user WHERE nip = '$c[nip_kirim]'");
		$u = mysqli_fetch_array($user);
		
		echo"<tr align='center'><td>$no</td><td>$s[nomor_permohonan]</td><td>$s[nomor_paspor]</td><td>$s[nama]</td><td>$c[nomor_hp]</td><td>$s[tanggal_input]</td><td>$c[tanggal_kirim]</td><td>$c[nip_kirim] - $u[nama]</td></tr>";
		$no++;
	}
	
	echo"		  </table></div>
				";
	
	//paging
	 echo"<div style='font-weight:bold;' align='center'>";
		$previous = $page - 1;
		$next = $page + 1;	
           /* for ($i=1; $i<=$pages ; $i++){
            echo"<a href=?module=lihatdatapaspor&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
            }*/
		if($page-1 < 10){
			for ($i=1; $i<=$page-1 ; $i++){
				echo"<a href=?module=terkirim&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			echo"<a href=?module=terkirim&halaman=1; style='text-decoration:none'>   << First |</a>";
			if($pages-$page < 11){
				for ($i=$pages-9; $i<=$page-1 ; $i++){
					echo"<a href=?module=terkirim&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
					}
			}else {
				for ($i=$page-4; $i<=$page-1 ; $i++){
					echo"<a href=?module=terkirim&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
		}
		
		echo"<b> $i</b>";
		
		if($pages-$page < 11){
			for ($i=$page+1; $i<=$pages ; $i++){
				echo"<a href=?module=terkirim&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
			}
		} else {
			if($page-1 < 10){
				for ($i=$page+1; $i<=10 ; $i++){
					echo"<a href=?module=terkirim&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			} else {
				for ($i=$page+1; $i<=$page+5 ; $i++){
					echo"<a href=?module=terkirim&halaman=$i; style='text-decoration:none'>   <u>$i</u></a>";
				}
			}
			echo"<a href=?module=terkirim&halaman=$pages; style='text-decoration:none'>   | Last >></a>";
		}
    echo"<br></div><br>";
}

//jika modul tidak ditemukan
else{
  echo "<p align=center><b>MODUL BELUM ADA</b></p>";
}
?>