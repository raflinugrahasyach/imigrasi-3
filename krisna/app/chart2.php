<?php
// Menggunakan __DIR__ untuk path include yang 100% andal
include __DIR__ . "/config.php";
date_default_timezone_set('Asia/Jakarta');

$tanggal = array();
$data = array(); // Inisialisasi array data

for ($i = 6; $i >= 0; $i--) {
    $tgl_loop = date('Y-m-d', strtotime("-$i days"));
    $tanggal[] = $tgl_loop; // Simpan tanggal untuk label

    // Pastikan koneksi ada sebelum query
    if ($conn) {
        $query = mysqli_query($conn, "SELECT COUNT(id) AS jumlah FROM arsip_paspor WHERE status = 'Serah' AND tanggal_serah = '$tgl_loop'");
        
        // Cek apakah query berhasil dan ambil data
        if($query && $row = mysqli_fetch_array($query)) {
            $data[$tgl_loop] = $row['jumlah'];
        } else {
            $data[$tgl_loop] = 0; // Jika query gagal, anggap 0
        }
    } else {
        $data[$tgl_loop] = 0; // Jika koneksi gagal, anggap 0
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chart Serah 7 Hari</title>
    <script src="js/Chart.js"></script>
</head>
<body>
    <canvas id="myChart"></canvas>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php foreach ($tanggal as $tgl) { echo "'" . date('d M', strtotime($tgl)) . "',"; } ?>],
                datasets: [{
                    label: 'Paspor Diserahkan',
                    data: [
                        <?php 
                        // Loop aman untuk menampilkan data
                        foreach ($tanggal as $tgl) {
                            // Cek jika data ada, jika tidak, cetak 0
                            echo isset($data[$tgl]) ? $data[$tgl] : 0;
                            echo ",";
                        } 
                        ?>
                    ],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: { 
                scales: { 
                    yAxes: [{ 
                        ticks: { 
                            beginAtZero:true,
                            // Memastikan hanya angka bulat (integer) yang tampil di sumbu Y
                            callback: function(value) { if (Number.isInteger(value)) { return value; } }
                        } 
                    }] 
                } 
            }
        });
    </script>
</body>
</html>