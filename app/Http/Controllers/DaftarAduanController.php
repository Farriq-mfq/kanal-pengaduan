<?php

namespace App\Http\Controllers;

use App\DataTables\AduanDataTable;
use App\Models\Aduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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


        $kepala_bidang = User::whereHas('roles', function ($query) {
            $query->where('name', 'kepala bidang');
        })->get();

        return $dataTable->render('pages.aduan.index', compact('breadcrumbs', 'kepala_bidang'));
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

    public function destroy(string $id)
    {
        $aduan = Aduan::find($id);
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);
        $aduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus aduan',
        ]);
    }

    public function accept(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $aduan = Aduan::find($id);
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);
        if ($aduan->status_aduan != 'menunggu' && $aduan->status_aduan != 'ditolak')
            return response()->json([
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
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $aduan = Aduan::find($id);
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);
        if ($aduan->status_aduan != 'menunggu' && $aduan->status_aduan != 'ditolak')
            return response()->json([
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

    public function continue(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);


        $validator = Validator::make($request->all(), [
            'kepala_bidang_id' => 'required|exists:users,id',
        ], [
            'kepala_bidang_id.required' => 'Kepala bidang harus diisi',
            'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $aduan = Aduan::find($id);
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);
        if ($aduan->status_aduan != 'proses')
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses aduan',
            ], 400);


        $kepala_bidang = User::find($request->kepala_bidang_id);

        if (!$kepala_bidang)
            return response()->json([
                'success' => false,
                'message' => 'Kepala bidang tidak ditemukan',
            ], 404);


        $aduan->update([
            'kepala_bidang_id' => $kepala_bidang->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil meneruskan aduan',
        ]);
    }

    public function verify_kepala_bidang(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $validator = Validator::make($request->all(), [
            'uraian_verifikasi' => 'required',
        ], [
            'uraian_verifikasi.required' => 'Uraian verifikasi harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $aduan = Aduan::find($id);
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);
        if ($aduan->status_aduan != 'proses')
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses aduan',
            ], 400);
        $kepala_bidang = User::find(auth()->user()->id);
        if (!$kepala_bidang)
            return response()->json([
                'success' => false,
                'message' => 'Kepala bidang tidak ditemukan',
            ], 404);

        $aduan->update([
            'verifikasi_kepala_bidang' => true,
            'tanggal_tindak_lanjut_kepala_bidang' => now(),
            'uraian_tindak_lanjut_kepala_bidang' => $request->uraian_verifikasi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Memverifikasi aduan',
        ]);

    }
}
