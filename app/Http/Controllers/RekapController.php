<?php

namespace App\Http\Controllers;

use App\Exports\AduansExport;
use App\Models\Aduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function rekap()
    {
        $breadcrumbs = [
            [
                'link' => route("dashboard"),
                'name' => "Dashboard"
            ],
            [
                'link' => route("rekap"),
                'name' => "Rekapitulasi Aduan"
            ]
        ];
        return view('pages.rekap.index', compact('breadcrumbs'));
    }

    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_month' => 'required',
            'end_month' => 'required|after_or_equal:start_month',
            'type' => 'required|in:download,cetak'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $start_month = Carbon::parse($request->start_month)->locale('id');
        $end_month = Carbon::parse($request->end_month)->locale('id');

        $aduan = Aduan::whereNot('status_aduan', 'menunggu')->whereMonth('tanggal_pengaduan', '>=', $start_month->month)->whereMonth('tanggal_pengaduan', '<=', $end_month->month)->whereYear('tanggal_pengaduan', '>=', $start_month->year)->whereYear('tanggal_pengaduan', '<=', $end_month->year)->orderBy('id', 'asc')->get();

        $aduan_perbulan = $aduan->groupBy(function ($aduan) {
            return Carbon::parse($aduan->tanggal_pengaduan)->locale('id')->format('F Y');
        });

        // return view('pages.aduan.print', [
        //     'aduan_perbulan' => $aduan_perbulan,
        //     'total_pengaduan' => $aduan->count(),
        //     'start_month' => $start_month,
        //     'end_month' => $end_month
        // ]);
        if ($request->type == 'cetak') {
            return Pdf::loadView('pages.aduan.print', [
                'aduan_perbulan' => $aduan_perbulan,
                'total_pengaduan' => $aduan->count(),
                'start_month' => $start_month,
                'end_month' => $end_month
            ])->setPaper('folio', 'landscape')->download('rekap.pdf');
        } else if ($request->type == 'download') {
            return Excel::download(new AduansExport($aduan_perbulan, $aduan->count(), $start_month, $end_month), 'rekap.xlsx');
        } else {
            return redirect()->back();
        }
    }

}
