<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard');
    }

    public function json_stats(Request $request)
    {
        if (!$request->ajax()) return response()->json("not allowed", 503);
        return response()->json("ok");
    }
}
