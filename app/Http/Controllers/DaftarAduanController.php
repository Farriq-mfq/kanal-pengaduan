<?php

namespace App\Http\Controllers;

use App\DataTables\AduanDataTable;
use App\Models\Aduan;
use App\Models\Klasifikasi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $klasifikasi = Klasifikasi::all();

        return $dataTable->render('pages.aduan.index', compact('breadcrumbs', 'kepala_bidang', 'klasifikasi'));
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

        $permission = auth()->user()->getPermission();
        $searchPermission = $permission->contains('kepala bidang');
        $role = auth()->user()->role;
        if ($role != 'superAdmin') {
            if ($searchPermission) {
                $aduan = Aduan::where('kepala_bidang_id', auth()->user()->id)->findOrFail($id);
            } else {
                $aduan = Aduan::findOrFail($id);
            }
        } else {
            $aduan = Aduan::findOrFail($id);
        }


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

        if ($aduan->status_aduan != 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus aduan',
            ], 400);
        }
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

        DB::beginTransaction();
        try {
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
                'tanggal_acc' => now(),
            ]);

            // tracking aduan
            $aduan->trackings()->create([
                'status' => $aduan->status_aduan,
                'keterangan' => 'Aduan diterima oleh ' . auth()->user()->name,
                'step' => 'Diterima',
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menerima aduan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menerima aduan',
            ], 400);
        }
    }
    public function reject(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $validator = Validator::make($request->all(), [
            'alasan_penolakan' => 'required',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        DB::beginTransaction();
        try {
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
                'alasan_penolakan' => $request->alasan_penolakan
            ]);

            // tracking aduan
            $aduan->trackings()->create([
                'status' => $aduan->status_aduan,
                'keterangan' => 'Aduan ditolak oleh ' . auth()->user()->name,
                'step' => 'Ditolak',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menolak aduan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak aduan',
            ], 400);
        }
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

        // tracking aduan
        $aduan->trackings()->create([
            'status' => $aduan->status_aduan,
            'keterangan' => 'Aduan diteruskan oleh ' . auth()->user()->name . ' ke ' . $kepala_bidang->name . ' Bagian ' . $kepala_bidang->jabatan,
            'step' => 'Diteruskan ke Kepala Bidang',
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

        DB::beginTransaction();
        try {
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

            $kepala_dinas = isset($request->kepala_dinas) && parse_boolean($request->kepala_dinas) && $request->kepala_dinas ? User::role('kepala dinas')->first() ? User::role('kepala dinas')->first() : null : null;

            $aduan->update([
                'verifikasi_kepala_bidang' => true,
                'tanggal_tindak_lanjut_kepala_bidang' => now(),
                'uraian_tindak_lanjut_kepala_bidang' => $request->uraian_verifikasi,
                'kepala_dinas_id' => $kepala_dinas ? $kepala_dinas->id : null,
                'status_aduan' => $kepala_dinas ? 'proses' : 'selesai',
                'status_tindak_lanjut_kepala_bidang' => 'acc',
                'tanggal_selesai' => $kepala_dinas ? null : now(),
            ]);

            // tracking aduan
            $aduan->trackings()->create([
                'status' => $aduan->status_aduan,
                'keterangan' => 'Aduan diverifikasi oleh ' . $kepala_bidang->name . ' Bagian ' . $kepala_bidang->jabatan . ' (' . $aduan->tanggal_tindak_lanjut_kepala_bidang . ')',
                'step' => $kepala_dinas ? 'Diverifikasi oleh Kepala Bidang dan diteruskan ke Kepala Dinas' : 'Diverifikasi oleh Kepala Bidang',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Memverifikasi aduan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Gagal memverifikasi aduan",
            ], 400);
        }

    }

    public function direct_answer(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $validator = Validator::make($request->all(), [
            'text_direct_pengaduan' => 'required',
        ], [
            'text_direct_pengaduan.required' => 'Jawaban pengaduan harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        DB::beginTransaction();
        try {
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


            if ($aduan->kepala_bidang_id != null) {
                $kepala_bidang = User::find($aduan->kepala_bidang);
                if (!$kepala_bidang)
                    return response()->json([
                        'success' => false,
                        'message' => 'Masih diproses oleh kepala bidang',
                    ], 404);
            }

            $aduan->update([
                'status_aduan' => 'selesai',
                'tanggal_selesai' => now(),
                'text_direct_pengaduan' => $request->text_direct_pengaduan
            ]);

            // tracking aduan
            $aduan->trackings()->create([
                'status' => $aduan->status_aduan,
                'keterangan' => 'Aduan selesai oleh ' . auth()->user()->name,
                'step' => 'Dijawab Langsung',
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memberikan jawaban langsung',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Gagal memproses aduan",
            ], 400);
        }
    }

    public function tindak_lanjut(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $validator = Validator::make($request->all(), [
            'tindak_lanjut' => 'required',
            'kecepatan_tindak_lanjut' => 'required|in:Biasa,Segera,Amat Segera',
            'kepala_bidang_id' => 'required|exists:users,id',
        ], [
            'tindak_lanjut.required' => 'Uraian tindak lanjut harus diisi',
            'kecepatan_tindak_lanjut.required' => 'Kecepatan tindak lanjut harus diisi',
            'kepala_bidang_id.required' => 'Kepala bidang harus diisi',
            'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        DB::beginTransaction();
        try {
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

            $aduan->update([
                'tindak_lanjut' => $request->tindak_lanjut,
                'kecepatan_tindak_lanjut' => $request->kecepatan_tindak_lanjut,
                'kepala_bidang_id' => $request->kepala_bidang_id
            ]);

            $kepala_bidang = User::find($request->kepala_bidang_id);
            if (!$kepala_bidang)
                return response()->json([
                    'success' => false,
                    'message' => 'Kepala bidang tidak ditemukan',
                ], 404);
            // tracking aduan
            $aduan->trackings()->updateOrCreate([
                'step' => 'Tindak Lanjut',
            ], [
                'status' => $aduan->status_aduan,
                'keterangan' => auth()->user()->name . ' mengupdate tindak lanjut dengan meneruskan ke ' . $kepala_bidang->name . ' dengan kecepatan tindak lanjut ' . $request->kecepatan_tindak_lanjut,
                'step' => 'Tindak Lanjut',
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memberikan tindak lanjut',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Gagal memproses aduan",
            ], 400);
        }
    }

    public function telaah(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        DB::beginTransaction();
        try {
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

            $aduan->update([
                'telaah_aduan' => $request->telaah,
                'klasifikasi' => $request->klasifikasi
            ]);

            // tracking aduan
            $aduan->trackings()->updateOrCreate([
                'step' => 'Telaah',
            ], [
                'status' => $aduan->status_aduan,
                'keterangan' => auth()->user()->name . ' mengupdate telaah dan diklasifikan sebagai ' . $aduan->klasifikasi,
                'step' => 'Telaah',
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memberikan telaah',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Gagal memproses aduan",
            ], 400);
        }
    }

    public function revisi_tindak_lanjut(Request $request, string $id)
    {
        if (!$request->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
        ], [
            'keterangan.required' => 'Keterangan revisi harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        DB::beginTransaction();
        try {
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

            if ($aduan->kepala_bidang_id != auth()->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses aduan',
                ], 400);
            }

            $aduan->update([
                'status_tindak_lanjut_kepala_bidang' => 'revisi',
            ]);

            $aduan->revisi()->create([
                'keterangan' => $request->keterangan
            ]);

            // tracking aduan
            $aduan->trackings()->create([
                'step' => 'Revisi Tindak Lanjut',
                'status' => $aduan->status_aduan,
                'keterangan' => "Aduan diberikan revisi oleh " . auth()->user()->name . ' dengan revisi : ' . $request->keterangan,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memberikan revisi tindak lanjut',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Gagal memproses aduan",
            ], 400);
        }

    }
    public function kepala_bidang($id, Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);
        }
        $aduan = Aduan::find($id);
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);


        return response()->json([
            'success' => true,
            'data' => [
                'tindak_lanjut' => $aduan->tindak_lanjut,
                'kecepatan_tindak_lanjut' => $aduan->kecepatan_tindak_lanjut,
                'kepala_bidang_id' => $aduan->kepala_bidang_id
            ]
        ]);
    }


    public function verify_kepala_dinas($id, Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);
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

        if ($aduan->kepala_dinas_id != auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses aduan',
            ], 400);
        }

        $aduan->update([
            'tanggal_tindak_lanjut_kepala_dinas' => now(),
            'verifikasi_kepala_dinas' => true,
            'status_aduan' => 'selesai',
            'tanggal_selesai' => now(),
        ]);

        // tracking aduan
        $aduan->trackings()->create([
            'step' => 'Verifikasi Kepala Dinas',
            'status' => $aduan->status_aduan,
            'keterangan' => "Aduan telah diverifikasi oleh " . auth()->user()->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memproses aduan',
        ]);
    }

    public function print($id)
    {
        $aduan = Aduan::find($id);
        if (!$aduan)
            abort(404);

        $image = file_get_contents(public_path() . '/assets/img/kop.png');
        return Pdf::loadView('pages.aduan.cetak-detail', ['kop' => $image, 'aduan' => $aduan])->setPaper('folio')->download($aduan->nomer_aduan . '.pdf');
        // return view('pages.aduan.cetak-detail',['kop' => $image, 'aduan' => $aduan]);
    }
}
