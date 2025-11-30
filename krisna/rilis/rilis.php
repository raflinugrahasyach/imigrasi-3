<script language="JavaScript">
	function toggle(source) {
	  checkboxes = document.getElementsByName('foo[ ]');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	  }
	}
</script>

<?php
include_once '../app/config.php';

if($_GET['module'] == 'form'){
	$cari = mysqli_query($conn,"SELECT * FROM dokim_wni WHERE nomor_permohonan NOT IN (SELECT nomor_permohonan FROM arsip_paspor)");
	$jc = mysqli_num_rows($cari);
	echo"<div align='center'>
		 <h3>RILIS DATA ERROR</h3>";
	if($jc > 0){
		echo"<p>Terdapat $jc Data Error Pada Aplikasi KRISNA : </p>";
	}else{
		echo"<p>Tidak Terdapat Data Error Pada Aplikasi KRISNA</p>";
	}

	echo"<table border='1'>
			<thead bgcolor='yellow'>
			  <tr align='center'>
				<th></span><input type='checkbox' onClick='toggle(this)' /></th>
				<th width='150'>NOMOR PERMOHONAN</span></th>
				<th width='400'>NAMA</span></th>
			  </tr>
			</thead>
			<tbody>";
	while ($c = mysqli_fetch_array($cari)){
		echo"<form method=POST enctype='multipart/form-data' action='rilis.php?module=hapus'>";
		echo"<tr>
				<td align='center'><input type='checkbox' name='foo[ ]' value='$c[nomor_permohonan]'></td>
				<td align='center'>$c[nomor_permohonan]</td>
				<td align='center'>$c[nama]</td>
			</tr>";
	}
	echo"</tbody></table>";
	
	echo"<br><br><input type='submit' name='save' value='RILIS' style='height:30px';>";
	echo"</div>";
}

elseif($_GET['module'] == 'hapus'){
	$nomor_permohonan = $_POST['foo'];
	
	//SET TGL NIP PENGIRIM ARSIP
	for($i=0; $i<sizeof ($nomor_permohonan); $i++){
		//echo"$nomor_permohonan[$i]<br>";
		
		$hapus = "DELETE FROM dokim_wni WHERE nomor_permohonan='$nomor_permohonan[$i]'";
		
		//JIKA BERHASIL INPUT LOG KIRIM FILE ARSIP
		if (mysqli_query($conn, $hapus)) {
				//redirect ke halaman index.php
				?>
					<script language='JavaScript'>
						alert('DATA ERROR BERHASIL DIRILIS');
						document.location='index.php';
					</script>
				<?php
		//JIKA GAGAL INPUT LOG KIRIM FILE ARSIP
		}else {
			echo "Error: " . $sql . "
			" . mysqli_error($conn);
		 }
	}
}
?>