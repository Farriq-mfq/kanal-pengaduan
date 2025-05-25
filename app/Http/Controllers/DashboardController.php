<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Klasifikasi;
use App\Models\Masyarakat;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            [
                'link' => route("dashboard"),
                'name' => "Dashboard"
            ]
        ];

        $latest_aduan = Aduan::orderBy('id', 'DESC')->limit(5)->get();

        return view('pages.dashboard', compact('breadcrumbs', 'latest_aduan'));
    }

    public function json_stats_count(Request $request)
    {
        if (!$request->ajax())
            return response()->json("not allowed", 503);

        $stats = [
            'total_pengaduan' => Aduan::count(),
            'total_masyarakat' => Masyarakat::count(),
            'total_users' => User::count(),
            'total_klasifikasi' => Klasifikasi::count()
        ];
        return response()->json($stats);
    }

    public function json_stats_aduan()
    {
        $aduans_proses = Aduan::where('status_aduan', 'proses')->whereYear('tanggal_pengaduan', date('Y'))->get();
        $aduans_menunggu = Aduan::where('status_aduan', 'menunggu')->whereYear('tanggal_pengaduan', date('Y'))->get();
        $aduans_ditolak = Aduan::where('status_aduan', 'ditolak')->whereYear('tanggal_pengaduan', date('Y'))->get();
        $aduans_selesai = Aduan::where('status_aduan', 'selesai')->whereYear('tanggal_pengaduan', date('Y'))->get();

        $aduans_proses_perbulan = [
            "Jan" => $this->getAduanPermonth($aduans_proses, 1),
            "Feb" => $this->getAduanPermonth($aduans_proses, 2),
            "Mar" => $this->getAduanPermonth($aduans_proses, 3),
            "Apr" => $this->getAduanPermonth($aduans_proses, 4),
            "May" => $this->getAduanPermonth($aduans_proses, 5),
            "Jun" => $this->getAduanPermonth($aduans_proses, 6),
            "Jul" => $this->getAduanPermonth($aduans_proses, 7),
            "Aug" => $this->getAduanPermonth($aduans_proses, 8),
            "Sep" => $this->getAduanPermonth($aduans_proses, 9),
            "Oct" => $this->getAduanPermonth($aduans_proses, 10),
            "Nov" => $this->getAduanPermonth($aduans_proses, 11),
            "Dec" => $this->getAduanPermonth($aduans_proses, 12)
        ];
        $aduans_menunggu_perbulan = [
            "Jan" => $this->getAduanPermonth($aduans_menunggu, 1),
            "Feb" => $this->getAduanPermonth($aduans_menunggu, 2),
            "Mar" => $this->getAduanPermonth($aduans_menunggu, 3),
            "Apr" => $this->getAduanPermonth($aduans_menunggu, 4),
            "May" => $this->getAduanPermonth($aduans_menunggu, 5),
            "Jun" => $this->getAduanPermonth($aduans_menunggu, 6),
            "Jul" => $this->getAduanPermonth($aduans_menunggu, 7),
            "Aug" => $this->getAduanPermonth($aduans_menunggu, 8),
            "Sep" => $this->getAduanPermonth($aduans_menunggu, 9),
            "Oct" => $this->getAduanPermonth($aduans_menunggu, 10),
            "Nov" => $this->getAduanPermonth($aduans_menunggu, 11),
            "Dec" => $this->getAduanPermonth($aduans_menunggu, 12)
        ];

        $aduans_ditolak_perbulan = [
            "Jan" => $this->getAduanPermonth($aduans_ditolak, 1),
            "Feb" => $this->getAduanPermonth($aduans_ditolak, 2),
            "Mar" => $this->getAduanPermonth($aduans_ditolak, 3),
            "Apr" => $this->getAduanPermonth($aduans_ditolak, 4),
            "May" => $this->getAduanPermonth($aduans_ditolak, 5),
            "Jun" => $this->getAduanPermonth($aduans_ditolak, 6),
            "Jul" => $this->getAduanPermonth($aduans_ditolak, 7),
            "Aug" => $this->getAduanPermonth($aduans_ditolak, 8),
            "Sep" => $this->getAduanPermonth($aduans_ditolak, 9),
            "Oct" => $this->getAduanPermonth($aduans_ditolak, 10),
            "Nov" => $this->getAduanPermonth($aduans_ditolak, 11),
            "Dec" => $this->getAduanPermonth($aduans_ditolak, 12)
        ];
        $aduans_selesai_perbulan = [
            "Jan" => $this->getAduanPermonth($aduans_selesai, 1),
            "Feb" => $this->getAduanPermonth($aduans_selesai, 2),
            "Mar" => $this->getAduanPermonth($aduans_selesai, 3),
            "Apr" => $this->getAduanPermonth($aduans_selesai, 4),
            "May" => $this->getAduanPermonth($aduans_selesai, 5),
            "Jun" => $this->getAduanPermonth($aduans_selesai, 6),
            "Jul" => $this->getAduanPermonth($aduans_selesai, 7),
            "Aug" => $this->getAduanPermonth($aduans_selesai, 8),
            "Sep" => $this->getAduanPermonth($aduans_selesai, 9),
            "Oct" => $this->getAduanPermonth($aduans_selesai, 10),
            "Nov" => $this->getAduanPermonth($aduans_selesai, 11),
            "Dec" => $this->getAduanPermonth($aduans_selesai, 12)
        ];

        $total_aduan_tahunan = Aduan::whereYear('tanggal_pengaduan', date('Y'))->count();

        return response()->json([
            'aduan_proses_perbulan' => $aduans_proses_perbulan,
            'aduan_menunggu_perbulan' => $aduans_menunggu_perbulan,
            'aduan_tolak_perbulan' => $aduans_ditolak_perbulan,
            'aduan_selesai_perbulan' => $aduans_selesai_perbulan,
            'total_aduan_tahunan' => $total_aduan_tahunan
        ]);
    }

    protected function getAduanPermonth($data, int $month)
    {
        return $data->filter(function ($aduan) use ($month) {
            return \Carbon\Carbon::parse($aduan->tanggal_pengaduan)->month == $month;
        })->count();
    }

}
