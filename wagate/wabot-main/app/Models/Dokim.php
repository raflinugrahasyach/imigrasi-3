<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dokim extends Model
{
    protected $table = 'dokim_wni';
    protected $primaryKey = 'nomor_permohonan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function arsip() : HasOne
    {
        return $this->hasOne(Arsip::class, 'nomor_permohonan', 'nomor_permohonan');
    }
}
