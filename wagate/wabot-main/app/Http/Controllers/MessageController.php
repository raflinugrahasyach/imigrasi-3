<?php

namespace App\Http\Controllers;

use App\Libraries\Wablas\Wablas;
use App\Libraries\Wablas\WablasMessage;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Fungsi bantu untuk merespons JSON standar.
     */
    private function sendResponse($status, $message)
    {
        return response()->json([
            'status' => $status,
            'reason' => $message
        ]);
    }

    /**
     * FUNGSI UTAMA: Mengirim pesan dari form internal aplikasi.
     */
    public function send(Request $request)
    {
        $request->validate([
            'target' => 'required',
            'message' => 'required'
        ]);

        $mergetags = explode('|', $request->input('target'));
        $phone = convert_phone(array_shift($mergetags));

        $message = (count($mergetags) > 0)
            ? convert_message_target($request->input('message'), $mergetags)
            : $request->input('message');

        $template = Template::first();
        $token = $template ? $template->token : config('wablas.token');

        try {
            $pesan = WablasMessage::create()
                ->to($phone)
                ->content($message)
                ->toArray();

            $wablas = new Wablas();
            $wablas->setToken($token)->sendMessage($pesan);

            return $this->sendResponse(true, 'success');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->sendResponse(false, 'something went wrong');
        }
    }

    /**
     * FUNGSI BARU UNTUK MENANGANI API DARI KRISNA (SUDAH DIPERBAIKI)
     * Endpoint ini menerima request JSON dengan field:
     * - nomor : string nomor tujuan (misal "6281234567890")
     * - pesan : isi pesan yang ingin dikirim
     */
    public function sendMessageApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'required|string',
            'pesan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }

        try {
            // Membuat data pesan sesuai format yang dibutuhkan library Wablas
            $pesanData = WablasMessage::create()
                ->to($request->nomor)
                ->content($request->pesan)
                ->toArray();

            $wablas = new Wablas();
            $response = $wablas->sendMessage($pesanData);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            if (isset($responseBody['status']) && $responseBody['status'] === 'success') {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Pesan berhasil dikirim via Gateway.',
                    'data' => $responseBody['data'] ?? null
                ], 200);
            } else {
                $errorMessage = $responseBody['message'] ?? 'Terjadi kesalahan dari API Wablas.';
                Log::error('Wablas API Error: ', $responseBody);
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Exception in sendMessageApi: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server gateway: ' . $e->getMessage()
            ], 500);
        }
    }
}