<?php
// --- FILE ROBOT PENGIRIM WA OTOMATIS (FONNTE) ---
// File ini dijalankan oleh Windows Task Scheduler

// 1. Setup Lingkungan
date_default_timezone_set('Asia/Jakarta');
// Include koneksi database (Path relatif dari folder admin)
require_once __DIR__ . '/../app/config.php';

echo "--- MEMULAI PROSES REMINDER OTOMATIS: " . date('Y-m-d H:i:s') . " ---\n";

// 2. Cek Koneksi
if (!$conn) {
    die("FATAL ERROR: Koneksi database gagal: " . mysqli_connect_error() . "\n");
}

// 3. Ambil Token Fonnte & Template Pesan
$query_wa = "SELECT token, pesan_peringatan FROM wa LIMIT 1";
$result_wa = mysqli_query($conn, $query_wa);
$data_wa = mysqli_fetch_assoc($result_wa);

$token = $data_wa['token'];
$template_pesan_db = $data_wa['pesan_peringatan'];

if (empty($token)) {
    die("ERROR: Token Fonnte kosong. Cek tabel 'wa'.\n");
}

// 4. Cari Target Pengiriman Hari Ini
$today = new DateTime('now');
$today_str = $today->format('Y-m-d');
echo "Target Tanggal: $today_str\n";

// Query Optimasi: Hanya ambil data 40 hari terakhir yang belum diserahkan
$query_target = "SELECT dw.nomor_permohonan, dw.nama, dw.no_hp, dw.tanggal_input 
                 FROM dokim_wni dw
                 WHERE dw.tanggal_input >= DATE_SUB(CURDATE(), INTERVAL 40 DAY) 
                 AND dw.no_hp IS NOT NULL AND dw.no_hp != ''
                 AND NOT EXISTS (
                    SELECT 1 FROM arsip_paspor ap 
                    WHERE ap.nomor_permohonan = dw.nomor_permohonan AND ap.status = 'Serah'
                 )";

$result_target = mysqli_query($conn, $query_target);
$count_sukses = 0;
$count_gagal = 0;

if ($result_target) {
    while ($row = mysqli_fetch_assoc($result_target)) {
        $tanggal_input = new DateTime($row['tanggal_input']);
        $reminder_days = [7, 14, 21, 28]; // Jadwal reminder
        $kirim_hari_ini = false;
        $reminder_ke = 0;

        // Hitung Tanggal Jadwal
        foreach ($reminder_days as $days) {
            $reminder_date = clone $tanggal_input;
            $workdays_added = 0;
            
            // Logika tambah hari kerja
            while ($workdays_added < $days) {
                $reminder_date->modify('+1 day');
                $day_of_week = $reminder_date->format('N'); 
                if ($day_of_week < 6) { // Senin-Jumat
                    $workdays_added++;
                }
            }

            // Logika geser weekend ke senin
            $day_of_week_final = $reminder_date->format('N');
            if ($day_of_week_final == 6) { // Sabtu -> Senin
                $reminder_date->modify('+2 days');
            } elseif ($day_of_week_final == 7) { // Minggu -> Senin
                $reminder_date->modify('+1 day');
            }

            // Cek apakah jadwalnya HARI INI
            if ($reminder_date->format('Y-m-d') == $today_str) {
                $kirim_hari_ini = true;
                $reminder_ke = $days;
                break; // Keluar loop jika sudah ketemu jadwal hari ini
            }
        }

        // 5. Eksekusi Pengiriman Jika Jadwal Cocok
        if ($kirim_hari_ini) {
            $nama = $row['nama'];
            $phone = $row['no_hp'];
            
            echo "Mengirim ke: $nama ($phone) - Reminder Hari ke-$reminder_ke... ";

            // Siapkan Pesan
            $message = "Yth. Bapak/Ibu {$nama},\n\nKami mengingatkan Anda untuk segera mengambil paspor Anda yang telah selesai dicetak.\n\nTerima kasih,\nKantor Imigrasi";
            if (!empty($template_pesan_db)) {
                $message = str_replace(['{nama}', '{name}'], [$nama, $nama], $template_pesan_db);
            }

            // Kirim via API Fonnte (cURL)
            $curl = curl_init();
            $payload = [
                'target' => $phone,
                'message' => $message,
            ];

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.fonnte.com/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($payload),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));

            $response = curl_exec($curl);
            $curl_error = curl_error($curl);
            curl_close($curl);
            
            $json_resp = json_decode($response, true);

            if ($json_resp && isset($json_resp['status']) && $json_resp['status'] == true) {
                echo "[BERHASIL]\n";
                $count_sukses++;
            } else {
                $reason = isset($json_resp['reason']) ? $json_resp['reason'] : "Unknown Error";
                echo "[GAGAL: $reason]\n";
                $count_gagal++;
            }

            // Jeda 3 detik agar Fonnte tidak menganggap spam
            sleep(3);
        }
    }
} else {
    echo "Query Error: " . mysqli_error($conn) . "\n";
}

echo "--- SELESAI. Sukses: $count_sukses, Gagal: $count_gagal ---\n";
?>