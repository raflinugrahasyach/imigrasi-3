<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'wa';
    protected $primaryKey = 'id_wa';
    public $timestamps = false;

    protected $guarded = [];
}
