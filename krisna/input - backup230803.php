<?php
session_start();
include_once 'app/config.php';
$module=$_GET['module'];
$act=$_GET['act'];
date_default_timezone_set("Asia/SIngapore");

//INPUT DATA DOKIM WNA
if ($module=='dokumen' AND $act=='input'){
	 
	 $tanggal=date('Y-m-d');
	 $nip=$_POST['nip'];
	 $nomor_permohonan=$_POST['nomor_permohonan'];
	 $nomor_dokim=$_POST['nomor_dokim'];
	 $nomor_papsor=$_POST['nomor_paspor'];
	 $nama=$_POST['nama'];
	 $kebangsaan=$_POST['kebangsaan'];
	 $jenis_kelamin=$_POST['jenis_kelamin'];
	 $nomor_rak=$_POST['nomor_rak'];
	 $niora=$_POST['niora'];
	 $tempat_lahir=$_POST['tempat_lahir'];
	 $tanggal_lahir=$_POST['tanggal_lahir'];
	 $jenis_layanan=$_POST['jenis_layanan'];
	 $tanggal_permohonan=$_POST['tanggal_permohonan'];
	 $no_hp=$_POST['no_hp'];
	 
	 $ceknope = mysqli_query($conn,"SELECT * FROM dokim_wna where nomor_permohonan=$nomor_permohonan");
	 $jumlah = mysqli_num_rows($ceknope);
	if ($jumlah > 0){
		header('location:?module=logarsip&act=gagal&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama);
	}else{
		$sql = "INSERT INTO dokim_wna (nomor_permohonan,
									niora,
									nomor_dokim,
									nomor_paspor,
									nama,
									kebangsaan,
									jenis_kelamin,
									tempat_lahir,
									tanggal_lahir,
									jenis_layanan,
									tanggal_permohonan,
									no_hp,
									keterangan,
									tanggal_input,
									nip)
						VALUES ('$nomor_permohonan',
								'$niora',
								'$nomor_dokim',
								'$nomor_papsor',
								'$nama',
								'$kebangsaan',
								'$jenis_kelamin',
								'$tempat_lahir',
								'$tanggal_lahir',
								'$jenis_layanan',
								'$tanggal_permohonan',
								'$no_hp',
								'$keterangan',
								'$tanggal',
								'$nip')";
	
	 
		if (mysqli_query($conn, $sql)) { 
			header('location:?module=arsip&act=input&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&no_hp='.$no_hp.'&nomor_paspor='.$nomor_paspor.'&jenis_layanan='.$jenis_layanan.'&niora='.$niora); 
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
	}
}

//INPUT PENYIMPANAN WNA
elseif ($module=='arsip' AND $act=='input'){
	 
	 $tanggal=date('Y-m-d');
	 $nip=$_GET['nip'];
	 $nomor_permohonan=$_GET['nomor_permohonan'];
	 $nomor_rak=$_GET['nomor_rak'];
	 $nama=$_GET['nama'];
	 $nomor_dokim=$_GET['nomor_dokim'];
	 $no_hp=$_GET['no_hp'];
	 $nomor_paspor=$_GET['nomor_paspor'];
	 $jenis_layanan=$_GET['jenis_layanan'];
	 $niora=$_GET['niora'];
	
	 $sql = "INSERT INTO arsip_dokim (nomor_permohonan,
									  nomor_rak,
									  tanggal_input,
									  nip_input,
									  status
									  )
						VALUES ('$nomor_permohonan',
								'$nomor_rak',
								'$tanggal',
								'$nip',
								'Aktif')";
	
	 
	if (mysqli_query($conn, $sql)) { 
		header('location:?module=logarsip&act=berhasil&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&no_hp='.$no_hp.'&nomor_paspor='.$nomor_paspor.'&jenis_layanan='.$jenis_layanan.'&niora='.$niora);
	}else{
		echo "Error: " . $sql . "
" . 	mysqli_error($conn);
	}
	mysqli_close($conn);
}


