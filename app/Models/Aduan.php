<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    /** @use HasFactory<\Database\Factories\AduanFactory> */
    use HasFactory;

    protected $fillable = [
        'uraian_pengaduan',
        'nomer_aduan',
        'text_direct_pengaduan',
        'tanggal_pengaduan',
        'status_aduan',
        'alasan_penolakan',
        'tindak_lanjut',
        'kecepatan_tindak_lanjut',
        'klasifikasi',
        'kepala_bidang_id',
        'tanggal_tindak_lanjut_kepala_bidang',
        'verifikasi_kepala_bidang',
        'uraian_tindak_lanjut_kepala_bidang',
        'telaah_aduan',
        'kepala_dinas_id',
        'tanggal_tindak_lanjut_kepala_dinas',
        'verifikasi_kepala_dinas',
        'masyarakat_id',
        'status_mediasi',
        'tanggal_mediasi',
        'uraian_mediasi',
        'status_disampaikan',
        'tanggal_disampaikan',
        'tanggapan',
        'status_penyelesaian',
        'is_view',
    ];
}
