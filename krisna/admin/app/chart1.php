<?php
include_once '../app/config.php';
?>
<script src="js/Chart.js"></script>
	<canvas id="myChart"></canvas> <?php 
	$nama_jurusan= "";
    $jumlah=null;
	$tgl_awal=date('Y-m-d', strtotime('-7 day', strtotime(date('Y-m-d'))));
	
	
	$sql="select tanggal_input,COUNT(*) as 'total' FROM arsip_paspor
													   WHERE tanggal_input > '$tgl_awal'
													   GROUP by tanggal_input ORDER by tanggal_input";
    $hasil=mysqli_query($conn,$sql);
	 while ($data = mysqli_fetch_array($hasil)) {
        //Mengambil nilai jurusan dari database
        $jur=$data['tanggal_input'];
        $nama_jurusan .= "'$jur'". ", ";
        //Mengambil nilai total dari database
        $jum=$data['total'];
        $jumlah .= "$jum". ", ";
	 }?>
	 <canvas height="50"></canvas>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        // The data for our dataset
        data: {
            labels: [<?php echo $nama_jurusan; ?>],
            datasets: [{
                label:' ',
                backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)','rgb(175, 238, 239)','rgb(100, 100, 150)','rgb(180, 43, 214)','rgb(148, 194, 56)'],
                borderColor: ['rgb(255, 99, 132)'],
                data: [<?php echo $jumlah; ?>]
            }]
        },

        // Configuration options go here
        options: {
			"responsive": true,
			"maintainAspectRatio": false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>