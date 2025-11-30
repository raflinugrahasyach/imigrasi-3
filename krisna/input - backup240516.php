<?php
session_start();

//ini wajib dipanggil paling atas - unntuk email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once 'app/config.php';
$module=$_GET['module'];
$act=$_GET['act'];
date_default_timezone_set("Asia/SIngapore");

//INPUT DATA PASPOR
if ($module=='dokumen' AND $act=='input'){
	 
	 $tanggal=date('Y-m-d');
	 $nip=$_POST['nip'];
	 $seksi=$_POST['seksi'];
	 $nomor_permohonan=$_POST['nomor_permohonan'];
	 $nomor_paspor=$_POST['nomor_paspor'];
	 $jenis_paspor=$_POST['jenis_paspor'];
	 $tanggal_permohonan=$_POST['tanggal_permohonan'];
	 $nama=$_POST['nama'];
	 $jenis_kelamin=$_POST['jenis_kelamin'];
	 $nomor_rak=$_POST['nomor_rak'];
	 $tempat_lahir=$_POST['tempat_lahir'];
	 $tanggal_lahir=$_POST['tanggal_lahir'];
	 $no_hp=$_POST['no_hp'];
	 $email=$_POST['email'];
	 $keterangan=$_POST['keterangan'];
	 
	 $ceknope = mysqli_query($conn,"SELECT * FROM dokim_wni where nomor_permohonan=$nomor_permohonan");
	 $jumlah = mysqli_num_rows($ceknope);
	if ($jumlah > 0){
		header('location:?module=logarsip&act=gagal&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nomor_paspor='.$nomor_paspor.'&nama='.$nama);
	}else{
		
		if (empty($_POST['keterangan'])) {
			$sql = "INSERT INTO dokim_wni (	nomor_permohonan,
										nomor_paspor,
										jenis_paspor,
										tanggal_permohonan,
										nama,
										jenis_kelamin,
										tempat_lahir,
										tanggal_lahir,
										no_hp,
										keterangan,
										tanggal_input,
										nip)
						VALUES ('$nomor_permohonan',
								'$nomor_paspor',
								'$jenis_paspor',
								'$tanggal_permohonan',
								'$nama',
								'$jenis_kelamin',
								'$tempat_lahir',
								'$tanggal_lahir',
								'$no_hp',
								'-',
								'$tanggal',
								'$nip')";
		}else{
			 $sql = "INSERT INTO dokim_wni (	nomor_permohonan,
												nomor_paspor,
												jenis_paspor,
												tanggal_permohonan,
												nama,
												jenis_kelamin,
												tempat_lahir,
												tanggal_lahir,
												no_hp,
												keterangan,
												tanggal_input,
												nip)
								VALUES ('$nomor_permohonan',
										'$nomor_paspor',
										'$jenis_paspor',
										'$tanggal_permohonan',
										'$nama',
										'$jenis_kelamin',
										'$tempat_lahir',
										'$tanggal_lahir',
										'$no_hp',
										'$keterangan',
										'$tanggal',
										'$nip')";
		}
	
	 
		if (mysqli_query($conn, $sql)) { 
			header('location:?module=arsip&act=input&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nama='.$nama.'&no_hp='.$no_hp.'&nomor_paspor='.$nomor_paspor.'&jenis_paspor='.$jenis_paspor.'&email='.$email.'&seksi='.$seksi); 
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
	}
}

//INPUT PENYIMPANAN WNI
elseif ($module=='arsip' AND $act=='input'){
	 
	 $tanggal=date('Y-m-d');
	 $nip=$_GET['nip'];
	 $seksi=$_GET['seksi'];
	 $nomor_permohonan=$_GET['nomor_permohonan'];
	 $nomor_rak=$_GET['nomor_rak'];
	 $nama=$_GET['nama'];
	 $no_hp=$_GET['no_hp'];
	 $email=$_GET['email'];
	 $nomor_paspor=$_GET['nomor_paspor'];
	 $jenis_paspor=$_GET['jenis_paspor'];
	 $keterangan=$_GET ['keterangan'];
	 
	
	 $sql = "INSERT INTO arsip_paspor (nomor_permohonan,
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
		header('location:?module=logarsip&act=berhasil&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nama='.$nama.'&no_hp='.$no_hp.'&nomor_paspor='.$nomor_paspor.'&jenis_paspor='.$jenis_paspor.'&email='.$email.'&seksi='.$seksi);
	}else{
		echo "Error: " . $sql . "
" . 	mysqli_error($conn);
	}
	mysqli_close($conn);
}

