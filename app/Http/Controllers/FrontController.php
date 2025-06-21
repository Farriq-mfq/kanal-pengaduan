<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

    public function about()
    {
        return view('front.about');
    }

    public function panduan_kategori()
    {
        $kategori = Kategori::all();
        return view('front.panduan_kategori', compact('kategori'));
    }
}
