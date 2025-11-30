<?php

namespace App\Http\Controllers;

use App\Models\Autoresponse;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function editNotifikasi(Template $template = null)
    {
        if (is_null($template)) {
            $template = Template::first();
        }

        return View('template.notifikasi', compact('template'));
    }

    public function updateNotifikasi(Request $request, $id)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if ($id == 0) {
            Template::create([
                'id_wa' => 1,
                'token' => $request->input('token') ?? '',
                'pesan' => $request->input('pesan') ?? '',
                'pesan_peringatan' => $request->input('peringatan') ?? '',
                'pesan_tikim' => '',
                'pesan_intel' => ''
            ]);
        } else {
            $template = Template::findOrFail($id);

            $template->update([
                'token' => $request->input('token') ?? '',
                'pesan' => $request->input('pesan') ?? '',
                'pesan_peringatan' => $request->input('peringatan') ?? ''
            ]);
        }

        return Redirect::route('template.notifikasi.edit')->with('status', 'template-update');
    }

    private function updateTokenInEnv($token)
    {
        $path = base_path('.env');
        $content = File::get($path);

        if (strpos($content, 'WABLAS_TOKEN=') !== false) {
            $content = preg_replace('/(WABLAS_TOKEN=)(.*)/', "WABLAS_TOKEN=$token", $content);
        } else {
            $content .= "\nWABLAS_TOKEN=$token";
        }

        File::put($path, $content);
    }


    // Autoresponse
    public function editAutoresponse(Template $template = null) : View
    {
        if (is_null($template)) {
            $template = Autoresponse::first();
        }

        return View('template.autoresponse', compact('template'));
    }

    public function updateAutoresponse(Request $request, $id) : RedirectResponse
    {
        if ($id == 0) {
            Autoresponse::create([
                'id' => 1,
                'kosong' => $request->input('kosong') ?? '',
                'belum_diambil' => $request->input('belum') ?? '',
                'sudah_diambil' => $request->input('sudah') ?? '',
            ]);
        } else {
            $template = Autoresponse::findOrFail($id);

            $template->update([
                'kosong' => $request->input('kosong') ?? '',
                'belum_diambil' => $request->input('belum') ?? '',
                'sudah_diambil' => $request->input('sudah') ?? ''
            ]);
        }

        return Redirect::route('template.autoresponse.edit')->with('status', 'template-update');
    }
}
