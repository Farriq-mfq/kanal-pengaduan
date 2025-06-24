<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FrontAduanController extends Controller
{
    public function index()
    {
        return view('front.aduan.list');
    }
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
            'lampiran' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'kategori.required' => 'Kategori wajib diisi',
            'aduan.required' => 'Uraian wajib diisi',
            'lampiran.image' => 'Lampiran harus berupa gambar',
            'lampiran.mimes' => 'Lampiran harus berupa gambar',
            'lampiran.max' => 'Lampiran maksimal 2MB',
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

            $foto = $request->file('lampiran');

            $aduan = Aduan::create([
                'kategori_id' => $kategori->id,
                'uraian_pengaduan' => $request->aduan,
                'nomer_aduan' => uniqid("ADUAN-"),
                'tanggal_pengaduan' => Carbon::now(),
                'masyarakat_id' => auth()->guard('masyarakat')->user()->id,
                'foto' => $foto ? $foto->store('aduan', 'public') : null
            ]);


            $aduan->trackings()->create([
                'step' => "Membuat Pengaduan",
                'status' => "menunggu",
                'keterangan' => "Anda Membuat Pengaduan",
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

    public function kategori()
    {
        $kategori = Kategori::all();

        $html = '<option value="">Pilih Kategori</option>';

        foreach ($kategori as $kt) {
            $html .= '<option value="' . $kt->id . '">' . $kt->name . '</option>';
        }

        return response()->json([
            'success' => true,
            'data' => $html
        ]);
    }
    public function listAduan()
    {
        $masyarakat = auth()->guard('masyarakat')->user();
        $query = Aduan::query()->where('masyarakat_id', $masyarakat->id)->orderBy('id', 'DESC');
        return DataTables::of($query)
            ->setRowId('id')
            ->addColumn('action', function (Aduan $aduan) {
                return view('front.aduan.columns._actions', compact('aduan'));
            })
            ->addIndexColumn()
            ->make(true)
        ;
    }
}
