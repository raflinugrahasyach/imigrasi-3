<?php
echo "<h3>Mencoba Menghubungi Server Gateway...</h3>";

$apiUrl = "http://127.0.0.1:8000/api/send-message";
$data = ['nomor' => '123', 'pesan' => 'test'];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

echo "Mengirim permintaan ke: " . $apiUrl . "<br>";

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);

if ($curl_error) {
    echo "<h4>HASIL: GAGAL TOTAL</h4>";
    echo "<p style='color:red; font-weight:bold;'>Error cURL: " . $curl_error . "</p>";
    echo "<p>Ini artinya aplikasi Krisna sama sekali tidak bisa 'berbicara' dengan aplikasi Wagate. Masalah ini 99% disebabkan oleh Firewall atau Antivirus yang memblokir koneksi antar aplikasi di komputer Anda.</p>";
} else {
    echo "<h4>HASIL: BERHASIL TERHUBUNG!</h4>";
    echo "<p style='color:green; font-weight:bold;'>Server Wagate merespon dengan Kode HTTP: " . $http_code . "</p>";
    echo "Respon dari server:<br>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    echo "<p>Jika Anda melihat ini, artinya koneksi BERHASIL dan masalahnya ada di tempat lain. Namun jika error Curl masih muncul di halaman reminder, ini aneh.</p>";
}

curl_close($ch);
?>