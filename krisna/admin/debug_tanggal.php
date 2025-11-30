<?php
// --- FILE DEBUGGING TANGGAL ---

// Mengatur zona waktu agar konsisten
date_default_timezone_set('Asia/Jakarta');

// 1. Meng-include koneksi database
include "../app/config.php";
echo "<h1>Memulai Debugging Logika Tanggal</h1>";
echo "<hr>";

// 2. GANTI NOMOR PERMOHONAN DI SINI
$nomor_permohonan_tes = 'TEST-REMINDER-003'; // <--- UBAH BARIS INI
$query = "SELECT nama, no_hp, tanggal_input FROM dokim_wni WHERE nomor_permohonan = '$nomor_permohonan_tes' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("<h2>ERROR: Data tes dengan nomor permohonan '{$nomor_permohonan_tes}' tidak ditemukan.</h2> <p>Pastikan Anda sudah menjalankan query INSERT dari langkah sebelumnya.</p>");
}

$row = mysqli_fetch_assoc($result);
echo "<h2>Data Ditemukan:</h2>";
echo "<pre>";
print_r($row);
echo "</pre>";
echo "<hr>";

// 3. Menjalankan Logika Perhitungan Tanggal (Sama persis seperti di wa_reminder.php)

$today = new DateTime('now');
echo "<h3>Tanggal Hari Ini (Pengecekan): " . $today->format('Y-m-d') . "</h3>";
echo "<hr>";

$tanggal_input = new DateTime($row['tanggal_input']);
$reminder_days = [7, 14, 21, 28];

foreach ($reminder_days as $days) {
    echo "<h4>--- Menghitung untuk Reminder Hari ke-{$days} ---</h4>";

    $reminder_date = clone $tanggal_input;
    echo "Tanggal Awal (Paspor Jadi): " . $reminder_date->format('Y-m-d (l)') . "<br>";

    $workdays_added = 0;
    echo "Memulai loop untuk menambah {$days} hari kerja...<br>";

    // Loop untuk menambah hari kerja
    while ($workdays_added < $days) {
        $reminder_date->modify('+1 day');
        $day_of_week = $reminder_date->format('N'); // 1 (Senin) - 7 (Minggu)

        echo "Iterasi: Tambah 1 hari -> " . $reminder_date->format('Y-m-d (l)');

        if ($day_of_week < 6) { // Jika Senin sampai Jumat
            $workdays_added++;
            echo " -> **Hari Kerja ke-{$workdays_added}**<br>";
        } else {
            echo " -> (Hari Libur, dilewati)<br>";
        }
    }

    echo "Selesai loop. Tanggal setelah ditambah {$days} hari kerja: " . $reminder_date->format('Y-m-d (l)') . "<br>";

    // Cek apakah jatuh di akhir pekan setelah loop
    $day_of_week_final = $reminder_date->format('N');
    if ($day_of_week_final == 6) { // Sabtu
        echo "Jatuh pada hari Sabtu, diundur ke Senin.<br>";
        $reminder_date->modify('+2 days');
    } elseif ($day_of_week_final == 7) { // Minggu
        echo "Jatuh pada hari Minggu, diundur ke Senin.<br>";
        $reminder_date->modify('+1 day');
    }

    echo "<b>Tanggal Final Kalkulasi: " . $reminder_date->format('Y-m-d (l)') . "</b><br>";

    // 4. Pengecekan Akhir
    if ($reminder_date->format('Y-m-d') == $today->format('Y-m-d')) {
        echo "<p style='color:green; font-weight:bold;'>HASIL: COCOK! Data ini seharusnya tampil di halaman.</p>";
    } else {
        echo "<p style='color:red; font-weight:bold;'>HASIL: TIDAK COCOK. Tanggal kalkulasi (" . $reminder_date->format('Y-m-d') . ") tidak sama dengan hari ini (" . $today->format('Y-m-d') . ").</p>";
    }
    echo "<hr>";
}

echo "<h2>Debugging Selesai.</h2>";
?>