<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Arsip extends Model
{
    protected $table = 'arsip_paspor';
    protected $primaryKey = 'nomor_permohonan';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function dokim() : BelongsTo
    {
        return $this->belongsTo(Dokim::class, 'nomor_permohonan', 'nomor_permohonan');
    }
}
