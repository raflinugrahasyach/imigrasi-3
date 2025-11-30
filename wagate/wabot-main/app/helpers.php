<?php

use App\Models\Dokim;
use Carbon\Carbon;

if (! function_exists('get_mergetags')) {
    function get_mergetags($model)
    {
        if (is_string($model))
            $model = Dokim::find($model);

        $tanggal = Carbon::parse($model->arsip->tanggal_input);
        $sekarang = Carbon::now();

        return [
            'nama' => $model->nama,
            'name' => $model->nama,
            'var1' => $model->nomor_permohonan,
            'var2' => $model->keterangan,
            'var3' => $model->nomor_paspor,
            'var4' => $model->arsip->tanggal_input,
            'var5' => round($tanggal->diffInDays($sekarang)),
            'var6' => $model->arsip->penerima,
            'var7' => $model->arsip->tanggal_serah,
        ];
    }
}

if (! function_exists('convert_message')) {
    function convert_message($message, $mergetags)
    {
        return preg_replace_callback(
            '/\{([^\}]+)\}/',
            function ($matches) use ($mergetags) {
                $key = $matches[1];
                return isset($mergetags[$key]) ? $mergetags[$key] : $matches[0];
            },
            $message
        );
    }
}

if (! function_exists('convert_message_target')) {
    function convert_message_target($message, $target)
    {
        $sequence = 0;
        return preg_replace_callback(
            '/\{([^\}]+)\}/',
            function ($matches) use (&$sequence, $target) {
                return isset($target[$sequence]) ? $target[$sequence++] : $matches[0];
            },
            $message
        );
    }
}

if (! function_exists('convert_phone')) {
    function convert_phone($phoneNumber)
    {
        if (substr($phoneNumber, 0, 1) === '0') {
            return '62' . substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }
}
