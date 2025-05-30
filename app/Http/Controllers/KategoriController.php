<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:kategori view', only: ['index']),
            new Middleware('permission:kategori create', only: ['store']),
            new Middleware('permission:kategori update', only: ['update']),
            new Middleware('permission:kategori delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(KategoriDataTable $dataTable)
    {
        $breadcrumbs = [
            [
                'link' => route('kategori.index'),
                'name' => 'Kategori'
            ]
        ];

        return $dataTable->render('pages.kategori.index', compact('breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriRequest $request)
    {
        DB::beginTransaction();
        try {
            Kategori::create([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', $e->getMessage());
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
    public function update(KategoriRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            Kategori::find($id)->update([
                'name' => $request->name,
            ]);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            Kategori::find($id)->delete();
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kategori.index')->with('error', 'Kategori gagal dihapus');
        }
    }
}
