<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    protected $fillable = [
        'aduan_id',
        'keterangan',
    ];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }
}
