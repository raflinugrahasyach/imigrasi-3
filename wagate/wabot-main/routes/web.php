<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\PerintahController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Template
    Route::get('/template/notifikasi/{template?}', [TemplateController::class, 'editNotifikasi'])->name('template.notifikasi.edit');
    Route::patch('/template/notifikasi/{id}', [TemplateController::class, 'updateNotifikasi'])->name('template.notifikasi.update');
    Route::get('/template/autoresponse/{template?}', [TemplateController::class, 'editAutoresponse'])->name('template.autoresponse.edit');
    Route::patch('/template/autoresponse/{id}', [TemplateController::class, 'updateAutoresponse'])->name('template.autoresponse.update');

    Route::resource('perintah', PerintahController::class);
});

Route::post('/send', [MessageController::class, 'send'])->name('message.send');
Route::post('/webhook', [WebhookController::class, 'handle'])->name('webhook.handle');

require __DIR__.'/auth.php';

// =================================================================
// RUTE API BARU UNTUK MENGIRIM PESAN DARI APLIKASI KRISNA
// =================================================================
Route::post('/api/send-message', [MessageController::class, 'sendMessageApi']);