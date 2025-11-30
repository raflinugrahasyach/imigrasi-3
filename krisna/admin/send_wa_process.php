<?php
include_once '../app/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor_permohonan = $_POST['nomor_permohonan'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $message_type = $_POST['message_type'];

    // 1. Ambil Token (sekarang Token Fonnte) dari database
    $query_wa = "SELECT token, pesan_peringatan FROM wa LIMIT 1";
    $result_wa = mysqli_query($conn, $query_wa);
    $data_wa = mysqli_fetch_assoc($result_wa);
    $token = $data_wa['token'];
    
    // 2. Siapkan template pesan
    $message = "Yth. Bapak/Ibu {$name},\n\nKami mengingatkan Anda untuk segera mengambil paspor Anda yang telah selesai dicetak.\n\nTerima kasih,\nKantor Imigrasi";
    
    if (!empty($data_wa['pesan_peringatan'])) {
        $message = str_replace(
            ['{nama}', '{name}'],
            [$name, $name],
            $data_wa['pesan_peringatan']
        );
    }

    // --- LOGIKA KIRIM WHATSAPP BARU (FONNTE) ---

    $curl = curl_init();

    // Data yang dikirim disesuaikan dengan format Fonnte
    // 'target' untuk nomor HP, 'message' untuk isi pesan
    $payload = [
        'target' => $phone,
        'message' => $message
    ];

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.fonnte.com/send", // 3. URL Endpoint Fonnte
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => http_build_query($payload), // Fonnte menggunakan format form-urlencoded
      CURLOPT_HTTPHEADER => array(
        "Authorization: " . $token // 4. Token Fonnte diletakkan di header
      ),
    ));

    $result = curl_exec($curl);
    curl_close($curl);
    
    $response = json_decode($result, true);

    // 5. Penyesuaian pengecekan status
    // Fonnte biasanya merespon dengan 'status' => true jika berhasil
    if ($response && isset($response['status']) && $response['status'] == true) {
        header("Location: view.php?module=wa_reminder&status=success&name=" . urlencode($name));
    } else {
        $error_message = isset($response['reason']) ? $response['reason'] : (isset($response['message']) ? $response['message'] : "Gagal terhubung ke Fonnte.");
        header("Location: view.php?module=wa_reminder&status=error&name=" . urlencode($name) . "&error=" . urlencode($error_message));
    }
    exit();

} else {
    header("Location: view.php");
    exit();
}
?>