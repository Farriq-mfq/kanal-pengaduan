<?php

namespace App\Http\Controllers;

use App\Models\Aduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackingController extends Controller
{
    public function tracking(Request $request)
    {
        $breadcrumbs = [
            [
                'link' => route("aduan.index"),
                'name' => "Daftar Aduan"

            ],
            [
                'link' => route("tracking"),
                'name' => "Tracking Aduan"
            ]
        ];

        return view('pages.aduan.tracking', compact('breadcrumbs'));
    }

    public function json_tracking_result(Request $request)
    {
        if (!request()->ajax())
            return response()->json([
                'success' => false,
                'message' => 'Invalid request',
            ], 503);

        $validator = Validator::make($request->all(), [
            'nomor_aduan' => 'required',
        ], [
            'nomor_aduan.required' => 'Nomor aduan harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $aduan = Aduan::where('nomer_aduan', $request->nomor_aduan)->with('trackings', function ($q) {
            $q->orderBy('created_at', 'desc'); })->first();
        if (!$aduan)
            return response()->json([
                'success' => false,
                'message' => 'Aduan tidak ditemukan',
            ], 404);



        return response()->json([
            'success' => true,
            'html' => view('pages.aduan.tracking-detail', compact('aduan'))->render(),
        ], 200);
    }
}
