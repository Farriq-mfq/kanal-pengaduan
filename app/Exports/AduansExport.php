<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AduansExport implements FromView
{
    public $aduan_perbulan;
    public $total_pengaduan;
    public $start_month;
    public $end_month;
    public function __construct($aduan_perbulan, $total_pengaduan, $start_month, $end_month)
    {
        $this->aduan_perbulan = $aduan_perbulan;
        $this->total_pengaduan = $total_pengaduan;
        $this->start_month = $start_month;
        $this->end_month = $end_month;
    }
    public function view(): View
    {
        return view('pages.aduan.export', [
            'aduan_perbulan' => $this->aduan_perbulan,
            'total_pengaduan' => $this->total_pengaduan,
            'start_month' => $this->start_month,
            'end_month' => $this->end_month
        ]);
    }
}
