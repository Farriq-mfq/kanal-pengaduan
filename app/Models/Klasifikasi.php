<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    /** @use HasFactory<\Database\Factories\KlasifikasiFactory> */
    use HasFactory;

    protected $fillable = ['klasifikasi'];
}
