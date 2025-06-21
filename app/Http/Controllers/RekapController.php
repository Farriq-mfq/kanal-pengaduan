<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
