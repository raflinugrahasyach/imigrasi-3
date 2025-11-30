<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Autoresponse;
use App\Models\Dokim;
use App\Models\Perintah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    private $defaultResponse = <<<EOD
Selamat Datang di Layanan *MELAWAI* (Memberikan pElayanan meLAlui WhatsApp Imigrasi) *Kantor Imigrasi Balikpapan.*
*Menu layanan:*
- untuk mengetahui status paspor ketik : STATUS nomor permohonan paspor (contoh : *STATUS 1179000000XXXXXX*)
- untuk mengetahui persyaratan paspor ketik : *PERSYARATAN*
- untuk mengetahui biaya pembuatan paspor ketik : *BIAYA*
- untuk mengetahui prosedur pembuatan paspor ketik : *PROSEDUR*
- untuk mengetahui persyaratan paspor hilang/rusak ketik : *HILANG RUSAK*

Jika anda memiliki pertanyaan, kritik dan saran, silahkan hubungi nomor +62 811-5925-151
EOD;

    private function sendResponse($message)
    {
        return response($message)->header('Content-Type', 'text/plain');
    }

    public function handle(Request $request)
    {
        $message = $request->input('message');

        // Check if message not blank
        if (blank($message))
            return $this->sendResponse('Pesan tidak boleh kosong');

        $message = preg_replace('/\s+/', ' ', $message);
        $message = explode(' ', $message);

        // Search whether the command is found
        $command = Perintah::where('nama', $message[0])->first();
        if (!is_null($command))
            return $this->sendResponse($command->pesan);

        // Command specific logic
        switch (strtolower($message[0])) {
            case 'status':
                return $this->handleStatusCommand($message);
            default:
                return $this->sendResponse($this->defaultResponse);
        }
    }

    private function handleStatusCommand($message)
    {
        if (count($message) < 2)
            return $this->sendResponse($this->defaultResponse);

        $nomor_permohonan = $message[1];
        $dokim = Dokim::find($nomor_permohonan);
        $autoresponse = Autoresponse::first();

        if (!is_null($dokim))
            $mergetags = get_mergetags($dokim);

        $content = match ($dokim?->arsip?->status) {
            'Aktif' => convert_message($autoresponse->belum_diambil, $mergetags),
            'Serah' => convert_message($autoresponse->sudah_diambil, $mergetags),
            default => $autoresponse->kosong,
        };

        return $this->sendResponse($content);
    }
}