//UPDATE DATA DOKIM WNA
elseif ($module=='dokumen' AND $act=='edit'){
	$nip=$_POST['nip'];
	$nomor_permohonan=$_POST['nomor_permohonan'];
	$nomor_rak=$_POST['nomor_rak'];
	$nomor_dokim=$_POST['nomor_dokim'];
	$nama=$_POST['nama'];
	$nomor_paspor=$_POST['nomor_paspor'];
	$jenis_kelamin=$_POST['jenis_kelamin'];
	$kebangsaan=$_POST['kebangsaan'];
	$keterangan=$_POST['keterangan'];
	
	//JIKA NOMOR RAK TIDAK DIUBAH
	if($_POST['nomor_rak']==0){
		$sql = "UPDATE dokim_wna SET nomor_dokim='$_POST[nomor_dokim]',
									 nomor_paspor='$_POST[nomor_paspor]',
									 nama='$_POST[nama]',
									 kebangsaan='$_POST[kebangsaan]',
									 jenis_kelamin='$_POST[jenis_kelamin]',
									 keterangan='$_POST[keterangan]'
								WHERE nomor_permohonan='$_POST[nomor_permohonan]'";
	
		if (mysqli_query($conn, $sql)) {
			header('location:?module=logdokim&act=edit&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&nomor_paspor='.$nomor_paspor.'&jenis_kelamin='.$jenis_kelamin.'&kebangsaan='.$kebangsaan.'&keterangan='.$keterangan);
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
		mysqli_close($conn);
	
	//JIKA NOMOR RAK DIUBAH
	}else{
		$sql = "UPDATE dokim_wna SET nomor_dokim='$_POST[nomor_dokim]',
									 nomor_paspor='$_POST[nomor_paspor]',
									 nama='$_POST[nama]',
									 kebangsaan='$_POST[kebangsaan]',
									 jenis_kelamin='$_POST[jenis_kelamin]',
									 keterangan='$_POST[keterangan]'
                WHERE nomor_permohonan='$_POST[nomor_permohonan]'";
	
		if (mysqli_query($conn, $sql)) {
			header('location:?module=arsip&act=edit&nip='.$nip.'&nomor_rak='.$nomor_rak.'&nomor_permohonan='.$nomor_permohonan.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&nomor_paspor='.$nomor_paspor.'&jenis_kelamin='.$jenis_kelamin.'&kebangsaan='.$kebangsaan.'&keterangan='.$keterangan);
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

//UPDATE NOMOR RAK PADA ARSIP
elseif ($module=='arsip' AND $act=='edit'){
	$nip=$_POST['nip'];
	$nomor_permohonan=$_POST['nomor_permohonan'];
	$nomor_rak=$_POST['nomor_rak'];
	$nomor_dokim=$_POST['nomor_dokim'];
	$nama=$_POST['nama'];
	$nomor_paspor=$_POST['nomor_paspor'];
	$jenis_kelamin=$_POST['jenis_kelamin'];
	$kebangsaan=$_POST['kebangsaan'];
	$nomor_rak_lama=$_POST['nomor_rak_lama'];
	
	$sql = "UPDATE arsip_dokim SET nomor_rak='$_POST[nomor_rak]'
                               WHERE nomor_permohonan='$_POST[nomor_permohonan]'";
	
	if (mysqli_query($conn, $sql)) {
		header('location:?module=logarsip&act=edit&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&nomor_paspor='.$nomor_paspor.'&jenis_kelamin='.$jenis_kelamin.'&kebangsaan='.$kebangsaan.'&keterangan='.$keterangan.'&nomor_rak_lama='.$nomor_rak_lama.'&nomor_rak='.$nomor_rak);
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn);
}

//LOG BERHASIL INPUT ARSIP
elseif ($module=='logarsip' AND $act=='berhasil'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_dokim=$_GET['nomor_dokim'];
	$nama=$_GET['nama'];
	$nomor_rak=$_GET['nomor_rak'];
	$no_hp=$_GET['no_hp'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$jenis_layanan=$_GET['jenis_layanan'];
	$niora=$_GET['niora'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil Menambahkan Nomor Permohonan $nomor_permohonan atas nama $nama dengan Nomor Dokim $nomor_dokim pada rak $nomor_rak')";
	
	 
	if (mysqli_query($conn, $sql)) { 
		header('location:?module=arsip&act=kirim&nomor_permohonan='.$nomor_permohonan.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&no_hp='.$no_hp.'&nomor_paspor='.$nomor_paspor.'&jenis_layanan='.$jenis_layanan.'&niora='.$niora);
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn);
}

//KIRIM WA
elseif ($module=='arsip' AND $act=='kirim'){
	 $nomor_permohonan=$_GET['nomor_permohonan'];
	 $nomor_dokim=$_GET['nomor_dokim'];
	 $nama=$_GET['nama'];
	 $no_hp = $_GET['no_hp'];
	 $nomor_paspor=$_GET['nomor_paspor'];
	 $jenis_layanan=$_GET['jenis_layanan'];
	 $niora=$_GET['niora'];

	 $sql = mysqli_query($conn, "SELECT * FROM wa WHERE id_wa='1'");
	 $s = mysqli_fetch_array($sql);
	 
	 $token = "$s[token]";
	 $pesan = "$s[pesan]";
	 $target = "$no_hp|$nama|$nomor_permohonan|$nomor_dokim|$jenis_layanan|$nomor_paspor|$niora";

	 
	 $curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://api.fonnte.com/send',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array(
		'target' => $target,
		'message' => $pesan,
		'delay' => '2-5'
		),
	  CURLOPT_HTTPHEADER => array(
		"Authorization: $token" //change TOKEN to your actual token
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;
	?> 
			<script language='JavaScript'>
				alert('DOKIM BERHASIL DIINPUT KE SISTEM DAN PESAN TELAH DIKIRIM KE PEMOHON');
				document.location='view.php?module=carisimpan';
			</script>
	<?php
}

//LOG ARSIP GAGAL INPUT
elseif ($module=='logarsip' AND $act=='gagal'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_dokim=$_GET['nomor_dokim'];
	$nama=$_GET['nama'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Gagal Menambahkan Nomor Permohonan $nomor_permohonan atas nama $nama dengan Nomor Dokim $nomor_dokim karena duplikasi data')";
	
	 
	if (mysqli_query($conn, $sql)) { ?> 
		<script language='JavaScript'>
			alert('DOKIM GAGAL DIINPUT, NOMOR PERMOHONAN SUDAH ADA DI SISTEM');
			document.location='view.php?module=simpan';
		</script><?php
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	 mysqli_close($conn); 
}

//LOG BERHASIL UPDATE DATA DOKIM
elseif ($module=='logdokim' AND $act=='edit'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_dokim=$_GET['nomor_dokim'];
	$nama=$_GET['nama'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$kebangsaan=$_GET['kebangsaan'];
	$jenis_kelamin=$_GET['jenis_kelamin'];
	$keterangan=$_GET['keterangan'];
	 
	$rak=mysqli_query($conn,"SELECT * FROM arsip_dokim WHERE nomor_permohonan=$nomor_permohonan");
	$r=mysqli_fetch_array($rak);
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil Mengubah Data Dokim WNA nomor permohonan $nomor_permohonan atas nama $nama berkebangsaan $kebangsaan dengan nomor dokim $nomor_dokim dan nomor paspor $nomor_paspor yang berada di rak $r[nomor_rak]')";
	
	 
	if (mysqli_query($conn, $sql)) { ?> 
		<script language='JavaScript'>
			alert('DATA DOKIM BERHASIL DIUBAH');
			document.location='view.php?module=dokimsimpan';
		</script><?php
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn); 
}

//LOG BERHASIL UPDATE NOMOR RAK ARSIP
elseif ($module=='logarsip' AND $act=='edit'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_dokim=$_GET['nomor_dokim'];
	$nama=$_GET['nama'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$kebangsaan=$_GET['kebangsaan'];
	$jenis_kelamin=$_GET['jenis_kelamin'];
	$keterangan=$_GET['keterangan'];
	$nomor_rak_lama=$_GET['nomor_rak_lama'];
	$nomor_rak=$_GET['nomor_rak'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil Mengubah Lokasi Nomor Rak Dokim WNA nomor permohonan $nomor_permohonan atas nama $nama berkebangsaan $kebangsaan dengan nomor dokim $nomor_dokim dan nomor paspor $nomor_paspor dari rak $nomor_rak_lama menjadi nomor rak $nomor_rak')";
	
	 
	if (mysqli_query($conn, $sql)) { ?> 
	<script language='JavaScript'>
		alert('DATA DOKIM BERHASIL DIUBAH');
		document.location='view.php?module=dokimsimpan';
	</script> <?php
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn); 
}

//PENYERAHAN ARSIP DOKIM WNA
elseif ($module=='arsip' AND $act=='serah'){
	 
	$tanggal=date('Y-m-d');
	$penerima=$_POST['penerima'];
	$nip=$_POST['nip'];
	$nama=$_POST['nama'];
	$nomor_permohonan=$_POST['nomor_permohonan'];
	$nomor_rak=$_POST['nomor_rak'];
	$nomor_dokim=$_POST['nomor_dokim'];
	
	$sql = "UPDATE arsip_dokim SET	status='Serah',
									tanggal_serah='$tanggal',
									nip_serah='$nip',
									penerima='$penerima'
                               WHERE nomor_permohonan='$nomor_permohonan'";
	
	if (mysqli_query($conn, $sql)) {
		header('location:?module=logarsip&act=serah&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&penerima='.$penerima);
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	 mysqli_close($conn);
}

//LOG PENYERAHAN ARSIP DOKIM WNA
elseif ($module=='logarsip' AND $act=='serah'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_dokim=$_GET['nomor_dokim'];
	$nama=$_GET['nama'];
	$penerima=$_GET['penerima'];
	$nomor_rak=$_GET['nomor_rak'];
	 
	$sql = "INSERT INTO log	(tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil menyerahkan dokim Nomor Permohonan $nomor_permohonan atas nama $nama dengan Nomor Dokim $nomor_dokim dari rak nomor $nomor_rak kepada $penerima')";
	
	 
	if (mysqli_query($conn, $sql)) {?> 
		<script language='JavaScript'>
			alert('DATA DOKIM BERHASIL DISERAHKAN');
			document.location='view.php?module=dokimserah';
		</script> <?php
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	 mysqli_close($conn); 
}

//LOG LOGOUT
elseif ($module=='logout'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES	('$tanggal',
							 '$nip',
							 'Berhasil Logout')";
	
	 
	if (mysqli_query($conn, $sql)) {
		header('location:logout.php');
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn); 
}

//GANTI PASSWORD USER
elseif ($module=='user' AND $act=='edit'){

	$nip=$_POST['nip'];
	$password=md5($_POST['password']);
	
	$sql = "UPDATE user SET	password='$password'
                               WHERE nip='$nip'";
	
	if (mysqli_query($conn, $sql)) {
		header('location:?module=loguser&act=edit&nip='.$nip.'&nama='.$nama);
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	 mysqli_close($conn);
}

//LOG PASSWORD USER
elseif ($module=='loguser' AND $act=='edit'){

	$nip=$_GET['nip'];
	$tanggal=date('Y-m-d H:i:s');
	
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES	('$tanggal',
							 '$nip',
							 'Berhasil Mengubah Password')";
	
	if (mysqli_query($conn, $sql)) {?> 
		<script language='JavaScript'>
			alert('PASSWORD BERHASIL DIUBAH');
			document.location='view.php?module=user';
		</script> <?php
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	 mysqli_close($conn);
}

//DELETE ARSIP
elseif ($module=='arsip' AND $act=='hapus'){
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nip=$_GET['nip'];
	$data=mysqli_query($conn,"SELECT a.*, b.* FROM arsip_dokim a LEFT JOIN dokim_wna b ON a.nomor_permohonan=b.nomor_permohonan WHERE a.nomor_permohonan='$nomor_permohonan'");
	$d=mysqli_fetch_array($data);
	$tanggal=date('Y-m-d H:i:s');
	
	//INPUT KE LOG 
	$log = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES	('$tanggal',
							 '$nip',
							 'Berhasil Menghapus Dari Arsip Dokim dengan Nomor Permohonan : $d[nomor_permohonan] atas nama $d[nama] Dengan Nomor Dokim $d[nomor_dokim] dari rak $d[nomor_rak]')";
	//JIKA LOG BERHASIL DIINPUT DILANJUTKAN DENGAN MENGHAPUS ARSIP
	if (mysqli_query($conn, $log)) {
		$sql = "DELETE FROM arsip_dokim WHERE nomor_permohonan='$nomor_permohonan'";
		
		//JIKA ARSIP BERHASIL DIHAPUS DILANJUTKAN DENGAN MENGHAPUS DATA DOKIM
		if (mysqli_query($conn, $sql)) {
			$sql2 = "DELETE FROM dokim_wna WHERE nomor_permohonan='$nomor_permohonan'";
				
				//JIKA DATA DOKIM BERHASIL DIHAPUS
				if (mysqli_query($conn, $sql2)) { ?>
					<script language='JavaScript'>
									alert('DOKIM BERHASIL DIHAPUS DARI ARSIP');
									document.location='view.php?module=dokimsimpan';
								</script>
					  <?php 
				
				//JIKA DATA DOKIM GAGAL DIHAPUS				
				} else {
					echo "Error: Data Dokim Gagal Dihapus " . $sql . "
					     " . mysqli_error($conn);
				}
					 
		//JIKA ARSIP GAGAL DI HAPUS		 
		} else {
			echo "Error: Data Arsip Gagal Dihapus" . $sql . "
				 " . mysqli_error($conn);
		}
	
	//JIKA LOG GAGAL DIINPUT	
	} else {
			echo "Error: Gagal Menginput Log" . $sql . "
				 " . mysqli_error($conn);
		}
	
	 mysqli_close($conn);
}

//KIRIM ARSIP KE CANDI
elseif ($module=='arsip' AND $act=='kirimcandi'){
	$tanggal=date('Y-m-d');
	$tanggallog=date('Y-m-d H:i:s');
	$nomor_permohonan = $_POST['foo'];
	$niora = $_POST['niora'];
	$nomor_dokim = $_POST['nomor_dokim'];
	$nomor_paspor = $_POST['nomor_paspor'];
	$nama = $_POST['nama'];
	$kebangsaan = $_POST['kebangsaan'];
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$tempat_lahir = $_POST['tempat_lahir'];
	$tanggal_lahir = $_POST['tanggal_lahir'];
	$jenis_layanan = $_POST['jenis_layanan'];
	$tanggal_permohonan = $_POST['tanggal_permohonan'];
	$nip = $_POST['nip'];
	
	//SET TGL NIP PENGIRIM ARSIP
	for($i=0; $i<sizeof ($nomor_permohonan); $i++){
		$arsip = "UPDATE arsip_dokim SET	tanggal_arsip='$tanggal',
											nip_arsip='$nip[$i]'
									 WHERE	nomor_permohonan='$nomor_permohonan[$i]'";
		
		
	//JIKA BERHASIL SET TGL NIP PENGIRIM ARSIP AKAN DILAKUKAN INPUT DATA INTAL PADA APLIKASI CANDI
		if (mysqli_query($conn, $arsip)) {
			$candi = "INSERT INTO dataintal (nomor_permohonan,
											niora,
											nomor_dokim,
											nomor_paspor,
											nama,
											kebangsaan,
											jenis_kelamin,
											tempat_lahir,
											tanggal_lahir,
											jenis_layanan,
											keterangan,
											tanggal_permohonan,
											tanggal_upload,
											status)
						VALUES ('$nomor_permohonan[$i]',
								'$niora[$i]',
								'$nomor_dokim[$i]',
								'$nomor_paspor[$i]',
								'$nama[$i]',
								'$kebangsaan[$i]',
								'$jenis_kelamin[$i]',
								'$tempat_lahir[$i]',
								'$tanggal_lahir[$i]',
								'$jenis_layanan[$i]',
								'-',
								'$tanggal_permohonan[$i]',
								'$tanggal',
								'0')";
			
			
			//JIKA BERHASIL INPUT DATA INTAL PADA APLIKASI CANDI
			if (mysqli_query($conn_arsip, $candi)) {
				$log = "INSERT INTO log	(tanggal,
												 nip,
												 aktifitas)
									VALUES		('$tanggallog',
												 '$nip[$i]',
												 'Berhasil Mengirimkan File Dokim WNA Nomor Permohonan $nomor_permohonan[$i] Atas Nama $nama[$i] Dengan Nomor Dokim $nomor_dokim[$i] ke Aplikasi Pengarsipan')";
				
				//JIKA BERHASIL INPUT LOG KIRIM FILE ARSIP
				if (mysqli_query($conn, $log)) {
					?>
					<script language='JavaScript'>
									alert('File Dokim Berhasil Dikirim ke Ruang Arsip');
									document.location='view.php?module=kirimarsip';
								</script>
					<?php 
				//JIKA GAGAL INPUT LOG KIRIM FILE ARSIP
				}else {
					echo "Error: " . $sql . "
					" . mysqli_error($conn);
				 }
			
			//JIKA GAGAL INPUT DATA INTAL PADA APLIKASI CANDI			
			}else {
				echo "Error: " . $sql . "
				" . mysqli_error($conn_arsip);
			}
			
		//JIKA GAGAL SET TGL NIP PENGIRIM ARSIP				
		}else {
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	}
}


?>

