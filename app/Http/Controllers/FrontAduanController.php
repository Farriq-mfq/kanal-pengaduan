<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FrontAduanController extends Controller
{
    /*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Store a newly created aduan in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    /*******  01259c6f-12df-4412-8bff-69571c92fb37  *******/
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => "Invalid request"
            ], 503);
        }

        if (!auth()->guard('masyarakat')->check()) {
            return response()->json([
                'success' => false,
                'message' => "Anda belum login"
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'aduan' => 'required',
        ], [
            'kategori.required' => 'Kategori wajib diisi',
            'aduan.required' => 'Uraian wajib diisi',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $kategori = Kategori::where('id', $request->kategori)->first();
            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => "Kategori tidak ditemukan"
                ], 422);
            }


            $aduan = Aduan::create([
                'kategori_id' => $kategori->id,
                'uraian_pengaduan' => $request->aduan,
                'nomer_aduan' => uniqid("ADUAN-"),
                'tanggal_pengaduan' => Carbon::now(),
                'masyarakat_id' => auth()->guard('masyarakat')->user()->id
            ]);


            $aduan->trackings()->create([
                'step' => "Membuat Pengaduan",
                'status' => "menunggu",
                'keterangan' => "Anda Memuat Pengaduan",
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $aduan,
                'message' => "Pengaduan berhasil dikirim"
            ]);
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan"
            ], 500);
        }
    }

    public function tracking(Request $request)
    {
        $nomer_aduan = $request->nomer_aduan;

        if (!$nomer_aduan) {
            abort(404);
        }

        $aduan = Aduan::where('nomer_aduan', $nomer_aduan)
            ->where('masyarakat_id', auth()->guard('masyarakat')->user()->id)
            ->with('trackings', function ($q) {
                $q->orderBy('created_at', 'desc');
            })->first();
        if (!$aduan) {
            abort(404);
        }


        return view('front.aduan.tracking', compact('aduan', 'nomer_aduan'));
    }

    public function revisi($id)
    {
        $aduan = Aduan::where('id', $id)->first();

        if (!$aduan) {
            return response([
                'success' => false,
            ], 404);
        }

        return view('front.aduan.revisi', compact('aduan'))->render();

    }
}
