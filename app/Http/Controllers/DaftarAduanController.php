<?php

namespace App\Http\Controllers;

use App\DataTables\AduanDataTable;
use App\Models\Aduan;
use Illuminate\Http\Request;

class DaftarAduanController extends Controller
{
    public function index(AduanDataTable $dataTable)
    {
        $breadcrumbs = [
            [
                'link' => route("aduan.index"),
                'name' => "Daftar Aduan"
            ]
        ];

        return $dataTable->render('pages.aduan.index', compact('breadcrumbs'));
    }

    public function show(string $id)
    {
        $breadcrumbs = [
            [
                'link' => route("aduan.index"),
                'name' => "Daftar Aduan"
            ],
            [
                'link' => route("aduan.detail", $id),
                'name' => "Detail Aduan"
            ]
        ];

        $aduan = Aduan::findOrFail($id);

        return view('pages.aduan.detail', compact('breadcrumbs', 'aduan'));
    }

    public function accept(Request $request, string $id)
    {
        if (!$request->ajax()) return response()->json([
            'success' => false,
            'message' => 'Invalid request',
        ], 503);

        $aduan = Aduan::find($id);
        if (!$aduan) return response()->json([
            'success' => false,
            'message' => 'Aduan tidak ditemukan',
        ], 404);
        if ($aduan->status_aduan != 'menunggu' && $aduan->status_aduan != 'ditolak') return response()->json([
            'success' => false,
            'message' => 'Gagal menerima aduan',
        ], 400);

        $aduan->update([
            'status_aduan' => 'proses',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menerima aduan',
        ]);
    }
    public function reject(Request $request, string $id)
    {
        if (!$request->ajax()) return response()->json([
            'success' => false,
            'message' => 'Invalid request',
        ], 503);

        $aduan = Aduan::find($id);
        if (!$aduan) return response()->json([
            'success' => false,
            'message' => 'Aduan tidak ditemukan',
        ], 404);
        if ($aduan->status_aduan != 'menunggu' && $aduan->status_aduan != 'ditolak') return response()->json([
            'success' => false,
            'message' => 'Gagal menolak aduan',
        ], 400);

        $aduan->update([
            'status_aduan' => 'ditolak',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menolak aduan',
        ]);
    }
}