//UPDATE NOMOR RAK PADA ARSIP
elseif ($module=='arsip' AND $act=='edit'){
	$nip=$_POST['nip'];
	$nomor_permohonan=$_POST['nomor_permohonan'];
	$nama=$_POST['nama'];
	$nomor_paspor=$_POST['nomor_paspor'];
	$jenis_kelamin=$_POST['jenis_kelamin'];
	$nomor_rak_lama=$_POST['nomor_rak_lama'];
	
	$sql = "UPDATE arsip_paspor SET nomor_rak='$_POST[nomor_rak]'
                               WHERE nomor_permohonan='$_POST[nomor_permohonan]'";
	
	if (mysqli_query($conn, $sql)) {
		header('location:?module=logarsip&act=edit&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nama='.$nama.'&nomor_paspor='.$nomor_paspor.'&jenis_kelamin='.$jenis_kelamin.'&nomor_rak_lama='.$nomor_rak_lama.'&nomor_rak='.$nomor_rak);
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
	$seksi=$_GET['seksi'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nama=$_GET['nama'];
	$nomor_rak=$_GET['nomor_rak'];
	$no_hp=$_GET['no_hp'];
	$email=$_GET['email'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$jenis_paspor=$_GET['jenis_paspor'];
	$keterangan=$_GET['keterangan'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil Menambahkan Paspor Nomor Permohonan $nomor_permohonan atas nama $nama dengan nomor paspor $nomor_paspor pada rak $nomor_rak')";
	
	 
	if (mysqli_query($conn, $sql)) { 
		header('location:?module=arsip&act=kirimwa&nomor_permohonan='.$nomor_permohonan.'&nama='.$nama.'&no_hp='.$no_hp.'&nomor_paspor='.$nomor_paspor.'&jenis_paspor='.$jenis_paspor.'&email='.$email.'&seksi='.$seksi.'&nomor_rak='.$nomor_rak);
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn);
}

//KIRIM WA
elseif ($module=='arsip' AND $act=='kirimwa'){
	 $nomor_permohonan=$_GET['nomor_permohonan'];
	 $nama=$_GET['nama'];
	 $no_hp = $_GET['no_hp'];
	 $seksi=$_GET['seksi'];
	 $email = $_GET['email'];
	 $nomor_paspor=$_GET['nomor_paspor'];
	 $jenis_paspor=$_GET['jenis_paspor'];
	 $nomor_rak=$_GET['nomor_rak'];
	 
	 $cek = mysqli_query($conn,"SELECT * FROM dokim_wni WHERE nomor_permohonan='$nomor_permohonan'");
	 $c=mysqli_fetch_array($cek);
	 $ket="$c[keterangan]";

	 $sql = mysqli_query($conn, "SELECT * FROM wa WHERE id_wa='1'");
	 $s = mysqli_fetch_array($sql);
	 
	// JIKA PENGIRIM DARI LANTASKIM
	if($seksi=='LANTASKIM'){
		$token = "$s[token]";
		$pesan = "$s[pesan]";
		$target = "$no_hp|$nama|$nama|$nomor_permohonan|$ket|$nomor_paspor";


		$curl = curl_init();

		curl_setopt_array($curl, array(
		//CURLOPT_URL => 'https://6f57-36-85-7-124.ngrok-free.app/wagate/public/send',
		CURLOPT_URL => 'http://localhost/wagate/public/send',
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
	}
	
	//header('location:?module=arsip&act=kirimemail&nomor_permohonan='.$nomor_permohonan.'&nomor_dokim='.$nomor_dokim.'&nama='.$nama.'&nomor_paspor='.$nomor_paspor.'&jenis_layanan='.$jenis_layanan.'&niora='.$niora.'&email='.$email.'&seksi='.$seksi);
	
	//set session sukses
    $_SESSION["sukses"] = 'Data Berhasil Disimpan';
	$_SESSION["nomor_paspor"] = $nomor_paspor;
	$_SESSION["nomor_rak"] = $nomor_rak;
	$_SESSION["nomor_permohonan"] = $nomor_permohonan;
    
    //redirect ke halaman index.php
    header('Location: view.php?module=carisimpan');
	
	?> 
		<script language='JavaScript'>
			//alert('PASPOR DENGAN NOMOR : <?php echo"$nomor_paspor"; ?> BERHASIL DISIMPAN PADA RAK <?php echo"$nomor_rak"; ?>');
			//document.location='view.php?module=carisimpan';
		</script><?php
		
}

//LOG ARSIP GAGAL INPUT
elseif ($module=='logarsip' AND $act=='gagal'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$nama=$_GET['nama'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Gagal Menambahkan Paspor Nomor Permohonan $nomor_permohonan atas nama $nama dengan Nomor Paspor $nomor_paspor karena duplikasi data')";
	
	 
	if (mysqli_query($conn, $sql)) { ?> 
		<script language='JavaScript'>
			alert('PASPOR GAGAL DIINPUT, NOMOR PERMOHONAN SUDAH ADA DI SISTEM');
			document.location='view.php?module=simpan';
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
	$nama=$_GET['nama'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$jenis_kelamin=$_GET['jenis_kelamin'];
	$nomor_rak_lama=$_GET['nomor_rak_lama'];
	$nomor_rak=$_GET['nomor_rak'];
	 
	$sql = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil Mengubah Lokasi Nomor Rak Dokumen Paspor nomor permohonan $nomor_permohonan atas nama $nama dengan nomor paspor $nomor_paspor dari rak $nomor_rak_lama menjadi nomor rak $nomor_rak')";
	
	 
	if (mysqli_query($conn, $sql)) { ?> 
	<script language='JavaScript'>
		alert('DATA RAK PASPOR BERHASIL DIUBAH');
		document.location='view.php?module=dokimsimpan';
	</script> <?php
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	mysqli_close($conn); 
}

//PENYERAHAN ARSIP PASPOR
elseif ($module=='arsip' AND $act=='serah'){
	 
	$tanggal=date('Y-m-d');
	$penerima=$_POST['penerima'];
	$nip=$_POST['nip'];
	$nama=$_POST['nama'];
	$nomor_permohonan=$_POST['nomor_permohonan'];
	$nomor_rak=$_POST['nomor_rak'];
	$nomor_paspor=$_POST['nomor_paspor'];
	
	$sql = "UPDATE arsip_paspor SET	status='Serah',
									tanggal_serah='$tanggal',
									nip_serah='$nip',
									penerima='$penerima'
                               WHERE nomor_permohonan='$nomor_permohonan'";
	
	if (mysqli_query($conn, $sql)) {
		header('location:?module=logarsip&act=serah&nip='.$nip.'&nomor_permohonan='.$nomor_permohonan.'&nomor_rak='.$nomor_rak.'&nomor_paspor='.$nomor_paspor.'&nama='.$nama.'&penerima='.$penerima);
	}else{
		echo "Error: " . $sql . "
		" . mysqli_error($conn);
	}
	 mysqli_close($conn);
}

//LOG PENYERAHAN ARSIP PASPOR
elseif ($module=='logarsip' AND $act=='serah'){
	 
	$tanggal=date('Y-m-d H:i:s');
	$nip=$_GET['nip'];
	$nomor_permohonan=$_GET['nomor_permohonan'];
	$nomor_paspor=$_GET['nomor_paspor'];
	$nama=$_GET['nama'];
	$penerima=$_GET['penerima'];
	$nomor_rak=$_GET['nomor_rak'];
	 
	$sql = "INSERT INTO log	(tanggal,
							 nip,
							 aktifitas)
					VALUES ('$tanggal',
							'$nip',
							'Berhasil menyerahkan Paspor Nomor Permohonan $nomor_permohonan atas nama $nama dengan Nomor Paspor $nomor_paspor dari rak nomor $nomor_rak kepada $penerima')";
	
	 
	 //set session sukses
    $_SESSION["suksesserah"] = 'berhasil serah';
	$_SESSION["nomor_paspor_serah"] = $nomor_paspor;
	$_SESSION["nomor_rak_serah"] = $nomor_rak;
	$_SESSION["nomor_permohonan_serah"] = $nomor_permohonan;
	$_SESSION["penerima_serah"] = $penerima;
    
    //redirect ke halaman index.php
    header('Location: view.php?module=serah');
	 

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
	$data=mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b ON a.nomor_permohonan=b.nomor_permohonan WHERE a.nomor_permohonan='$nomor_permohonan'");
	$d=mysqli_fetch_array($data);
	$tanggal=date('Y-m-d H:i:s');
	
	$log = "INSERT INTO log (tanggal,
							 nip,
							 aktifitas)
					VALUES	('$tanggal',
							 '$nip',
							 '$d[nomor_permohonan]')";
	//JIKA LOG BERHASIL DIINPUT DILANJUTKAN DENGAN MENGHAPUS ARSIP
	if (mysqli_query($conn, $log)) {
	$sql = "DELETE FROM arsip_paspor WHERE nomor_permohonan='$nomor_permohonan'";
		
		//JIKA ARSIP BERHASIL DIHAPUS DILANJUTKAN DENGAN MENGHAPUS DATA DOKIM
		if (mysqli_query($conn, $sql)) {
			$sql2 = "DELETE FROM dokim_wni WHERE nomor_permohonan='$nomor_permohonan'";
				
				//JIKA DATA DOKIM BERHASIL DIHAPUS
				if (mysqli_query($conn, $sql2)) { ?>
					<script language='JavaScript'>
									alert('DATA PASPOR BERHASIL DIHAPUS DARI ARSIP');
									document.location='view.php?module=dokimsimpan';
								</script>
					  <?php 
				
				//JIKA DATA DOKIM GAGAL DIHAPUS				
				} else {
					echo "Error: Data Paspor Gagal Dihapus " . $sql . "
					     " . mysqli_error($conn);
				}
					 
		//JIKA ARSIP GAGAL DI HAPUS		 
		} else {
			echo "Error: Data Paspor Gagal Dihapus" . $sql . "
				 " . mysqli_error($conn);
		}//JIKA LOG GAGAL DIINPUT	
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
	$nomor_paspor = $_POST['nomor_paspor'];
	$jenis_paspor = $_POST['jenis_paspor'];
	$tanggal_permohonan = $_POST['tanggal_permohonan'];
	$nama = $_POST['nama'];
	$jenis_kelamin = $_POST['jenis_kelamin'];
	$tempat_lahir = $_POST['tempat_lahir'];
	$tanggal_lahir = $_POST['tanggal_lahir'];
	$keterangan = $_POST['keterangan'];
	$nip = $_POST['nip'];
	
	//SET TGL NIP PENGIRIM ARSIP
	for($i=0; $i<sizeof ($nomor_permohonan); $i++){
		
		$detail = mysqli_query($conn,"SELECT * FROM dokim_wni WHERE nomor_permohonan='$nomor_permohonan[$i]'");
		$d = mysqli_fetch_array($detail);
		
		$arsip = "UPDATE arsip_paspor SET	tanggal_arsip='$tanggal',
											nip_arsip='$nip[$i]'
									 WHERE	nomor_permohonan='$nomor_permohonan[$i]'";
		
		
	//JIKA BERHASIL SET TGL NIP PENGIRIM ARSIP AKAN DILAKUKAN INPUT DATA PASPOR PADA APLIKASI CANDI
		if (mysqli_query($conn, $arsip)) {
			$candi = "INSERT INTO datapaspor (nomor_permohonan,
											nomor_paspor,
											jenis_paspor,
											tanggal_permohonan,
											nama,
											jenis_kelamin,
											tempat_lahir,
											tanggal_lahir,
											keterangan,
											tanggal_upload)
						VALUES ('$nomor_permohonan[$i]',
								'$d[nomor_paspor]',
								'$d[jenis_paspor]',
								'$d[tanggal_permohonan]',
								'$d[nama]',
								'$d[jenis_kelamin]',
								'$d[tempat_lahir]',
								'$d[tanggal_lahir]',
								'-',
								'$tanggal')";
			
			
			//JIKA BERHASIL INPUT DATA INTAL PADA APLIKASI CANDI
			if (mysqli_query($conn_arsip, $candi)) {
				$log = "INSERT INTO log	(tanggal,
												 nip,
												 aktifitas)
									VALUES		('$tanggallog',
												 '$nip[$i]',
												 'Berhasil Mengirimkan File Arsip Paspor Dengan Nomor Permohonan $nomor_permohonan[$i] Atas Nama $d[nama] Dengan Nomor Paspor $d[nomor_paspor] ke Aplikasi Pengarsipan')";
				
				//JIKA BERHASIL INPUT LOG KIRIM FILE ARSIP
				if (mysqli_query($conn, $log)) {
					//set session sukses
						$_SESSION["suksescandi"] = 'berhasil kirim ke candi';
						
						//redirect ke halaman index.php
						header('Location: view.php?module=kirimarsip');
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

//KIRIM KIRIM PESAN PERINGATAN KE WA
elseif ($module=='dokim' AND $act=='kirimpesan'){
	$nomor_permohonan = $_POST['foo'];
	$nip = $_POST['nip'];
	
	$sql = mysqli_query($conn, "SELECT * FROM wa WHERE id_wa='1'");
	$s = mysqli_fetch_array($sql);
	$token = "$s[token]";
	$pesan = "$s[pesan_peringatan]";
	
	for($i=0; $i<sizeof ($nomor_permohonan); $i++){
		
		$data = mysqli_query($conn_spri,"SELECT * FROM data_wna WHERE no_permohonan='$nomor_permohonan[$i]'");
		$d = mysqli_fetch_array($data);
		
		$no_permohonan="$d[no_permohonan]";
		$nomorhp="$d[no_hp]";
		$namapemohon="$d[nama_pemohon]";
		$no_dokim="$d[dokim_no]";
		$jenis_layanan="$d[nama_layanan]";
		$nomor_paspor="$d[no_paspor]";
		$niora="$d[niora]";
		$tgl_dokim="$d[dokim_akhir]";
		$tgl_now=date('Y-m-d');
		
		
		$target = "$nomorhp|$namapemohon|$no_permohonan|$no_dokim|$jenis_layanan|$nomor_paspor|$niora|$tgl_dokim";
		//$target = "$no_hp|$nama|$nomor_dokim|$dokim_akhir";
		 
		 $curl = curl_init();

		curl_setopt_array($curl, array(
		//  CURLOPT_URL => 'https://6f57-36-85-7-124.ngrok-free.app/wagate/public/send',
		 CURLOPT_URL => 'http://localhost/wagate/public/send',
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
		//echo $response;
		
		$sql = "INSERT INTO kirimpesan (nomor_permohonan,
							 tanggal_kirim,
							 nip_kirim)
					VALUES ('$no_permohonan',
							'$tgl_now',
							'$nip[$i]')";
		mysqli_query($conn, $sql);
	}
	?> 
			<script language='JavaScript'>
				alert('PESAN WHATSAPP BERHASIL DIKIRIM');
				document.location='view.php?module=peringatan';
			</script>
	<?php
}

//KIRIM KIRIM PESAN PERINGATAN KE WA
elseif ($module=='dokim' AND $act=='kirimpesanmanual'){
	$nomor_permohonan = $_POST['nomor_permohonan'];
	$nip = $_POST['nip'];
	$no_hp = $_POST['no_hp'];
	$jmlhari = $_POST['jmlhari'];
	
	$sql = mysqli_query($conn, "SELECT * FROM wa WHERE id_wa='1'");
	$s = mysqli_fetch_array($sql);
	$token = "$s[token]";
	$pesan = "$s[pesan_peringatan]";
	
	for($i=0; $i<sizeof ($nomor_permohonan); $i++){
		
		$cek = mysqli_query($conn,"SELECT a.*, b.* FROM arsip_paspor a LEFT JOIN dokim_wni b ON a.nomor_permohonan=b.nomor_permohonan
											       WHERE a.nomor_permohonan='$nomor_permohonan[$i]'");
												   
		 $c=mysqli_fetch_array($cek);
		 
		 $no_permohonan = "$c[nomor_permohonan]";
		 $nama = "$c[nama]";
		 $ket = "$c[keterangan]";
		 $nomor_paspor = "$c[nomor_paspor]";
		 $tanggal_input = "$c[tanggal_input]";
		 $tgl_now=date('Y-m-d');
		 $nomor_hp=$no_hp[$i];
		 $jumlahhari=$jmlhari[$i];


		$target = "$nomor_hp|$nama|$nama|$no_permohonan|$tanggal_input|$jumlahhari|$ket|$nomor_paspor";


		$curl = curl_init();

		curl_setopt_array($curl, array(
		 // CURLOPT_URL => 'https://6f57-36-85-7-124.ngrok-free.app/wagate/public/send',
		  CURLOPT_URL => 'http://localhost/wagate/public/send',
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
		//echo $response;
		
		if (!empty($no_hp[$i])) {
			$sql = "INSERT INTO kirimpesan (nomor_permohonan,
								 tanggal_kirim,
								 nip_kirim,
								 nomor_hp)
						VALUES ('$no_permohonan',
								'$tgl_now',
								'$nip[$i]',
								'$no_hp[$i]')";
			mysqli_query($conn, $sql);
		}
	
		?> 
				<script language='JavaScript'>
					alert('PESAN WHATSAPP BERHASIL DIKIRIM');
					document.location='view.php?module=peringatan';
				</script>
		<?php
	}
}
?>

