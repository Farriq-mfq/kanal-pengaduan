<?php

namespace App\Http\Controllers;

use App\DataTables\AduanDataTable;
use App\Models\Aduan;

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
}
