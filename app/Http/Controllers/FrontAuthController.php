<?php

namespace App\Http\Controllers;

use App\Http\Requests\front\LoginRequest;
use App\Http\Requests\front\RegisterRequest;
use App\Mail\SendVerificationMasyarakatMail;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FrontAuthController extends Controller
{
    public function index()
    {
        return view('front.auth.login');
    }

    public function register()
    {
        return view('front.auth.register');
    }

    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $masyarakat = Masyarakat::where('email', $request->email)->first();

        if (!$masyarakat) {
            return redirect()->back()->with('error', 'Login gagal, silahkan coba lagi');
        }

        if (!$masyarakat->verified_at) {
            return redirect()->back()->with('error', 'Login gagal, silahkan verifikasi akun anda terlebih dahulu');
        }

        if (auth('masyarakat')->attempt($credentials)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Login gagal, silahkan coba lagi');
        }
    }

    public function register_store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $masyarakat = Masyarakat::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'verification_token' => uuid_create(),
                'verification_token_expires_at' => now()->addMinutes(15),
            ]);

            $mail = new SendVerificationMasyarakatMail(base64_encode($masyarakat->verification_token));
            Mail::to($masyarakat->email)->send($mail);
            DB::commit();
            return redirect()->route('front.register')->with('success', 'Register berhasil, silahkan verifikasi akun anda');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Register gagal, silahkan coba lagi");
        }
    }

    public function verify($token)
    {
        $token = base64_decode($token);
        $masyarakat = Masyarakat::where('verification_token', $token)->first();
        if ($masyarakat) {
            $masyarakat->update([
                'verified_at' => now(),
                'verification_token' => null,
                'verification_token_expires_at' => null,
            ]);
            auth('masyarakat')->login($masyarakat);
            return redirect()->route('home')->with('success', 'Verifikasi berhasil');
        }
        return redirect()->route('home')->with('error', 'Verifikasi gagal');
    }

    public function logout()
    {
        auth('masyarakat')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }
}
