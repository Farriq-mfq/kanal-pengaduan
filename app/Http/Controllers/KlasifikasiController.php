<?php

namespace App\Http\Controllers;

use App\DataTables\KlasifikasiDataTable;
use App\Http\Requests\KlasifikasiRequest;
use App\Models\Klasifikasi;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class KlasifikasiController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:klasifikasi view', only: ['index']),
            new Middleware('permission:klasifikasi create', only: ['store']),
            new Middleware('permission:klasifikasi update', only: ['update']),
            new Middleware('permission:klasifikasi delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(KlasifikasiDataTable $dataTable)
    {
        $breadcrumbs = [
            [
                'link' => route('klasifikasi.index'),
                'name' => 'Klasifikasi'
            ]
        ];

        return $dataTable->render('pages.klasifikasi.index', compact('breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KlasifikasiRequest $request)
    {
        DB::beginTransaction();
        try {
            Klasifikasi::create([
                'klasifikasi' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('klasifikasi.index')->with('success', 'Klasifikasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('klasifikasi.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KlasifikasiRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            Klasifikasi::find($id)->update([
                'klasifikasi' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('klasifikasi.index')->with('success', 'Klasifikasi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('klasifikasi.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();
        try {
            Klasifikasi::find($id)->delete();
            DB::commit();
            return redirect()->route('klasifikasi.index')->with('success', 'Klasifikasi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('klasifikasi.index')->with('error', 'Klasifikasi gagal dihapus');
        }
    }
}
