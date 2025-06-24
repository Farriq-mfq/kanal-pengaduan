<?php

namespace App\Http\Controllers;

use App\DataTables\MasyarakatDataTable;
use App\Exports\MasyarakatExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasyarakatController extends Controller
{
    public function index(MasyarakatDataTable $masyarakatDataTable)
    {
        $breadcrumbs = [
            [
                'link' => route('masyarakat.index'),
                'name' => 'Masyarakat'
            ]
        ];
        return $masyarakatDataTable->render('pages.masyarakat.index', compact('breadcrumbs'));
    }

    public function export()
    {
        return Excel::download(new MasyarakatExport, 'masyarakat.xlsx');
    }

}
