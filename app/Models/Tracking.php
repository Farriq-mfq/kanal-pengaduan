<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $fillable = ['keterangan', 'aduan_id', 'status', 'step'];

    public function aduan()
    {
        return $this->belongsTo(Aduan::class, 'aduan_id');
    }
}
