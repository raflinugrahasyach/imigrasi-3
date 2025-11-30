<?php
session_start();
include_once '../app/config.php';
$module=$_GET['module'];
$act=$_GET['act'];
date_default_timezone_set("Asia/SIngapore");

//INPUT USER
if ($module=='user' AND $act=='input'){
	$nip=$_POST['nip'];
	$nama=$_POST['nama'];
	$seksi=$_POST['seksi'];
	$password=md5($_POST['password']);
	
	$sql = "INSERT INTO user (	nip,
								nama,
								password,
								status,
								seksi)
						VALUES ('$nip',
								'$nama',
								'$password',
								'Aktif',
								'$seksi')";
	
	 
		if (mysqli_query($conn, $sql)) {?> 
			<script language='JavaScript'>
				alert('USER BARU BERHASIL DITAMBAHKAN KE SISTEM');
				document.location='view.php?module=manajemenuser';
			</script><?php
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
}

//EDIT USER
elseif ($module=='user' AND $act=='edit'){
	$nip=$_POST['nip'];
	$nama=$_POST['nama'];
	$status=$_POST['status'];
	$seksi=$_POST['seksi'];
	
	if (empty($_POST['password'])) {
		$sql = "UPDATE user SET nama='$nama',
								status='$status',
								seksi='$seksi'
				WHERE nip='$nip'";
	}else{
	$password=md5($_POST['password']);
	$sql = "UPDATE user SET nama='$nama',
							 password='$password',
							 status='$status',
								seksi='$seksi'
			WHERE nip='$nip'";
	}
	 
		if (mysqli_query($conn, $sql)) {?> 
			<script language='JavaScript'>
				alert('DATA USER BERHASIL DIUBAH');
				document.location='view.php?module=manajemenuser';
			</script><?php
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
}

//INPUT RAK
if ($module=='rak' AND $act=='input'){
	$nomor_rak=$_POST['nomor_rak'];
	$kuota=$_POST['kuota'];
	$lokasi=$_POST['lokasi'];
	
	$sql = "INSERT INTO rak (	nomor_rak,
								kuota,
								lokasi)
						VALUES ('$nomor_rak',
								'$kuota',
								'$lokasi')";
	
	 
		if (mysqli_query($conn, $sql)) {?> 
			<script language='JavaScript'>
				alert('NOMOR RAK BARU BERHASIL DITAMBAHKAN KE SISTEM');
				document.location='view.php?module=manajemenrak';
			</script><?php
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
}

//EDIT RAK
elseif ($module=='rak' AND $act=='edit'){
	$nomor_rak=$_POST['nomor_rak'];
	$kuota=$_POST['kuota'];
	$lokasi=$_POST['lokasi'];
	

	$sql = "UPDATE rak SET kuota='$kuota', lokasi='$lokasi'
			WHERE nomor_rak='$nomor_rak'";
	 
		if (mysqli_query($conn, $sql)) {?> 
			<script language='JavaScript'>
				alert('KUOTA RAK BERHASIL DIUBAH');
				document.location='view.php?module=manajemenrak';
			</script><?php
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
}

//DELETE RAK
elseif ($module=='rak' AND $act=='hapus'){
	$nomor_rak=$_GET['nomor_rak'];
	$sql = "DELETE FROM rak WHERE nomor_rak='$nomor_rak'";
	
	if (mysqli_query($conn, $sql)) { ?>
		<script language='JavaScript'>
                        alert('DATA RAK BERHASIL DIHAPUS');
                        document.location='view.php?module=manajemenrak';
                    </script>
  <?php 
  //header('location:laporan.php?module=data');
  }
  else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
}


//EDIT PASSWORD ADMIN
elseif ($module=='admin' AND $act=='edit'){
	$username=$_POST['username'];
	$password=md5($_POST['password']);
	

	$sql = "UPDATE admin SET password='$password'
			WHERE username='$username'";
	 
		if (mysqli_query($conn, $sql)) {?> 
			<script language='JavaScript'>
				alert('PASSWORD ADMINISTRATOR BERHASIL DIUBAH');
				document.location='view.php?module=passwordadmin';
			</script><?php
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
}

//EDIT PESAN
elseif ($module=='pesan' AND $act=='edit'){
	$token=$_POST['token'];
	$pesan=$_POST['pesan'];
	$pesan_tikim=$_POST['pesan_tikim'];
	$pesan_intel=$_POST['pesan_intel'];
	$pesan_percepatan=$_POST['pesan_percepatan'];
	$pesan_peringatan=$_POST['pesan_peringatan'];
	$id_wa=$_POST['id_wa'];
	

	$sql = "UPDATE wa SET token='$token', pesan='$pesan', pesan_percepatan='$pesan_percepatan', pesan_tikim='$pesan_tikim', pesan_intel='$pesan_intel', pesan_peringatan='$pesan_peringatan'
			WHERE id_wa='$id_wa'";
	 
		if (mysqli_query($conn, $sql)) {?> 
			<script language='JavaScript'>
				alert('SETTING PESAN BERHASIL DIUBAH');
				document.location='view.php?module=manajemenwa';
			</script><?php
		}else{
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		}
	 mysqli_close($conn);
}
?>

