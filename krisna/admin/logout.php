<?php

	session_start();
	session_destroy();
	echo "<center>Anda telah sukses keluar sistem <b>[LOGOUT]<b><br>";
	echo "<a href=index.php><b>[Login Lagi]</b></a></center>";
 
?>
