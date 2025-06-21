<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = [
        'name',
        'panduan',
    ];

    public function aduan()
    {
        return $this->hasMany(Aduan::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
