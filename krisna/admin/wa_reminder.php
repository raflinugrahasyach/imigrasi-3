<?php
// Versi Monitoring (Tombol Manual Dihapus)
// Halaman ini sekarang hanya untuk melihat siapa yang dijadwalkan hari ini
?>

<div class="page-header">
    <h3>Monitoring Pengingat WhatsApp (Otomatis)</h3>
</div>

<div class="alert alert-info" role="alert">
    <strong>Sistem Berjalan Otomatis:</strong> Pesan WhatsApp dikirim secara otomatis setiap hari kerja pukul 08:00 pagi melalui Task Scheduler. Tabel di bawah ini hanya untuk pemantauan.
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead style="background-color: #f8f9fa;">
            <tr>
                <th>No</th>
                <th>Nama Pemohon</th>
                <th>Nomor Telepon</th>
                <th>Tgl. Paspor Jadi</th>
                <th>Jadwal Reminder</th>
                <th>Status Sistem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $today = new DateTime('now');
            $today_str = $today->format('Y-m-d');
            
            $nomor = 1;
            $found_data = false;

            // Menggunakan query optimasi yang sama dengan robot
            $query = "SELECT dw.nomor_permohonan, dw.nama, dw.no_hp, dw.tanggal_input 
                      FROM dokim_wni dw
                      WHERE 
                        dw.tanggal_input >= DATE_SUB(CURDATE(), INTERVAL 40 DAY) AND
                        dw.no_hp IS NOT NULL AND dw.no_hp != ''
                      AND NOT EXISTS (
                          SELECT 1 
                          FROM arsip_paspor ap 
                          WHERE ap.nomor_permohonan = dw.nomor_permohonan AND ap.status = 'Serah'
                      )";
            
            $result = mysqli_query($conn, $query);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tanggal_input = new DateTime($row['tanggal_input']);
                    $reminder_days = [7, 14, 21, 28];
                    
                    foreach ($reminder_days as $days) {
                        $reminder_date = clone $tanggal_input;
                        $workdays_added = 0;
                        
                        // Logika hari kerja
                        while ($workdays_added < $days) {
                            $reminder_date->modify('+1 day');
                            $day_of_week = $reminder_date->format('N');
                            if ($day_of_week < 6) $workdays_added++;
                        }

                        // Logika weekend shift
                        $day_of_week_final = $reminder_date->format('N');
                        if ($day_of_week_final == 6) $reminder_date->modify('+2 days');
                        elseif ($day_of_week_final == 7) $reminder_date->modify('+1 day');

                        // Jika jadwal hari ini, tampilkan di tabel
                        if ($reminder_date->format('Y-m-d') == $today_str) {
                            $found_data = true;
            ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['no_hp']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_input'])); ?></td>
                                <td>
                                    <span class="badge badge-primary" style="background-color: #007bff; color: white; padding: 5px 10px; border-radius: 4px;">
                                        Hari ke-<?= $days; ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="color: green; font-weight: bold;">
                                        ✓ Terjadwal Otomatis
                                    </span>
                                </td>
                            </tr>
            <?php
                        }
                    }
                }
            }

            if (!$found_data) {
                echo "<tr><td colspan='6' align='center'>Tidak ada jadwal pengiriman reminder untuk hari ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<br>
<hr>
&copy; Developed by Y.Diantara